<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convert</title>
</head>
<body>
    <h1>Conversion Results</h1>

    <?php

        # reading the values from the form in index.php
        # using superglobal variable $_GET

        // $amount = $_GET["amount"];
        // $crypto = $_GET["crypto"];

        // echo "<p> You want to convert $amount from $crypto </p>"

        # using superglobal variable $_POST

        # if check - confirm values are set in the request
        // if (isset($_POST["amount"]) && isset($_POST["crypto"])) {

        //     $amount = $_POST["amount"];
        //     $crypto = $_POST["crypto"];

        //     echo "<p> You want to convert $amount from $crypto </p>";
        // } else {
        //     echo "<h2>Ooops - something isn't quite right!</h2>";
        // }

        # dump information about a variable
        // var_dump($_SERVER);
    ?>
</body>
</html>