<?php

namespace App\ResacarApi\Booking;

use App\ResacarApi\Abstracts\AbstractResacarApi;

class BookingManager extends AbstractResacarApi
{
    public function getResult(): array
    {
        $data = $this->callApi();
        dd($data);
        $result = [];
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
        $station_id = (isset($this->filter['station_id'])) ? $this->filter['station_id'] : '';
        $pickup_date = (isset($this->filter['pickup_date'])) ? $this->filter['pickup_date'] : '';
        $pickup_time = (isset($this->filter['pickup_time'])) ? $this->filter['pickup_time'] : '';
        $return_date = (isset($this->filter['return_date'])) ? $this->filter['return_date'] : '';
        $return_time = (isset($this->filter['return_time'])) ? $this->filter['return_time'] : '';
        $driver_civility = (isset($this->filter['driver_civility'])) ? $this->filter['driver_civility'] : '';
        $driver_first_name = (isset($this->filter['driver_first_name'])) ? $this->filter['driver_first_name'] : '';
        $driver_last_name = (isset($this->filter['driver_last_name'])) ? $this->filter['driver_last_name'] : '';
        $driver_phone = (isset($this->filter['driver_phone'])) ? $this->filter['driver_phone'] : '';
        $driver_email = (isset($this->filter['driver_email'])) ? $this->filter['driver_email'] : '';
        $veh_type = (isset($this->filter['veh_type'])) ? $this->filter['veh_type'] : '';
        $veh_group = (isset($this->filter['veh_group'])) ? $this->filter['veh_group'] : '';
        $voucher_type = (isset($this->filter['voucher_type'])) ? $this->filter['voucher_type'] : '';
        $voucher_amount = (isset($this->filter['voucher_amount'])) ? $this->filter['voucher_amount'] : '';
        $voucher_days = (isset($this->filter['voucher_days'])) ? $this->filter['voucher_days'] : '';
        $mail_to = (isset($this->filter['mail_to'])) ? $this->filter['mail_to'] : '';
        $mail_subject = (isset($this->filter['mail_subject'])) ? $this->filter['mail_subject'] : '';
        $invoice_type = (isset($this->filter['invoice_type'])) ? $this->filter['invoice_type'] : '';
        $account_nr_C = (isset($this->filter['account_nr_C'])) ? $this->filter['account_nr_C'] : '';
        $account_nr_A = (isset($this->filter['account_nr_A'])) ? $this->filter['account_nr_A'] : '';
        $corporate_nr = (isset($this->filter['corporate_nr'])) ? $this->filter['corporate_nr'] : '';
        $credit_card_id = (isset($this->filter['credit_card_id'])) ? $this->filter['credit_card_id'] : '';
        $credit_card_nr = (isset($this->filter['credit_card_nr'])) ? $this->filter['credit_card_nr'] : '';
        $credit_card_expdate = (isset($this->filter['credit_card_expdate'])) ? $this->filter['credit_card_expdate'] : '';
        $client_file_ref = (isset($this->filter['client_file_ref'])) ? $this->filter['client_file_ref'] : '';
        $remarks = (isset($this->filter['remarks'])) ? $this->filter['remarks'] : '';

        $xmlData = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<GSI_VehResRQ>
    <system_id>$this->systemId</system_id>
    <reservation type="Automatic" foreign_vehicle="N"/>
    
    <station>
        <pickup_station_id>$station_id</pickup_station_id>
        <pickup_date>$pickup_date</pickup_date>
        <pickup_time>$pickup_time</pickup_time>
        <return_station_id>$station_id</return_station_id>
        <return_date>$return_date</return_date>
        <return_time>$return_time</return_time>
    </station>
    
    <drivers>
        <driver client_id="" title="$driver_civility" last_name="$driver_last_name" first_name="$driver_first_name" phone="$driver_phone" 
        email="$driver_email" frequent_flyer="" flight_nr=" " />
    </drivers>
    
    <invoice>
        <invoice_type>$invoice_type</invoice_type>
        <account_nr_C>$account_nr_C</account_nr_C>
        <account_nr_A>$account_nr_A</account_nr_A>
        <corporate_nr>$corporate_nr</corporate_nr>
        <credit_card_id>$credit_card_id</credit_card_id>
        <credit_card_nr>$credit_card_nr</credit_card_nr>
        <credit_card_expdate>$credit_card_expdate</credit_card_expdate>
        <client_file_ref>$client_file_ref</client_file_ref>
        <remarks>$remarks</remarks>
    </invoice>

    <vehicle>
        <veh_type>$veh_type</veh_type>
        <veh_group>$veh_group</veh_group>
    </vehicle>
    
    <printing>
        <voucher_type>$voucher_type</voucher_type>
        <voucher_amount>$voucher_amount</voucher_amount>
        <voucher_currency>EUR</voucher_currency>
        <voucher_days>$voucher_days</voucher_days>
        <transfer_mode>EMAIL</transfer_mode>
        <send_cc_email>N</send_cc_email>
        <mail_to>$mail_to</mail_to>
        <mail_cc></mail_cc>
        <mail_subject>$mail_subject</mail_subject>
    </printing>
    
    <fare tags="Y"/>
</GSI_VehResRQ>
EOT;
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlData);
        $dom->formatOutput = TRUE;
        return $dom->saveXML();
    }
}