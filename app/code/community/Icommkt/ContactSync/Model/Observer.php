<?php
/**
 * ContactSync extension
 *
 * @category    Icommkt
 * @package     Icommkt_ContactSync
 * @author      Yetzair Luzmar Osorio
 */
class Icommkt_ContactSync_Model_Observer {
    
    //Se ejecuta solo cuando se registra; compra como visitante
    function getEmailFromEvent($observer) {
        //revisamos si viene de la compra como visitante o es un nuevo registro
        $event = $observer->getEvent()->getName();
        if($event == "checkout_submit_all_after") {
            if(!(Mage::getSingleton('customer/session')->isLoggedIn())) {
                $order= $observer->getEvent()->getOrder();
                $customerEmail = $order->getBillingAddress()->getEmail();
                $firstName =$order->getBillingAddress()->getFirstname();
                $lastname = $order->getBillingAddress()->getLastname();
            } 
        }
        else {
            $customerEmail = $observer->getCustomer()->getEmail();
            $firstName = $observer->getCustomer()->getFirstname();
            $lastname = $observer->getCustomer()->getLastname();
        }

        $this->sendToicommkt($customerEmail, $firstName, $lastname);
    }

    // Se ejecuta cuando finaliza checkout; cuando se actualiza informacion del cliente  desde el admin
    public function onCustomerAddressSaveAfter(Varien_Event_Observer $observer)
    {
        $customerAddress = $observer->getEvent()->getCustomerAddress()->getData();
        $customerOrigAddress = Mage::getModel('customer/customer')->load($customerAddress["customer_id"])->getData();

        //revisamos si viene de actualizar la informacion o del final del checkout
        if(isset($customerOrigAddress["firstname"])){
             $customerEmail = $customerOrigAddress["email"];
             $firstName = $customerOrigAddress["firstname"];
             $lastname = $customerOrigAddress["lastname"];
        } else {
            $customerEmail =$customerAddress["email"];
            $firstName = $customerAddress["firstname"];
            $lastname = $customerAddress["lastname"];
        }

        $this->sendToIcommkt($customerEmail, $firstName, $lastname);
    }

    //Envia datos de los usuarios a la plataforma
    public function sendToIcommkt($customerEmail, $firstName, $lastname) {        
        $model = Mage::getModel('contactsync/contactsync');
        $collection = $model->getCollection()->setPageSize(1);
        $item = $collection->getFirstItem();
        $apiKey = Mage::helper('contactsync')->__($item->getData("apikey"));
        $profileKey = Mage::helper('contactsync')->__($item->getData("profilekey"));
        $apiKey = $apiKey . ":user";

        $stringData = array(
            'ProfileKey' => $profileKey,
            'Contact' => array(
                'Email' => $customerEmail,
                'CustomFields' =>
                array(
                  array('Key' => 'Nombre', 'Value' => $firstName),
                  array('Key' => 'Apellido', 'Value' => $lastname)
                )
            )
        );

        $data = json_encode($stringData);    

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.icommarketing.com/Contacts/SaveContact.Json/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
            'Authorization: '.$apiKey.':0',
            'Access-Control-Allow-Origin: *')
        );

        $result = curl_exec($ch);
        curl_close($ch);	
        $resultobj = json_decode($result);
        Mage::Log($resultobj->{'SaveContactJsonResult'}->{'StatusCode'});
    }
}