<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('movimenti')};
-- DROP TABLE IF EXISTS {$this->getTable('magazzini')};

CREATE TABLE {$this->getTable('magazzini')}(
  `id` int(11) unsigned NOT NULL auto_increment,
  `nome` varchar(255) NOT NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE {$this->getTable('movimenti')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(11) unsigned NOT NULL ,
  `qta` decimal(10.2) NOT NULL ,
  `segno` char(1) NOT null ,
  `id_magazzino` int(11) unsigned NOT NULL ,
  `user` varchar(255) NOT NULL,
  `note` text NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE totali_magazzini (
	`id` int(11) unsigned NOT NULL auto_increment,
	`product_id` int(11) unsigned NOT NULL ,
	`id_magazzino` int(11) unsigned NOT NULL ,
	`qta` decimal(10.2) NOT NULL ,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  {$this->getTable('movimenti')} ADD INDEX (  `id_magazzino` ) ;
ALTER TABLE  {$this->getTable('movimenti')} ADD FOREIGN KEY (  `id_magazzino` ) REFERENCES  `magazzini` (`id`) 
ON DELETE RESTRICT ON UPDATE RESTRICT ;
    ");

$installer->endSetup(); 