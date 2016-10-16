<?php
 class Meteorify_Observerexample_ObserverexampleController extends  Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();       

        $this->renderLayout();

        echo $this->getLayout()->createBlock('core/template')->setTemplate('observerexample/index.phtml')->toHtml(); 
        //get the right handler
        Mage::Log($this->getLayout()->getUpdate()->getHandles());
    }
}   
