<?php

namespace App\ResacarApi\Data;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class CarsManager extends AbstractResacarApi
{
    public function getResult(): array
    {
        $data = $this->callApi();
        $result = [];
        foreach ($data->vehicle_list->vehicle as $vehicle) {
            $vehicleAttributes = $vehicle->attributes();
            $result[] = [
                'self_service' => strval($vehicleAttributes['self_service']),
                'veh_class' => strval($vehicle->veh_class),
                'veh_type' => strval($vehicle->veh_type),
                'veh_group' => strval($vehicle->veh_group),
                'veh_text' => strval($vehicle->veh_text),
            ];
        }
        return $result;
    }

    protected function getXmlData(): string
    {
        $station_id = (isset($this->filter['station_id'])) ? $this->filter['station_id'] : '';

        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<GSI_VehAvailRQ>
    <system_id>$this->systemId</system_id>
    <station_id>$station_id</station_id>
</GSI_VehAvailRQ>
EOT;
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlData);
        $dom->formatOutput = TRUE;
        return $dom->saveXML();
    }
}