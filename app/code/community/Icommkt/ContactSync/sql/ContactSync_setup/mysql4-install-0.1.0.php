<?php
  
$installer = $this;
  
$installer->startSetup();
  
$installer->run("
  
-- DROP TABLE IF EXISTS {$this->getTable('contactsync')};
CREATE TABLE {$this->getTable('contactsync')} (
  `contactsync_id` int(11) unsigned NOT NULL auto_increment,
  `apikey` varchar(255) NOT NULL default '',
  `profilekey` varchar(255) NOT NULL default '',
  PRIMARY KEY (`contactsync_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
    ");
  
$installer->endSetup(); 