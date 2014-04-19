#!/bin/sh
#cd /home/obietcom/scripts/import/
ROWS=$(echo "SELECT count(*) FROM spicercatalogo WHERE status=0" | mysql --defaults-file=~/.mylogin.cnf -s)
echo $ROWS da aggiornare ;
for ((i=0; i<$((ROWS/100+1)); i++)); do
 /usr/bin/php -d display_errors=on in_catalogo.php ;
done 

#ROWS=$(echo "SELECT count(*) FROM spicer WHERE status=0" | mysql --defaults-file=~/.mylogin.cnf -s)
#echo $ROWS da aggiornare ;
#for ((i=0; i<$((ROWS/100+1)); i++)); do
# /usr/bin/php -d display_errors=on allinea_prezzi.php ;
#done 
 
