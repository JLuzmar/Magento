<?php  
/**
 * ContactSync extension
 *
 * @category    Icommkt
 * @package     Icommkt_ContactSync
 * @author      Yetzair Luzmar Osorio
 */
class Icommkt_ContactSync_Block_Adminhtml_ContactSyncbackend extends Mage_Adminhtml_Block_Template {
    public function __construct()
    {
        $this->_controller = 'adminhtml_contactsync';
        $this->_blockGroup = 'contactsync';
        $this->_headerText = Mage::helper('contactsync')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('contactsync')->__('Add Item');
        parent::__construct();
    }
}