<?php
/**
 * ContactSync extension 
 *
 * @category    Icommkt
 * @package     Icommkt_ContactSync 
 * @author      Yetzair Luzmar Osorio
 */
class Icommkt_ContactSync_Adminhtml_ContactsyncbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('contactsync/contactsyncbackend');
      
        $model = Mage::getModel('contactsync/contactsync');
        $collection = $model->getCollection()->setPageSize(1);
        $item = $collection->getFirstItem();
        $apiKey = Mage::helper('contactsync')->__($item->getData("apikey"));
        $profileKey = Mage::helper('contactsync')->__($item->getData("profilekey"));
        Mage::register('apiKey', $apiKey);
        Mage::register('profileKey', $profileKey);

        $this->renderLayout();
    }

    public function saveAction(){
        //Mage::Log("Save method");
        $id = 1;
        $model = Mage::getModel('contactsync/contactsync');
        if (!$model) {
            throw new UnexpectedValueException('Expected Model not available.');
        }

        $apiKey = $this->getRequest()->getPost('apikey');
        $profileKey = $this->getRequest()->getPost('profilekey');
        //Data
        $data = array('apikey'=> $apiKey, 'profilekey' => $profileKey);
        $exists = $model->load($id);
        //If not exists any data saved previously
        if(!$exists->getId())
        {
            try {
                    $model = Mage::getModel('contactsync/contactsync')->setData($data);
                    $insertId = $model->save()->getId();
                    Mage::Log("Data successfully inserted. Insert ID: ".$insertId);
                } catch (Exception $e){
                 Mage::Log($e->getMessage());   
            }
        }
        else {
            try {
                $model->addData($data);
                $model->setId($id)->save();
                 Mage::Log("Data updated successfully.");
       
            } catch (Exception $e){
                 Mage::Log($e->getMessage()); 
            }
        }
        $this->_redirect('*/*/index');
    }
}
