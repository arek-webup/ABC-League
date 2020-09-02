<?php


namespace App\Services;


class VatService
{

    public $URL = "http://api.vatlookup.eu/rates/";

    public function __construct()
    {

    }

    function viesCheckVAT($countryCode, $vatNumber, $timeout = 30) {
        $response = array ();
        $pattern = '/<(%s).*?>([\s\S]*)<\/\1/';
        $keys = array (
            'countryCode',
            'vatNumber',
            'requestDate',
            'valid',
            'name',
            'address',
            'vat_rate'
        );

        $content = "<s11:Envelope xmlns:s11='http://schemas.xmlsoap.org/soap/envelope/'>
  <s11:Body>
    <tns1:checkVat xmlns:tns1='urn:ec.europa.eu:taxud:vies:services:checkVat:types'>
      <tns1:countryCode>%s</tns1:countryCode>
      <tns1:vatNumber>%s</tns1:vatNumber>
    </tns1:checkVat>
  </s11:Body>
</s11:Envelope>";
        $rates =

        $opts = array (
            'http' => array (
                'method' => 'POST',
                'header' => "Content-Type: text/xml; charset=utf-8; SOAPAction: checkVatService",
                'content' => sprintf ( $content, $countryCode, $vatNumber ),
                'timeout' => $timeout
            )
        );
        //return dd($rates);
        $ctx = stream_context_create ( $opts );
        $result = file_get_contents ( 'http://ec.europa.eu/taxation_customs/vies/services/checkVatService', false, $ctx );

        if (preg_match ( sprintf ( $pattern, 'checkVatResponse' ), $result, $matches )) {
            foreach ( $keys as $key )
                preg_match ( sprintf ( $pattern, $key ), $matches [2], $value ) && $response [$key] = $value [2];
        }

        $vat_rate = json_decode(file_get_contents($this->URL.$countryCode."/"), true);
        $response['vat_rate'] = $vat_rate['rates'][2]['rates'][0];
        return $response;
    }

    public function getVatRate($countryCode)
    {
        $vat_rate = json_decode(file_get_contents($this->URL.$countryCode."/"), true);
        return $vat_rate['rates'][2]['rates'][0];

    }
}
