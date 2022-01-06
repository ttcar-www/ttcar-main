<?php

namespace App\ResacarApi\Booking;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class DeleveryAddressesManager extends AbstractResacarApi
{
    public function getResult(): array
    {
        $data = $this->callApi();
        $result = [];
        if(!isset($data->place_list->place)) return $result;
        foreach ($data->place_list->place as $place) {
            $result[] = [
                'place_id' => strval($place->place_id),
                'name' => strval($place->name),
                'address_1' => strval($place->address_1),
                'address_2' => strval($place->address_2),
                'address_3' => strval($place->address_3),
                'zip_code' => strval($place->zip_code),
                'phone' => strval($place->phone),
                'contact' => strval($place->contact),
                'instruction' => strval($place->instruction),
                'station_id' => strval($place->station_id),
            ];
        }
        return $result;
    }

    protected function getXmlData(): string
    {
        // EN CAS LES ACCOUNTS SONT ACTIVER VIA L'API ET L'UTILISATEUR VA SELECTIONNER
        // IL FAUT JUSTE REMPLACER $this->accountNr par $account_nr
        $account_nr = (isset($this->filter['account_nr'])) ? $this->filter['account_nr'] : '';

        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<GSI_PlaceRQ>
    <system_id>$this->systemId</system_id>
    <account_nr >$this->accountNr</account_nr >
</GSI_PlaceRQ>
EOT;
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlData);
        $dom->formatOutput = TRUE;
        return $dom->saveXML();
    }
}