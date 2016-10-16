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
 * Admin search model
 *
 * @category    Icommkt
 * @package     Icommkt_EmailExporter
 * @author      Ultimate Module Creator
 */
class Icommkt_EmailExporter_Model_Adminhtml_Search_Email extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Icommkt_EmailExporter_Model_Adminhtml_Search_Email
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('icommkt_emailexporter/email_collection')
            ->addFieldToFilter('email', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $email) {
            $arr[] = array(
                'id'          => 'email/1/'.$email->getId(),
                'type'        => Mage::helper('icommkt_emailexporter')->__('Email'),
                'name'        => $email->getEmail(),
                'description' => $email->getEmail(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/emailexporter_email/edit',
                    array('id'=>$email->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
