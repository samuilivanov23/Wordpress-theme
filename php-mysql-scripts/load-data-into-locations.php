<?php
    include '../conf-db.php';

    //getting the dataset form the opendatasoft api.
    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=us-zip-code-latitude-and-longitude&q=&rows=5000&start=1');
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $locations = curl_exec($cURLConnection);

    curl_close($cURLConnection);
    
    //connecting to the database
    $connection = mysqli_connect($dbhost_, $dbuser_, $dbpass_, $dbname_);
    
    //checking if the connection is successful
    if($connection -> connect_error)
    {
        die("Connection failed: " . $connection->connect_error);
    }

    $jsonArrayResponse = json_decode($locations, true);

    for ($i = 0; $i < count($jsonArrayResponse["records"]); $i++) 
    {
        $zip_code = $jsonArrayResponse["records"][$i]["fields"]["zip"];
        $city = $jsonArrayResponse["records"][$i]["fields"]["city"];
        $state = $jsonArrayResponse["records"][$i]["fields"]["state"];
        $latitude = $jsonArrayResponse["records"][$i]["fields"]["latitude"];
        $longitude = $jsonArrayResponse["records"][$i]["fields"]["longitude"];

        $sql = "INSERT INTO locations(zipcode, city, state_, latitude, longitude)
            VALUES ('".$zip_code."', '".$city."', '".$state."', '".$latitude."', '".$longitude."')";
        if(!mysqli_query($connection, $sql))
        {
           die('Error while executing sql query');
        }
    }

    //getting the dataset form the opendatasoft api.
    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=us-zip-code-latitude-and-longitude&q=&rows=3999&start=6000');
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $second_locations = curl_exec($cURLConnection);

    curl_close($cURLConnection);


    $jsonArrayResponse = json_decode($second_locations, true);

    for ($i = 0; $i < count($jsonArrayResponse["records"]); $i++) 
    {
        $zip_code = $jsonArrayResponse["records"][$i]["fields"]["zip"];
        $city = $jsonArrayResponse["records"][$i]["fields"]["city"];
        $state = $jsonArrayResponse["records"][$i]["fields"]["state"];
        $latitude = $jsonArrayResponse["records"][$i]["fields"]["latitude"];
        $longitude = $jsonArrayResponse["records"][$i]["fields"]["longitude"];

        $sql = "INSERT INTO locations(zipcode, city, state_, latitude, longitude)
            VALUES ('".$zip_code."', '".$city."', '".$state."', '".$latitude."', '".$longitude."')";
        if(!mysqli_query($connection, $sql))
        {
           die('Error while executing sql query');
        }
    }

    $connection->close();
?>