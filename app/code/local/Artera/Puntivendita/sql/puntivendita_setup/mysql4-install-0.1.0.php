<?php

$installer = $this ;

$installer->startSetup() ;

$installer->run("
CREATE TABLE {$this->getTable('puntivendita')} (
  `puntivendita_id` int(11) unsigned NOT NULL auto_increment,
  `nome` varchar(255) NOT NULL default '',
  `indirizzo` text NOT NULL default '',
  `provincia` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`puntivendita_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
") ;

$installer->endSetup() ;