<?php

namespace Hunters\SearchShopMap\Helper;

use Hunters\SearchShopMap\Service\SearchZip;

class Cord
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $searchZip;
    protected $_CompanyFactory;
    protected $connection;

    public function __construct(
        \Magento\Framework\Filesystem\Driver\File $driverFile,
        \Hunters\SearchShopMap\Model\CompanyFactory $CompanyFactory,
        \Magento\Framework\App\ResourceConnection $connection,
        SearchZip $searchZip
    ) {
        $this->searchZip = $searchZip;
        $this->driverFile = $driverFile;
        $this->_CompanyFactory = $CompanyFactory;
        $this->connection = $connection;
    }

    public function getMyCompanyCollection()
    {
        $Company = $this->_CompanyFactory->create();
        $collection = $Company->getCollection();
        return $collection;
    }

    public function ArrayCordAndOther($collection)
    {
        sleep(0.1);
        $resultArray = array();
        $resultArray['company_name'] = $collection['company_name'];
        $resultArray['street'] = $collection['street'];
        $resultArray['postcode'] = $collection['postcode'];
        $resultArray['telephone'] = $collection['telephone'];
        $resultArray['coordinate'] = $this->searchZip->getApiAddresGoogle($collection['city']." + ".$collection['street']);

        return $resultArray;
    }

    public function writeArrayAddres($collection)
    {
        if (!empty($collection)) {
            $result = array_map(array($this, 'ArrayCordAndOther'), $collection);
            $new_array = array_filter($result, function ($element) {
                if ($element != NULL) {
                    return $element;
                }
            });
            return $new_array;
        }
        return NULL;
    }

    public function arraycollection($collection)
    {   $result = array();
        $count = count(array_values($collection));
        for ($i = 0; $i < $count; $i++) {
            $result[$i]['company_name'] = $collection[$i]['company_name'];
            $result[$i]['street'] = $collection[$i]['street'];
            $result[$i]['postcode'] = $collection[$i]['postcode'];
            $result[$i]['street'] = $collection[$i]['street'];
            $result[$i]['telephone'] = $collection[$i]['telephone'];
            $result[$i]['city'] = $collection[$i]['city'];
        }
        return $result;
    }

    public function addresCompany()
    {
        $collection = $this->getMyCompanyCollection()->getData();
        $arr = $this->arraycollection($collection);
        $result = $this->writeArrayAddres($arr);
        return $result;
    }
}