<?php
  
class Icommkt_ContactSync_Model_Mysql4_ContactSync extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {  
        $this->_init('contactsync/contactsync', 'contactsync_id');
    }
} 