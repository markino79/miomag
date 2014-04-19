#!/bin/sh
set -e

LOCAL_FILE_IMG_ZIP=../../../../../media/catalog/product/images.zip
LOCAL_DIR_IMG=../../../../../media/catalog/product/Spicer
LOCAL_FILE_CATALOG_XLS=../../../../../var/SpicerCatalog.xls
FTP_DIR_CATALOG=db%20ecommerce%202012
FTP_DIR_IMAGES=immagini%20e%20loghi%20db%20e%20commerce
FTP_FILE_CATALOG_xls=Cat2012.xls

wget --ftp-user=T5000000 --ftp-password=iayeefah --output-document=$LOCAL_FILE_IMG_ZIP  ftp://ftp.spicers.net/$FTP_DIR_IMAGES/images_2012.zip
if [ -f $LOCAL_FILE_IMG_ZIP ]; then 
		echo scompatto le immagini
		unzip -oq $LOCAL_FILE_IMG_ZIP -d $LOCAL_DIR_IMG 
		echo immagini pronte
fi
wget --ftp-user=5017688 --ftp-password=yooquafofo --output-document=$LOCAL_FILE_CATALOG_XLS ftp://ftp.spicers.net/$FTP_DIR_CATALOG/$FTP_FILE_CATALOG_xls
if [ $? -eq 0 ]; then 
	echo "Inizio Aggiornamanto file di lavoro"
	/usr/bin/php -d display_errors=on catalogo_01_import_excel.php
	echo "File di lavoro aggiornato"
fi