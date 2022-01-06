<?php

namespace App\ResacarApi\Data;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class StationsManager extends AbstractResacarApi
{
    public function getResult(): array
    {
        $data = $this->callApi();
        $result = [];
        foreach ($data->station_list->station as $station) {
            $result[] = [
                'station_id' => strval($station->station_id),
                'station_name' => strval($station->station_name),
                'station_city' => strval($station->station_city),
                'country_name' => strval($station->country_name),
                'country_id' => strval($station->country_id),
                'address_1' => strval($station->address_1),
                'phone' => strval($station->phone),
                'fax' => strval($station->fax),
                'email' => strval($station->email)
            ];
        }
        return $result;
    }

    protected function getXmlData(): string
    {
        $iata = (isset($this->filter['iata'])) ? $this->filter['iata'] : '';
        $gds = (isset($this->filter['gds'])) ? $this->filter['gds'] : '';
        $station_id = (isset($this->filter['station_id'])) ? $this->filter['station_id'] : '';
        $station_type = (isset($this->filter['station_type'])) ? $this->filter['station_type'] : '';
        $veh_class = (isset($this->filter['veh_class'])) ? $this->filter['veh_class'] : '';
        $country_id = (isset($this->filter['country_id'])) ? $this->filter['country_id'] : '';
        $zip_code = (isset($this->filter['zip_code'])) ? $this->filter['zip_code'] : '';
        $city = (isset($this->filter['city'])) ? $this->filter['city'] : '';

        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<GSI_StationRQ>
  <system_id>$this->systemId</system_id>
  <iata>$iata</iata>
  <gds>$gds</gds>
  <station_id>$station_id</station_id>
  <station_type>$station_type</station_type>
  <veh_class>$veh_class</veh_class>
  <country_id>$country_id</country_id>
  <zip_code>$zip_code</zip_code>
  <city>$city</city>
  <search type_2="S" delivery="Y" collection="Y" return_after_hours="Y" distance="10" quantity="20"/>
</GSI_StationRQ>
EOT;
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlData);
        $dom->formatOutput = TRUE;
        return $dom->saveXML();
    }
}