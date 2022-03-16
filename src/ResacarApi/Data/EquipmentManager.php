<?php

namespace App\ResacarApi\Data;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class EquipmentManager extends AbstractResacarApi
{
    public function getResult(): array
    {
        $data = $this->callApi();
        $result = [];




        $vehicles = [];
        foreach( $data->vehicle_list->vehicle as $vehicle ) {
            $vehicleAttributes = $vehicle->attributes();
            $vehicles[] = [
                'self_service' => strval($vehicleAttributes['self_service']),
                'veh_class' => strval($vehicle->veh_class),
                'veh_type' => strval($vehicle->veh_type),
                'veh_group' => strval($vehicle->veh_group),
                'veh_text' => strval($vehicle->veh_text),
            ];
        }

        $equipments = [];
        foreach( $data->equipment_list as $equipment ) {
            $equipments[] = [
                'equip_id' => strval($equipment->equip_id),
                'equip_name' => strval($equipment->equip_name),
                'equip_qty_max' => strval($equipment->equip_qty_max)
            ];
        }

        $rates = [];
        foreach( $data->rate_list as $rate ) {
            $rates[] = [
                'rate_code' => strval($rate->equip_id),
                'rate_name' => strval($rate->equip_name)
            ];
        }

        $result = [
            "vehicles" => $vehicles,
            "equipments" => $equipments,
            "rates" => $rates
        ];

        return $result;
    }

    protected function getXmlData(): string
    {
        $station_id = (isset($this->filter['station_id'])) ? $this->filter['station_id'] : '';

        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?> <GSI_VehAvailRQ>
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