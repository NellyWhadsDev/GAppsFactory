#! /bin/bash
#
#  BackupScripter.sh
# Backup Script Generator for GAppsFactory.com
# Generates Backup Script for GApps and moves to addon.d
# Run in root of zip
#

echo "Adding start of script"
echo "#!/sbin/sh
# 
# /system/addon.d/70-gapps.sh
#
. /tmp/backuptool.functions

list_files() {
cat <<EOF" >> 70-gapps.sh

echo "Adding each file"
cd system
find . -type f | cut -c 3- >> '../70-gapps.sh'
cd ..

echo "Adding pre-backup, post-baskup, pre-restore stub"
echo "EOF
}

case \"\$1\" in
  backup)
    list_files | while read FILE DUMMY; do
      backup_file \$S/\$FILE
    done
  ;;
  restore)
    list_files | while read FILE REPLACEMENT; do
      R=\"\"
      [ -n \"\$REPLACEMENT\" ] && R=\"\$S/\$REPLACEMENT\"
      [ -f \"\$C/\$S/\$FILE\" ] && restore_file \$S/\$FILE \$R
    done
  ;;
  pre-backup)
    # Stub
  ;;
  post-backup)
    # Stub
  ;;
  pre-restore)" >> 70-gapps.sh

echo "Google Home Check"
if test -e "system/app/Home.apk";
	then 
	echo "    # Remove the stock/AOSP Launcher
    rm -f /system/priv-app/Launcher*.apk
    rm -f /system/priv-app/Trebuchet.apk
    rm -f /system/app/Launcher*.apk
    rm -f /system/app/Trebuchet.apk
        " >> 70-gapps.sh
	else 
	echo "    # Launcher not removed
	" >> 70-gapps.sh
fi

echo "Google Keyboard Check"
if test -e "system/app/Keyboard.apk";
	then 
	echo "    # Remove the stock/AOSP Keyboard
    rm -f /system/app/LatinIME.apk
    rm -f /system/lib/libjni_latinimegoogle.so
    rm -f /system/lib/libjni_latinime.so
    rm -f /system/app/GoogleLatinIme.apk
	" >> 70-gapps.sh
	else 
	echo "    # Keyboard not removed
	" >> 70-gapps.sh
fi

echo "Other files to delete"
echo "    # Remove apps from 'app' that need to be installed in 'priv-app' (from updater-script)
    rm -f /system/app/CalendarProvider.apk
    rm -f /system/app/GoogleBackupTransport.apk
    rm -f /system/app/GoogleFeedback.apk
    rm -f /system/app/GoogleLoginService.apk
    rm -f /system/app/GoogleOneTimeInitializer.apk
    rm -f /system/app/GooglePartnerSetup.apk
    rm -f /system/app/GoogleServicesFramework.apk
    rm -f /system/app/GmsCore.apk
    rm -f /system/app/OneTimeInitializer.apk
    rm -f /system/app/Phonesky.apk
    rm -f /system/app/PrebuiltGmsCore.apk
    rm -f /system/app/SetupWizard.apk
    rm -f /system/app/talkback.apk
    rm -f /system/app/Talkback.apk
    rm -f /system/app/velvet.apk
    rm -f /system/app/Velvet.apk
    rm -f /system/app/Wallet.apk" >> 70-gapps.sh

echo "Finisheing script"
echo "  ;;
  post-restore)
    # Stub
  ;;
esac" >> 70-gapps.sh

if test -e "system/addon.d";
	then 
	echo "addon.d already exists"
	else 
	echo "Creating addon.d"
	mkdir system/addon.d
fi

echo "Copying backup script to addon.d"
mv -f 70-gapps.sh system/addon.d/70-gapps.sh

echo "Complete"
