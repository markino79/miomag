#!/bin/sh
#cd /home/obietcom/scripts/import/
/usr/bin/php -d display_errors=on import_excel_listino.php ;
/usr/bin/php -d display_errors=on indici_stop.php ;

ROWS=$(echo "SELECT count(*) FROM spicer WHERE status=0" | mysql --defaults-file=~/.mylogin.cnf -s)
echo $ROWS da aggiornare ;
for ((i=0; i<$((ROWS/100+1)); i++)); do
 /usr/bin/php -d display_errors=on allinea_prezzi.php ;
done 

/usr/bin/php -d display_errors=on indici_start.php ;