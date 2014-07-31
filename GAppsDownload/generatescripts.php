<?php

function generatescripts($gappslist, $gappsname){
//generates 70-gapps.sh and GAppsFactory.prop and injects them into the zip

file_put_contents('70-gapps.sh', "#!/sbin/sh\n# \n# /system/addon.d/70-gapps.sh\n# \n. /tmp/backuptool.functions\n\nlist_files() {\ncat <<EOF\n");

$zip = new ZipArchive();
$zip->open($gappsname);
$allpaths = array();

for ($i = 0; $i < $zip->numFiles; $i++){
    if (substr($zip->statIndex($i)["name"], 0, 7) === "system/" && substr($zip->statIndex($i)["name"], strlen($zip->statIndex($i)["name"]) - 1, 1) != "/"){
		$allpaths[] = substr($zip->statIndex($i)["name"], 7);
	}
}

sort($allpaths);

foreach ($allpaths as $key => $val) {
    file_put_contents('70-gapps.sh', $val."\n", FILE_APPEND);
}

file_put_contents('70-gapps.sh', "EOF\n}\n\ncase \"\$1\" in\n  backup)\n    list_files | while read FILE DUMMY; do\n      backup_file \$S/\$FILE\n    done\n  ;;\n  restore)\n    list_files | while read FILE REPLACEMENT; do\n      R=\"\"\n      [ -n \"\$REPLACEMENT\" ] && R=\"\$S/\$REPLACEMENT\"\n      [ -f \"\$C/\$S/\$FILE\" ] && restore_file \$S/\$FILE \$R\n    done\n  ;;\n  pre-backup)\n    # Stub\n  ;;\n  post-backup)\n    # Stub\n  ;;\n  pre-restore)\n", FILE_APPEND);

if (in_array("GKeyboard", $gappslist) && $_POST["repstockkeyboard"] === "true"){
	file_put_contents('GAppsFactory.prop', "kb.replace=true".PHP_EOL, FILE_APPEND);
	file_put_contents('70-gapps.sh', "    rm -f /system/app/LatinIME.apk\n    rm -f /system/lib/libjni_latinime.so\n", FILE_APPEND);
} else {
	file_put_contents('GAppsFactory.prop', "kb.replace=false".PHP_EOL, FILE_APPEND);
}

if (in_array("GEL", $gappslist) && $_POST["repstocklauncher"] === "true"){
	file_put_contents('GAppsFactory.prop', "home.replace=true".PHP_EOL, FILE_APPEND);
	file_put_contents('70-gapps.sh', "    rm -f /system/priv-app/Launcher2.apk\n    rm -f /system/priv-app/Launcher3.apk\n    rm -f /system/priv-app/Trebuchet.apk\n    rm -f /system/app/Launcher2.apk\n    rm -f /system/app/Launcher3.apk\n    rm -f /system/app/Trebuchet.apk\n", FILE_APPEND);
} else {
	file_put_contents('GAppsFactory.prop', "home.replace=false".PHP_EOL, FILE_APPEND);
}

if (in_array("GCal", $gappslist) && $_POST["repstockcalendar"] === "true"){
	file_put_contents('GAppsFactory.prop', "cal.replace=true".PHP_EOL, FILE_APPEND);
	file_put_contents('70-gapps.sh', "    rm -f /system/app/Calendar.apk\n", FILE_APPEND);
} else {
	file_put_contents('GAppsFactory.prop', "cal.replace=false".PHP_EOL, FILE_APPEND);
}

if (in_array("GCam", $gappslist) && $_POST["repstockcamera"] === "true"){
	file_put_contents('GAppsFactory.prop', "cam.replace=true".PHP_EOL, FILE_APPEND);
	file_put_contents('70-gapps.sh', "    rm -f /system/app/Camera2.apk\n    rm -f /system/priv-app/Camera2.apk\n", FILE_APPEND);
} else {
	file_put_contents('GAppsFactory.prop', "cam.replace=false".PHP_EOL, FILE_APPEND);
}

if (in_array("GGallery", $gappslist) && $_POST["repstockgallery"] === "true"){
	file_put_contents('GAppsFactory.prop', "gal.replace=true".PHP_EOL, FILE_APPEND);
	file_put_contents('70-gapps.sh', "    rm -f /system/app/Gallery.apk\n    rm -f /system/priv-app/Gallery.apk\n    rm -f /system/app/Gallery2.apk\n    rm -f /system/priv-app/Gallery2.apk\n", FILE_APPEND);
} else {
	file_put_contents('GAppsFactory.prop', "gal.replace=false".PHP_EOL, FILE_APPEND);
}

if (in_array("GTTS", $gappslist) && $_POST["repstocktts"] === "true"){
	file_put_contents('GAppsFactory.prop', "tts.replace=true".PHP_EOL, FILE_APPEND);
	file_put_contents('70-gapps.sh', "    rm -f /system/app/PicoTts.apk\n", FILE_APPEND);
} else {
	file_put_contents('GAppsFactory.prop', "tts.replace=false".PHP_EOL, FILE_APPEND);
}

if (in_array("GHangouts", $gappslist) && $_POST["repstocksms"] === "true"){
	file_put_contents('GAppsFactory.prop', "sms.replace=true".PHP_EOL, FILE_APPEND);
	file_put_contents('70-gapps.sh', "    rm -f /system/priv-app/Mms.apk\n", FILE_APPEND);
} else {
	file_put_contents('GAppsFactory.prop', "sms.replace=false".PHP_EOL, FILE_APPEND);
}

if (in_array("Gmail", $gappslist) && $_POST["repstockemail"] === "true"){
	file_put_contents('GAppsFactory.prop', "email.replace=true".PHP_EOL, FILE_APPEND);
	file_put_contents('70-gapps.sh', "    rm -f /system/app/Email.apk\n", FILE_APPEND);
} else {
	file_put_contents('GAppsFactory.prop', "email.replace=false".PHP_EOL, FILE_APPEND);
}

file_put_contents('70-gapps.sh', "    # Remove apps from 'app' that need to be installed in 'priv-app' (from updater-script)\n    rm -f /system/app/CalendarProvider.apk\n    rm -f /system/app/GoogleBackupTransport.apk\n    rm -f /system/app/GoogleFeedback.apk\n    rm -f /system/app/GoogleLoginService.apk\n    rm -f /system/app/GoogleOneTimeInitializer.apk\n    rm -f /system/app/GooglePartnerSetup.apk\n    rm -f /system/app/GoogleServicesFramework.apk\n    rm -f /system/app/GmsCore.apk\n    rm -f /system/app/OneTimeInitializer.apk\n    rm -f /system/app/Phonesky.apk\n    rm -f /system/app/PrebuiltGmsCore.apk\n    rm -f /system/app/SetupWizard.apk\n    rm -f /system/app/talkback.apk\n    rm -f /system/app/Talkback.apk\n    rm -f /system/app/velvet.apk\n    rm -f /system/app/Velvet.apk\n    rm -f /system/app/Wallet.apk\n", FILE_APPEND);

file_put_contents('70-gapps.sh', "  ;;\n  post-restore)\n    # Stub\n  ;;\nesac\n", FILE_APPEND);

$zip->addFile("70-gapps.sh", "system/addon.d/70-gapps.sh");
$zip->addFile("GAppsFactory.prop", "GAppsFactory.prop");
$zip->close();

unlink("70-gapps.sh");
unlink("GAppsFactory.prop");

}

?>