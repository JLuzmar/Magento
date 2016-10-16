<?php
  
class Icommkt_ContactSync_Model_ContactSync extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('contactsync/contactsync');
    }
    /**
     * Load object data
     *
     * @param   integer $id
     * @return  Mage_Core_Model_Abstract
     */
    public function load($id, $field=null)
    {
        $resource =  $this->_getResource();
        if (!$resource) {
            throw new UnexpectedValueException('Resource instance is not available');
        }

        return parent::load($id, $field);
    }
} 