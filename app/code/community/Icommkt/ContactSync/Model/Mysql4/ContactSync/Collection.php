<?php
  
class Icommkt_ContactSync_Model_Mysql4_ContactSync_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('contactsync/contactsync');
    }
} 