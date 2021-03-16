<?php

namespace Hunters\SearchShopMap\Model\ResourceModel\CompanyDb;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Hunters\SearchShopMap\Model\Company', 'Hunters\SearchShopMap\Model\ResourceModel\CompanyDb');
	}

}
