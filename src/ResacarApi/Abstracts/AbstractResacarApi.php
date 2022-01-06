<?php

namespace App\ResacarApi\Abstracts;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractResacarApi
{
    public abstract function getResult(): array;
    protected abstract function getXmlData(): string;

    /** @var  $apiUrl */
    private $apiUrl = 'https://www.resacar.com/xml-resacarR/xml_input.cgi';
    /** @var string $userId */
    private $userId = 'DEMO';
    /** @var string $linkId */
    private $linkId = 'key';
    /** @var string $apiPassword */
    private $apiPassword = 'Test2021';
    /** @var  HttpClientInterface $httpClient */
    private $httpClient;
    /** @var string $systemId */
    protected $systemId = 'EUC';
    /** @var int $accountNr */
    protected $accountNr = '209251';
    /** @var array $filter */
    protected $filter = [];

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    private function createToken(): string
    {
        return base64_encode($this->userId . '@' . $this->linkId . ':' . $this->apiPassword);
    }

    /**
     * @return null|\SimpleXMLElement
     */
    protected function callApi(): ?\SimpleXMLElement
    {
        $response = $this->httpClient->request('POST', $this->apiUrl, [
            'headers' => [
                'Content-Type' => 'application/xml;charset=utf-8',
                'Accept-Language' => 'fr',
                'Authorization' => 'Basic ' . $this->createToken()
            ],
            'body' => [
                'XML_LINK_ID' => $this->linkId,
                'XML_USER' => $this->userId,
                'XML_PASSWORD' => $this->apiPassword,
                'XML_LANGUAGE_ID' => 'FR',
                'XML_DATA' => $this->getXmlData()
            ]
        ]);

        if(!simplexml_load_string($response->getContent()))
            return null;

        return simplexml_load_string($response->getContent());
    }

    /**
     * @return array
     */
    public function getFilter(): array
    {
        return $this->filter;
    }

    /**
     * @param array|null $filter
     * @return array
     */
    public function setFilter(?array $filter = []): array
    {
        $this->filter = $filter;
        return $this->filter;
    }
}