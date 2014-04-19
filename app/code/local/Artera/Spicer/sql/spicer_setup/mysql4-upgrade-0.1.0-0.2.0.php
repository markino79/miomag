<?php

$spicer_sql = <<<EOMYSQL
CREATE TABLE {$this->getTable('spicercatalogo')} (
  `spicercatalogo_id` int(11) unsigned NOT NULL auto_increment,
  `modificato` varchar(2) NOT NULL default '',
  `codice_spicer` varchar(255) NOT NULL default '',
  `riferimento_originale` varchar(255) NOT NULL default '',
  `nuovo` varchar(255) NOT NULL default '',
  `stampa_logo_novita` varchar(255) NOT NULL default '',
  `pag_cat_standard` smallint(10) NOT NULL default '0',
  `let_cat_standard` varchar(255) NOT NULL default '',
  `codice_categoria` smallint(10) NOT NULL default '0',
  `nome_categoria` varchar(255) NOT NULL default '',
  `codice_gruppo` smallint(10) NOT NULL default '0',
  `nome_gruppo` varchar(255) NOT NULL default '',
  `codice_sottogruppo` smallint(10) NOT NULL default '0',
  `nome_sottogruppo` varchar(255) NOT NULL default '',
  `codice_brand` smallint(10) NOT NULL default '0',
  `nome_brand` varchar(255) NOT NULL default '',
  `id_loghi` varchar(255) NOT NULL default '',
  `codice_prodotto` varchar(255) NOT NULL default '',
  `nome_prodotto` text NOT NULL default '',
  `descizione_breve` text NOT NULL default '',
  `descizione_estesa` text NOT NULL default '',
  `unita_vendita` varchar(255) NOT NULL default '',
  `qta_x_unita` smallint(10) NOT NULL default '0',
  `immagine` varchar(255) NOT NULL default '',
  `prezzo_al_pubblico` decimal(10,2) NOT NULL default '0',
  `elenco_attributi` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`spicercatalogo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 
EOMYSQL;

$installer = $this ;

$installer->startSetup() ;

$installer->run($spicer_sql) ;

$installer->endSetup() ;  