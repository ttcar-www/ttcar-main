<?php

namespace App\ResacarApi\Data;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class CarsByDisponibilitiesManager extends AbstractResacarApi
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
        $date_pickup = (isset($this->filter['date_pickup'])) ? $this->filter['date_pickup'] : '';
        $heure_pickup = (isset($this->filter['heure_pickup'])) ? $this->filter['heure_pickup'] : '';
        $date_return = (isset($this->filter['date_return'])) ? $this->filter['date_return'] : '';
        $heure_return = (isset($this->filter['heure_return'])) ? $this->filter['heure_return'] : '';
        $veh_class = (isset($this->filter['veh_class'])) ? $this->filter['veh_class'] : '';
        $invoice_type = (isset($this->filter['invoice_type'])) ? $this->filter['invoice_type'] : '';

        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<GSI_VehCategoryRQ>
    <system_id>$this->systemId</system_id>
    <station>
        <pickup station_id="$station_id" date="$date_pickup" time="$heure_pickup" />
        <return station_id="$station_id" date="$date_return" time="$heure_return" />
    </station>
    <vehicle>
        <veh_class>$veh_class</veh_class>
    </vehicle>
    <invoice>
        <invoice_type>$invoice_type</invoice_type>
        <account_nr_c>$this->accountNr</account_nr_c>
    </invoice>
</GSI_VehCategoryRQ>

EOT;
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlData);
        $dom->formatOutput = TRUE;
        return $dom->saveXML();
    }
}