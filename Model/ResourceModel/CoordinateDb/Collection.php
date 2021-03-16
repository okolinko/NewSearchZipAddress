<?php

namespace Hunters\SearchShopMap\Model\ResourceModel\CoordinateDb;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Hunters\SearchShopMap\Model\ApiGoogle', 'Hunters\SearchShopMap\Model\ResourceModel\CoordinateDb');
	}

}
