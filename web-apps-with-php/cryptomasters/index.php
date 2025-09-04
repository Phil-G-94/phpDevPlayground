<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CryptoMasters</title>
</head>
<body>
    <h1>CryptoMasters</h1>

    <p>Enter the amount of crypto</p>

    <form action="/convert.php" method="POST">
        <label for="amount">Amount</label>
        <input type="number" name="amount" id="amount">

        <label for="crypto">Crypto</label>
        <select name="crypto" id="currency">
            <option value="BTC">BTC</option>
            <option value="ETH">ETH</option>
        </select>
        <button type="submit">Submit</button>
    </form>

</body>
</html>