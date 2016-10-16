<?php
/**
 * Icommkt_EmailExporter extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Icommkt
 * @package        Icommkt_EmailExporter
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Email model
 *
 * @category    Icommkt
 * @package     Icommkt_EmailExporter
 * @author      Ultimate Module Creator
 */
class Icommkt_EmailExporter_Model_Email extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'icommkt_emailexporter_email';
    const CACHE_TAG = 'icommkt_emailexporter_email';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'icommkt_emailexporter_email';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'email';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('icommkt_emailexporter/email');

        $users = mage::getModel('customer/customer')->getCollection()
           ->addAttributeToSelect('email');

        foreach ($users as $user)
            Mage::log($user->getData());        

    }

    /**
     * before save email
     *
     * @access protected
     * @return Icommkt_EmailExporter_Model_Email
     * @author Ultimate Module Creator
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();

        $now = Mage::getSingleton('core/date')->gmtDate();
        
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save email relation
     *
     * @access public
     * @return Icommkt_EmailExporter_Model_Email
     * @author Ultimate Module Creator
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
