<?php
class Meteorify_Obscsr {
    
    function example($observer) {
        $event = $observer->getEvent()->getName();
        if($event == "checkout_submit_all_after") {
            if(Mage::getSingleton('customer/session')->isLoggedIn()) {
                $customerEmail = Mage::getModel('customer/session')->getCustomer()->getEmail();
            }
            else {
                $order= $observer->getEvent()->getOrder();
                $customerEmail = $order->getBillingAddress()->getEmail();
            }
            
        }
        else {
            $customerEmail = $observer->getCustomer()->getEmail();
        }

        Mage::log($customerEmail);
    }

    // public function customer_address_save_before($observer)
    //{
    //    Mage::dispatchEvent($this->_eventPrefix.'_save_before', $this->_getEventData());
    //    Mage::dispatchEvent($this->_eventPrefix.'_save_after', $this->_getEventData());
    //    Mage::app()->getRequest()->getPost();
    //    //$address = $observer->getCustomerAddress();
    //    //echo "<pre>"; print_r($address->getData()); exit;
    //    // do something here
    //}
    //public function customer_save_before($observer)
    //{
    //    $customer = $observer->getCustomer();
    //    //echo "<pre>"; print_r($customer->getData()); exit;
    //    // do something here
    //}

    public function onCustomerAddressSaveAfter(Varien_Event_Observer $observer)
    {
          $customerAddress = $observer->getEvent()->getCustomerAddress()->getData();
    
     /* If the customer address exists, as $_origData of customer's address is sometimes null, we have to set it manually*/
     
    /*if (!$customerAddress->isObjectNew() && !$customerAddress->getOrigData()) {
        $customerOrigAddress = Mage::getModel('customer/address')->load($customerAddress->getId());

        foreach ($customerOrigAddress->getData() as $field => $value) {
            $customerAddress->setOrigData($field, $value);
        } 
        
    }*/
       Mage::Log($customerAddress);
       
    }
}