
<?php
    //  single line comment

    /*
        multi-line
        comment
    */
    // echo("Hello World");
    // echo "Hello World from PHP";

    // //  creating a variable
    // $name = "Jack Sparrow"; #string

    // $year = 2025; #int

    // $isFinished = true; #bool

    // echo $name+

    /* _variable_ variables */

    // $name = "Jack";
    // $$name = "The Sparrow";

    // echo $Jack; // prints `The Sparrow` to stdout
    // echo $name; // Jack
    // echo $$name; // The Sparrow

    /* strings */

    // $title = "PHP Fundamentals";

    // $message = "Welcome to " . $title; // concatenation is `.`

    // $message2 = "Welcome to $title";

    // echo $message2;

    /* strings - heredoc syntax */

    // $json = <<<JSON
    // // example of string spanning multiple lines using heredoc syntax
    //         Hello
    //     World
    //     \n
    //     {
    //         "What?"
    //     }
    // JSON;

    // echo $json

    /* Arrays and collections */

    // $int_list = array("id" => 4, "quantity" => 0, 12, 24, 25);
    // $countries = ["Argentina", "Brazil", "Canada", "Mexico"];

    // // length of array
    // echo count($int_list);

    /* Loops */

    // for loop

    // $countries = ["Argentina", "Brazil", "Canada", "Mexico"];
    // for ($i=0; $i<count($countries); $i+=1) {
    //     echo $countries[$i] . " "; // Argentina Brazil Canada Mexico
    // }

    // foreach loop
    // $countries = ["Argentina", "Brazil", "Canada", "Mexico"];
    // foreach ($countries as $index => $value) {
    //     echo "$index: $value\n"  ;

    //     /*
    //      Prints the following to stdout
    //         0: Argentina
    //         1: Brazil
    //         2: Canada
    //         3: Mexico
    //     */
    // }

    // foreach - alternative syntax
    // useful for mixing output with HTML

    /*
        $customers = ["Client" => "Yerba Mate Architecture", "Partner" => "Escape IT Solutions", "Client" => "East London Waterworks Park"];

        foreach ($customers as $customer_type => $customer_name): ?>
            <li>
                <?php echo $customer_type . ": " ?> <?php echo $customer_name ?>
            </li>
        <?php
        endforeach;
    */

    /* Functions */

    // create functions with `function` keyword and the name of the function

    // function printHello() {
    //     echo "Hello World\n";
    // }

    // printHello();

    // function sum($a, $b) {
    //     return $a + $b . "\n";
    // }

    // echo(sum(4, 5));

    // specifying data types on function arguments
    // bool, int, float, string, array, object, callable
    // function calculateTaxRate(int $price, int $tax) {
    //     return $price * $tax;
    // }

    // named arguments - allows us to change order

    // function calculateTaxRate(int $price, int $tax) {
    //     return $price * $tax;
    // }

    // calculateTaxRate(price: 10, tax: 2);

    // default values

    // function calculateTaxRate(int $price, float $tax = 0.5) {
    //     return $price * $tax;
    // }

    // calculateTaxRate(price: 10, tax: 2);

?>