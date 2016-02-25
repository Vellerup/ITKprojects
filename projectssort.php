<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Projekter og større opgaver i ITK</title>

    <link rel="stylesheet" type="text/css" href="ressources/css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->


</head>
<body marginleft="0" marginright="0">
<?php

require_once("util.php");

$typelist = array();
$typelist[0] = "Projekt";
$typelist[1] = "Drift";
$typelist[2] = "Support";
$typelist[3] = "Major";
$typelist[4] = "Website";
//$typelist[5] = "Intern";



#region itkaarhus
$url = "http://itkaarhus.harvestapp.com/clients";
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
var_dump($client_array);
print "</pre>";
*/

$url = "http://itkaarhus.harvestapp.com/projects";
$data = get_harvest($url);


$projects = new SimpleXMLElement($data);

$project_array = array();
echo "<br>";
$i=0;
foreach($projects as $project){
    if (in_array($project->code, $typelist)) {
        //echo $client->name;
        //echo $client->id;
        //echo "<br>";
        //$project_array[$i]['id'] = (string)$project->id;
        $project_array[(string)$project->id]['name'] = (string)$project->name;
        $project_array[(string)$project->id]['client'] = $client_array[(string)$project->{'client-id'}];
        $project_array[(string)$project->id]['type'] = (string)$project->code;
        if((string)$project->active=="true"){
            $project_array[(string)$project->id]['status'] = "Igang";
        }
        else{
            $project_array[(string)$project->id]['status'] = "Afsluttet";

        }


        //$project_array[(string)$project->id]['status'] = (string)$project->active;
        $project_array[(string)$project->id]['source'] = "harvest_itkaarhus";


        $i++;
    }
}

//var_dump($project_array);

#endregion


#region eReolen
$url = "http://ereolen.harvestapp.com/clients";
$client_data = get_harvest($url);
$clients = new SimpleXMLElement($client_data);
//$client_array = array();

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
var_dump($client_array);
print "</pre>";
*/

$url = "http://ereolen.harvestapp.com/projects";
$data = get_harvest($url);


$projects = new SimpleXMLElement($data);

//$project_array = array();
echo "<br>";
$i=0;
foreach($projects as $project){
    if (in_array($project->code, $typelist)) {


        //echo $client->name;
        //echo $client->id;
        //echo "<br>";
        //$project_array[$i]['id'] = (string)$project->id;
        $project_array[(string)$project->id]['name'] = (string)$project->name;
        $project_array[(string)$project->id]['client'] = $client_array[(string)$project->{'client-id'}];
        $project_array[(string)$project->id]['type'] = (string)$project->code;
        if((string)$project->active=="true"){
            $project_array[(string)$project->id]['status'] = "Igang";
        }
        else{
            $project_array[(string)$project->id]['status'] = "Afsluttet";

        }

        //$project_array[(string)$project->id]['status'] = (string)$project->active;
        $project_array[(string)$project->id]['source'] = "harvest_ereolen";

        $i++;
    }
}
#endregion


#region design
$url = "http://itkdesign.harvestapp.com/clients";
$client_data = get_harvest($url);
$clients = new SimpleXMLElement($client_data);
//$client_array = array();

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
var_dump($client_array);
print "</pre>";
*/

$url = "http://itkdesign.harvestapp.com/projects";
$data = get_harvest($url);


$projects = new SimpleXMLElement($data);

/*
print "<pre>";
var_dump($projects);
print "</pre>";
*/
//$project_array = array();
echo "<br>";
foreach($projects as $project){
    if (in_array($project->code, $typelist)) {
        //echo $project->name;
        //echo $client->id;
        //echo "<br>";
        //$project_array[$i]['id'] = (string)$project->id;
        $project_array[(string)$project->id]['name'] = (string)$project->name;
        $project_array[(string)$project->id]['client'] = $client_array[(string)$project->{'client-id'}];
        $project_array[(string)$project->id]['type'] = "Grafik/tryk";
        if((string)$project->active=="true"){
            $project_array[(string)$project->id]['status'] = "Igang";
        }
        else{
            $project_array[(string)$project->id]['status'] = "Afsluttet";

        }

        //$project_array[(string)$project->id]['status'] = (string)$project->active;
        $project_array[(string)$project->id]['source'] = "harvest_design";
    }

}
#endregion

#region jira

$jira_projects = get_project();

$exclude_array = array();
$exclude_array[0] = "TEAMMANAGE";
$exclude_array[1] = "ID";
$exclude_array[2] = "SUPPORT";
$exclude_array[3] = "SALG";
$exclude_array[4] = "MKBDIGI";
$exclude_array[5] = "IKTREDEL";




foreach($jira_projects as $jira_project){

    //echo $jira_project->name . "<br>";

if (in_array($jira_project->key, $exclude_array)) {
    //echo "Fundet<br>";
}
    else{
    $project_array[(string)$jira_project->key]['name'] = (string)$jira_project->name;
    $project_array[(string)$jira_project->key]['client'] = (string)$jira_project->key;
    $project_array[(string)$jira_project->key]['type'] = "Website";
    $project_array[(string)$jira_project->key]['status'] = "Igang";
    $project_array[(string)$jira_project->key]['source'] = "Jira";
}
}
/*
print "<pre>";
print_r($jira_projects);
print "</pre>";

*/
#endregion


?>

<div id="wrapper">
    <h1>Projekter og større opgaver i ITK</h1>

    <table id="keywords" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th><span>Navn</span></th>
            <th><span>Finansiering</span></th>
            <th><span>Type</span></th>
            <th><span>Status</span></th>
            <th><span>Kilde</span></th>
        </tr>
        </thead>
        <tbody>


        <?php


        foreach($project_array as $project){
        //    if (in_array($project['type'], $typelist)){
                echo "<tr>";
                echo "<td>" . $project['name'] . "</td>";
                echo "<td>" . $project['client'] . "</td>";
                echo "<td>" . $project['type'] . "</td>";
                echo "<td>" . $project['status'] . "</td>";
                echo "<td>" . $project['source'] . "</td>";
                echo "</tr>";
            }
        //}

        ?>
        </tbody>
    </table>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://tablesorter.com/__jquery.tablesorter.min.js'></script>

<script src="js/index.js"></script>




</body>
</html>