<?php

namespace App\ResacarApi\Data;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class PriceManager extends AbstractResacarApi
{
    public function getResult(): array
    {
        $data = $this->callApi();

        $priceData = [];
        $equipments = [];

        foreach( $data->fares as $fare ) {

            foreach( $fare as $price ) {
                $priceData[] = [
                    'fare_price' => round(strval(0.96 * $price['price'])),
                    'agence_price' => round(strval($price['price'])),
                    'fare_currency' => strval($price['currency']),
                    'veh_class' => strval($price->vehicle['class']),
                    'veh_type' => strval($price->vehicle['type']),
                    'veh_group' => strval($price->vehicle['group']),
                    'veh_text' => strval($price->vehicle['text']),
                    'veh_img' => strval($price->vehicle['image_url']),
                ];

                foreach( $price->equipments as $equipment ) {
                    $equipments[] = [
                        'equip_id' => strval($equipment->equipment['code']),
                        'equip_name' => strval($equipment->equipment['text']),
                        'equip_price' => strval($equipment->equipment['price']),
                        'equip_qty_max' => strval($equipment->equipment['max'])
                    ];
                }
            }
        }

        $result = [
            "price" => $priceData,
            "equipments" => $equipments
        ];

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


        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?> <GSI_MultipleQuotesRQ>
    <system_id>$this->systemId</system_id>
    <station>
        <pickup station_id="$station_id" date="$date_pickup" time="$heure_pickup" />
        <return station_id="CDGT01" date="$date_return" time="$heure_return" />
    </station>
    <vehicles>
        <vehicle class="$veh_class" type="E***" />
    </vehicles>
    <invoice corporate_nr="$this->accountNr" public_rate="Y"/>
    <quote equipments="Y"/>
</GSI_MultipleQuotesRQ>
EOT;

        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlData);
        $dom->formatOutput = TRUE;
        return $dom->saveXML();
    }
}