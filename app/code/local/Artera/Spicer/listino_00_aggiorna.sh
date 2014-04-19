#!/bin/sh
set -e
HOME=/home/centoufficio/public_html
HOMESPICER=$HOME/app/code/local/Artera/Spicer
FILE_XLS=$HOME/var/SpicerFile.xls
FILE_ZIP=$HOME/var/SpicerFile.zicd
cd $HOMESPICER

if [ -f $FILE_XLS ]; then
	rm $FILE_XLS
fi

wget --ftp-user=5017688 --ftp-password=yooquafofo --output-document=$FILE_ZIP  ftp://ftp.spicers.net/spicersdata/SpicerFile.zip 

if [ $? -eq 0 ]; then 
	unzip $FILE_ZIP -d $HOME/var
	rm $FILE_ZIP
	echo "Inizio Aggiornamanto file di lavoro"
	/usr/bin/php -d display_errors=on $HOMESPICER/listino_01_import_excel.php
	echo "File di lavoro aggiornato"
fi
/usr/bin/php -d display_errors=on $HOMESPICER/listino_02_allinea_prezzi.php
/usr/bin/php -d display_errors=on $HOME/shell/indexer.php reindexall
