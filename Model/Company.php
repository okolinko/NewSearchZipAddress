<?php

namespace Hunters\SearchShopMap\Model;

class Company extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init('Hunters\SearchShopMap\Model\ResourceModel\CompanyDb');
    }

}
