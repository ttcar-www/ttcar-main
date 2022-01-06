<?php

namespace App\ResacarApi\Data;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class OpeningHoursManager extends AbstractResacarApi
{
    public function getResult(): array
    {
        $data = $this->callApi();
        $result = [];
        foreach ($data->opening_list->opening_hours as $opening_hour) {
            $opening_hourAttributes = $opening_hour->attributes();
            $result[] = [
                'self_service' => strval($opening_hourAttributes['self_service']),
                'date_min' => strval($opening_hour->date_min),
                'date_max' => strval($opening_hour->date_max),
                'hour_min' => strval($opening_hour->hour_min),
                'hour_max' => strval($opening_hour->hour_max),
            ];
        }
        return $result;
    }

    protected function getXmlData(): string
    {
        $station_id = (isset($this->filter['station_id'])) ? $this->filter['station_id'] : '';

        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<GSI_OpeningHourRQ>
    <system_id>$this->systemId</system_id>
    <station_id>$station_id</station_id>
</GSI_OpeningHourRQ>
EOT;
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlData);
        $dom->formatOutput = TRUE;
        return $dom->saveXML();
    }
}