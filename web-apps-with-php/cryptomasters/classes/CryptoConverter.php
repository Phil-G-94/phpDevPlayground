<?php

interface CanConvert {
    public function convert(float $value);
}

class CryptoConverter {

    // constructors
    function __construct(public string $currencyCode) {

    }

    // methods
    public function convert(float $value): float {

        $code = $this->currencyCode;

        $url = "https://cex.io/api/ticker/$code/USD";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); # specify the URL for the request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); # return result as string instead of dumping to browser/terminal
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # don't require SSL cert verification

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("cURL error: " . curl_errno($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        $usdValue = (float)$data["last"] * $value;

        return $usdValue;
    }
}

$c = new CryptoConverter(currencyCode: "BTC");