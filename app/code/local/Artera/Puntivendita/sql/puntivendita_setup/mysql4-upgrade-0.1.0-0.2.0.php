<?php

$installer = $this ;

$installer->startSetup() ;

$installer->run("
CREATE TABLE {$this->getTable('caramelle')} (
  `caramelle_id` int(11) unsigned NOT NULL auto_increment,
  `nome` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`caramelle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
") ;

$installer->endSetup() ; 
