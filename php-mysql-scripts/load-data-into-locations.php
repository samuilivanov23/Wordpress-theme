<?php
    include '../conf-db.php';

    //getting the dataset form the opendatasoft api.
    $cURLConnection = curl_init();

    curl_setopt($cURLConnection, CURLOPT_URL, 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=us-zip-code-latitude-and-longitude&q=&rows=9999&start=1');
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
        $recordId = $jsonArrayResponse["records"][$i]["recordid"];
        $zip_code = $jsonArrayResponse["records"][$i]["fields"]["zip"];
        $city = $jsonArrayResponse["records"][$i]["fields"]["city"];
        $state = $jsonArrayResponse["records"][$i]["fields"]["state"];
        $latitude = $jsonArrayResponse["records"][$i]["fields"]["latitude"];
        $longitude = $jsonArrayResponse["records"][$i]["fields"]["longitude"];

        switch($state)
        {
            case "AL":
                $state = "Alabama";
                break;
            case "AK":
                $state = "Alaska";
                break;
            case "AZ":
                $state = "Arizona";
                break;
            case "AR":
                $state = "Arkansas";
                break;
            case "CA":
                $state = "California";
                break;
            case "CO":
                $state = "Colorado";
                break;
            case "CT":
                $state = "Connecticut";
                break;
            case "DE":
                $state = "Delaware";
                break;
            case "FL":
                $state = "Florida";
                break;
            case "GA":
                $state = "Georgia";
                break;
            case "HI":
                $state = "Hawaii";
                break;
            case "ID":
                $state = "Idaho";
                break;
            case "IL":
                $state = "Illinois";
                break;
            case "IN":
                $state = "Indiana";
                break;
            case "IA":
                $state = "Iowa";
                break;
            case "KS":
                $state = "Kansas";
                break;
            case "KY":
                $state = "Kentucky";
                break;
            case "LA":
                $state = "Louisiana";
                break;
            case "ME":
                $state = "Maine";
                break;
            case "MD":
                $state = "Maryland";
                break;
            case "MA";
                $state = "Massachusetts";
                break;
            case "MI":
                $state = "Michigan";
                break;
            case "MN":
                $state = "Minnesota";
                break;
            case "MS":
                $state = "Mississippi";
                break;
            case "MO":
                $state = "Missouri";
                break;
            case "MT":
                $state = "Montana";
                break;
            case "NE":
                $state = "Nebraska";
                break;
            case "NV":
                $state = "Nevada";
                break;
            case "NH":
                $state = "New Hampshire";
                break;
            case "NJ":
                $state = "New Jersey";
                break;
            case "NM":
                $state = "New Mexico";
                break;
            case "NY":
                $state = "New York";
                break;
            case "NC":
                $state = "North Carolina";
                break;
            case "ND":
                $state = "North Dakota";
                break;
            case "OH":
                $state = "Ohio";
                break;
            case "OK":
                $state = "Oklahoma";
                break;
            case "OR":
                $state = "Oregon";
                break;
            case "PA":
                $state = "Pennsylvania";
                break;
            case "RI":
                $state = "Rhode Island";
                break;
            case "SC":
                $state = "South Carolina";
                break;
            case "SD":
                $state = "South Dakota";
                break;
            case "TN":
                $state = "Tennessee";
                break;
            case "TX":
                $state = "Texas";
                break;
            case "UT":
                $state = "Utah";
                break;
            case "VT":
                $state = "Vermont";
                break;
            case "VA":
                $state = "Virginia";
                break;
            case "WA":
                $state = "Washington";
                break;
            case "WV":
                $state = "West Virginia";
                break;
            case "WI":
                $state = "Wisconsin";
                break;
            case "WY":
                $state = "Wyoming";
                break;
            case "PR":
                $state = "Puerto Rico";
                break;
            case "VI":
                $state = "Virgin Islands";
                break;
            case "DC":
                $state = "Washington D.C.";
                break;
        }

        $sql = "INSERT INTO locations(recordId, zipcode, city, state, latitude, longitude)
                VALUES ('".$recordId."', '".$zip_code."', '".$city."', '".$state."', '".$latitude."', '".$longitude."')";
        if(!mysqli_query($connection, $sql))
        {
            echo "<p>Error while executing sql query " . $recordId ." : invalid query</p>";
        }
    }

    $connection->close();
?>