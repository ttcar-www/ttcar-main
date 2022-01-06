<?php

namespace App\ResacarApi\Data;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class AccountsManager extends AbstractResacarApi
{
    public function getResult(): array
    {
        $data = $this->callApi();
        return [];
    }

    protected function getXmlData(): string
    {
        $station_id = (isset($this->filter['station_id'])) ? $this->filter['station_id'] : '';

        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<GSI_AccountRQ>
    <system_id>$this->systemId</system_id>
</GSI_AccountRQ>
EOT;
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlData);
        $dom->formatOutput = TRUE;
        return $dom->saveXML();
    }
}