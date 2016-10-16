<?php
class SilkSoftware_TestModule_Adminhtml_TestmodulebackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Icommkt plugin"));
	   $this->renderLayout();
    }
}