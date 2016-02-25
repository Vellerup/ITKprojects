<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>OCD Remove</title>

    <link rel="stylesheet" type="text/css" href="ressources/css/table.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->


    <script>
        /*
         $(function(){
         $("#Topmenu").load("topmenu/menu_two.html");
         });
         */
    </script>

</head>
<body marginleft="0" marginright="0">
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>



<?php
/**
 * Created by PhpStorm.
 * User: Vellerup
 * Date: 20/01/16
 * Time: 21.03
 */
echo "<br>";
require_once("util.php");

$url = "http://itkdesign.harvestapp.com/clients";
$client_data = get_harvest($url);
$clients = new SimpleXMLElement($client_data);
$client_array = array();

foreach($clients as $client){
    //echo $client->name;
    //echo $client->id;
    //echo "<br>";
    $name = (string)$client->name;
    $id = (string)$client->id;
    $client_array[$id] = $name;

}
/*
print "<pre>";
print_r($client_array);
print "</pre>";
*/
/*
$url = "http://itkdesign.harvestapp.com/invoices/#{8753265}/payments";
$client_data2 = get_harvest($url);
$clients2 = new SimpleXMLElement($client_data2);
$client_array2 = array();

foreach($clients2 as $client2){
    //echo $client->name;
    //echo $client->id;
    //echo "<br>";
    $name = (string)$client2->amount;
    $id = (string)$client2->id;
    $client_array2[$id] = $name;

}

print "<pre>";
print_r($clients2);
print "</pre>";
*/


$url = "http://itkdesign.harvestapp.com/invoices";

$data = get_harvest($url);
$invoices = new SimpleXMLElement($data);
?>
<h1>OCD remove</h1>
<p>Output</p>
<table class="rwd-table">
    <tr>
        <th>ID</th>
        <th>Client_ID</th>
        <th>Kommentar</th>
        <th>Amount</th>
        <th>Skylder</th>
        <th>Betal</th>

    </tr>

    <?php

foreach ($invoices as $invoice) {

    echo "<tr>";
    echo "<td>" . $invoice->id . "</td>";

    echo "<td>";
    echo $client_array[(string)$invoice->{'client-id'}] ;
    echo "</td>";

    echo "<td>" . $invoice->notes . "</td>";
    echo "<td>" . $invoice->amount . "</td>";
    echo "<td>" . $invoice->{'due-amount'} . "</td>";
    echo "<td>";
    echo "<div>";

    if ($invoice->{'due-amount'}>0){
        echo '<INPUT TYPE="image" SRC="ressources/images/gron_knap2.png" ALT="SUBMIT" class="knap" id="knapA' . $invoice->id . '" width="75" hidden="hidden">';
        echo '<INPUT TYPE="image" SRC="ressources/images/rod_knap2.png" ALT="SUBMIT" class="knap" id="knapB' . $invoice->id . '" width="75"></div>';
    }
    else {
        echo '<INPUT TYPE="image" SRC="ressources/images/gron_knap2.png" ALT="SUBMIT" class="knap" id="knapA' . $invoice->id . '" width="75">';
        echo '<INPUT TYPE="image" SRC="ressources/images/rod_knap2.png" ALT="SUBMIT" class="knap" id="knapB' . $invoice->id . '" width="75" hidden="hidden"></div>';
    }

    echo "</td>";
    echo "</tr>";
}
    ?>
</table>
<script type="text/javascript">
    $(document).ready(function(){
        $(".knap").click(function(event){
            //alert("ok");
            var idstring = event.target.id;
            if(idstring.substr(4,1) == "A"){
                alert("Allerede betalt");

            }
            else{
                //alert(idstring.substr(4,1));
                var client = idstring.substr(5,7);
                $.ajax({
                    type: 'POST',
                    url: 'payment.php',
                    data: {'client': client, 'due': '2'},
                    success: function(data) {
                        //alert(data);
                        $("p").text(data);

                    }
                });

            }

            //$("p").text(event.target.id);
        });
    });

</script>

<?php
echo "datarå";
    print "<pre>";
    print_r($invoices);
    print "</pre>";

?>


</body>
</html>