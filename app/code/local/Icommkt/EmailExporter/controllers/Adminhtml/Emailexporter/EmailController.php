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
 * Email admin controller
 *
 * @category    Icommkt
 * @package     Icommkt_EmailExporter
 * @author      Ultimate Module Creator
 */
class Icommkt_EmailExporter_Adminhtml_Emailexporter_EmailController extends Icommkt_EmailExporter_Controller_Adminhtml_EmailExporter
{
    /**
     * init the email
     *
     * @access protected
     * @return Icommkt_EmailExporter_Model_Email
     */
    protected function _initEmail()
    {
        $emailId  = (int) $this->getRequest()->getParam('id');
        $email    = Mage::getModel('icommkt_emailexporter/email');
        if ($emailId) {
            $email->load($emailId);
        }
        Mage::register('current_email', $email);
        return $email;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('icommkt_emailexporter')->__('Icommkt - Email Exporter'))
             ->_title(Mage::helper('icommkt_emailexporter')->__('Emails'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit email - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $emailId    = $this->getRequest()->getParam('id');
        $email      = $this->_initEmail();
        if ($emailId && !$email->getId()) {
            $this->_getSession()->addError(
                Mage::helper('icommkt_emailexporter')->__('This email no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getEmailData(true);
        if (!empty($data)) {
            $email->setData($data);
        }
        Mage::register('email_data', $email);
        $this->loadLayout();
        $this->_title(Mage::helper('icommkt_emailexporter')->__('Icommkt - Email Exporter'))
             ->_title(Mage::helper('icommkt_emailexporter')->__('Emails'));
        if ($email->getId()) {
            $this->_title($email->getEmail());
        } else {
            $this->_title(Mage::helper('icommkt_emailexporter')->__('Add email'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new email action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save email - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('email')) {
            try {
                $email = $this->_initEmail();
                $email->addData($data);
                $email->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('icommkt_emailexporter')->__('Email was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $email->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setEmailData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('icommkt_emailexporter')->__('There was a problem saving the email.')
                );
                Mage::getSingleton('adminhtml/session')->setEmailData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('icommkt_emailexporter')->__('Unable to find email to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete email - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $email = Mage::getModel('icommkt_emailexporter/email');
                $email->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('icommkt_emailexporter')->__('Email was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('icommkt_emailexporter')->__('There was an error deleting email.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('icommkt_emailexporter')->__('Could not find email to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete email - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $emailIds = $this->getRequest()->getParam('email');
        if (!is_array($emailIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('icommkt_emailexporter')->__('Please select emails to delete.')
            );
        } else {
            try {
                foreach ($emailIds as $emailId) {
                    $email = Mage::getModel('icommkt_emailexporter/email');
                    $email->setId($emailId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('icommkt_emailexporter')->__('Total of %d emails were successfully deleted.', count($emailIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('icommkt_emailexporter')->__('There was an error deleting emails.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $emailIds = $this->getRequest()->getParam('email');
        if (!is_array($emailIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('icommkt_emailexporter')->__('Please select emails.')
            );
        } else {
            try {
                foreach ($emailIds as $emailId) {
                $email = Mage::getSingleton('icommkt_emailexporter/email')->load($emailId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d emails were successfully updated.', count($emailIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('icommkt_emailexporter')->__('There was an error updating emails.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'email.csv';
        $content    = $this->getLayout()->createBlock('icommkt_emailexporter/adminhtml_email_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'email.xls';
        $content    = $this->getLayout()->createBlock('icommkt_emailexporter/adminhtml_email_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'email.xml';
        $content    = $this->getLayout()->createBlock('icommkt_emailexporter/adminhtml_email_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('icommkt_emailexporter/email');
    }
}
