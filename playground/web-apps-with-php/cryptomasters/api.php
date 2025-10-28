<?php

    require_once "./classes/CryptoConverter.php";

    // Export json to client & set CORS
    header("Content-type: application/json");
    header("Access-Control-Allow-Origin: * ");

    $code = $_GET["code"] ?? "BTC"; # nullish coalescing in php
    $converter = new CryptoConverter($code);
    $rateInUSD = $converter?->convert(); # check if converter is not undefined, then execute - "safe-call operator"
    echo "{'rate': $rateInUSD}";
?>