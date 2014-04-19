<?php

$installer = $this ;

$installer->startSetup() ;

$installer->run("
CREATE TABLE {$this->getTable('importproduct')} (
  `importproduct_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL default '',
  `description_short` varchar(255) NOT NULL default '',
  `code` varchar(16) NOT NULL default '',
  `weight` decimal(10,3) NOT NULL default '0',
  `code_original` varchar(255) NOT NULL default '',
  `price` decimal(10,2) NOT NULL default '0',
  `cost` decimal(10,2) NOT NULL default '0',
  `image` varchar(255) NOT NULL default '',
  `stock_qty` int(11) unsigned NOT NULL default '0',
  `category_id` varchar(255) NOT NULL default '',
  `is_processed` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `message` text NOT NULL default '',
  PRIMARY KEY (`importproduct_id`)
 ENGINE=InnoDB DEFAULT CHARSET=utf8;
") ;

$installer->endSetup() ;