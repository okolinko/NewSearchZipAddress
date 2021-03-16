<?php

namespace Hunters\SearchShopMap\Service;

use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;

class SearchZip
{
	/**
	 * @var \Magento\Framework\App\ResourceConnection
	 */
	protected $connection;
	private $clientFactory;

    const API_REQUEST_URI = 'https://maps.googleapis.com/';
    const API_KEY = 'AIzaSyBSiWyPtBS2Esy_ObhOSQJT81AfU3jyXcQ';

	public function __construct(
		\Magento\Framework\App\ResourceConnection $connection,
		ClientFactory $clientFactory
	)
    {
		$this->clientFactory = $clientFactory;
		$this->connection = $connection;
	}

    public function validateZipCode($zipCode)
    {
        if (preg_match('/^[0-9]{5}(-[0-9]{4})?$/', $zipCode))
            return true;
        else
            return false;
    }

    public function getApiGoogle($zip)
    {
	    $res = array();
	    if ($this->validateZipCode($zip)) {
            $client = $this->clientFactory->create(['config' => [
                'base_uri' => self::API_REQUEST_URI
            ]]);
            $params = [
                'query' => [
                    'components' => 'postal_code:' . $zip,
                    'key' => self::API_KEY
                ]
            ];
            $response = null;
            try {
                $response = $client->request(
                    'GET',
                    'maps/api/geocode/json?',
                    $params
                );
            } catch (GuzzleException $exception) {
                return $exception->getMessage();
            }
            if ($responseData = $response->getBody()->getContents()){
                $responseDataArray = json_decode($responseData, true);
                $res['postcode'] = $zip;
                if (!$responseDataArray['results']){
                    return NULL;
                }
                $res['state'] = $responseDataArray['results'][0]['address_components'][2]['long_name'];
                $res['coordinate'] = $responseDataArray['results'][0]['geometry']['location'];
                return json_encode($res);
            }
            else {
                return NULL;
            }
        }
	    else {
            return NULL;
        }
    }

    public function getApiAddresGoogle($addres)
    {
        $res = array();

        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);
            $params = [
                'query' => [
                    'address' => $addres,
                    'key' => self::API_KEY
                ]
            ];
            $response = null;
            try {
                $response = $client->request(
                    'GET',
                    'maps/api/geocode/json?',
                    $params
                );
            } catch (GuzzleException $exception) {
                return $exception->getMessage();
            }
            if ($responseData = $response->getBody()->getContents()){
                $responseDataArray = json_decode($responseData, true);

                if (!$responseDataArray['results']){
                    return NULL;
                }
                return \GuzzleHttp\json_encode($responseDataArray['results'][0]['geometry']['location']);
            }
            else {
                return NULL;
            }

    }
}