<?php

/**
 *
 * @category   Ebizmarts
 * @package    Ebizmarts_Autoresponder
 * @author     Ebizmarts Team <info@ebizmarts.com>
 * @license    http://opensource.org/licenses/osl-3.0.php
 */

class Ebizmarts_Autoresponder_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Logging facility
     *
     * @param mixed $data Message to save to file
     * @param string $filename log filename, default is <Ebizmarts_Autoresponder.log>
     * @return Mage_Core_Model_Log_Adapter
     */
    public function log($data, $filename = 'Ebizmarts_Autoresponder.log')
    {
        if($this->config('enable_log') != 0) {
            return Mage::getModel('core/log_adapter', $filename)->log($data);
        }
    }

    public function getLists()
    {
        $types = array();
        $storeId = Mage::app()->getStore()->getStoreId();
        $lists = Mage::getConfig()->getNode('default/ebizmarts_autoresponder')->asArray();
        $lists['abandonedcart'] = array('listname'=>'Abandoned Carts List');
        foreach ($lists as $key =>$data) {
            if(isset($data['listname'])) {
                if(Mage::getStoreConfig("ebizmarts_autoresponder/$key/active",$storeId)||($key=='abandonedcart'&&Mage::getStoreConfig("ebizmarts_abandonedcart/general/active",$storeId))) {
                    $types[$key]['listname'] = (string)$data['listname'];
                    $collection = Mage::getModel('ebizmarts_autoresponder/unsubscribe')->getCollection();
                    $email = $this->_getEmail();
                    $collection->addFieldToFilter('main_table.email',array('eq'=>$email))
                        ->addFieldToFilter('main_table.list',array('eq'=>$key))
                        ->addFieldToFilter('main_table.store_id',array('eq'=>$storeId));
                    if($collection->getSize() > 0) {
                        $types[$key]['checked'] = "";
                    }
                    else {
                        $types[$key]['checked'] = "checked";
                    }
                }
            }
        }
        return $types;
    }
    protected function _getEmail()
    {
        return Mage::helper('customer')->getCustomer()->getEmail();
    }

}