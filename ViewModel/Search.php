<?php
namespace Hunters\SearchShopMap\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Hunters\SearchShopMap\Service\SearchZip;
use GuzzleHttp\ClientFactory;
use Magento\Framework\DB\Ddl\Table;
use Hunters\SearchShopMap\Helper\Cord;

class Search implements ArgumentInterface
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $connection;
    protected $searchZip;
    protected $_ApiGoogleFactory;
    protected $_registry;
    protected $cord;
    private $clientFactory;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $connection,
        ClientFactory $clientFactory,
        \Hunters\SearchShopMap\Model\ApiGoogleFactory $ApiGoogleFactory,
        \Magento\Framework\Registry $registry,
        SearchZip $searchZip,
        Cord $cord
    )
    {
        $this->clientFactory = $clientFactory;
        $this->connection = $connection;
        $this->searchZip = $searchZip;
        $this->_ApiGoogleFactory = $ApiGoogleFactory;
        $this->_registry = $registry;
        $this->cord = $cord;
    }

    public function getMyCustomCollection()
    {
        $ApiGoogle = $this->_ApiGoogleFactory->create();
        $collection = $ApiGoogle->getCollection();
        return $collection;
    }

    public function coordinateArray($myCollection)
    {
        $result = array();
        $count = count(array_values($myCollection));
        for ($i = 0; $i < $count; $i++) {
            if (!empty($myCollection[$i]['coordinate']) && !empty($myCollection[$i]['company_name']) && !empty($myCollection[$i]['telephone']) && !empty($myCollection[$i]['street'] && !empty($myCollection[$i]['postcode']))){
                $result[$i]['coordinate'] = ($myCollection[$i]['coordinate']);
                $result[$i]['company_name'] = $myCollection[$i]['company_name'];
                $result[$i]['telephone'] = $myCollection[$i]['telephone'];
                $result[$i]['street'] = $myCollection[$i]['street'];
                $result[$i]['postcode'] = $myCollection[$i]['postcode'];
            }
        }
        return array_values($result);
    }

}