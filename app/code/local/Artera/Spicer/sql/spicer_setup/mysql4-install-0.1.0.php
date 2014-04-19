<?php
$spicer_sql = <<<EOMYSQL
CREATE TABLE {$this->getTable('spicer')} (
  `spicer_id` int(11) unsigned NOT NULL auto_increment,
  `codice_articolo` varchar(255) NOT NULL default '',
  `descrizione_oscarnet` text NOT NULL default '',
  `riferimento_originale` varchar(255) NOT NULL default '',
  `marchio` varchar(255) NOT NULL default '',
  `codice_categoria` smallint(10) NOT NULL default '0',
  `categoria` varchar(255) NOT NULL default '',
  `codice_gruppo` smallint(10) NOT NULL default '0',
  `gruppo` varchar(255) NOT NULL default '',
  `prezzo_fascia_listino` decimal(10,2) NOT NULL default '0',
  `prezzo_promo` decimal(10,2) NOT NULL default '0',
  `data_inizio_promo` smallint(6) NOT NULL default '0',
  `data_fine_promo` smallint(6) NOT NULL default '0',
  `variazione_prezzo` varchar(1) NOT NULL default '',
  `variazione_qta` varchar(1) NOT NULL default '',
  `eliminato` varchar(1) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`spicer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 
EOMYSQL;

$installer = $this ;

$installer->startSetup() ;

$installer->run($spicer_sql) ;

$installer->endSetup() ; 
