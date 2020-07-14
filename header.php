<!DOCTYPE html>
<html>

    <head>

        <?php wp_head();?>
        <title>Simple Markers</title>
        <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>

        <?php
            include 'conf-db.php';

            //connecting to the database
            $connection = mysqli_connect($dbhost_, $dbuser_, $dbpass_, $dbname_);

            //checking if the connection is successful
            if($connection -> connect_error) //if(!connection)
            {
                die("Connection failed: " . $connection->connect_error);
            }

            $sql_query = "select * from locations";
            $result = $connection->query($sql_query);
            $latitude_array = array();
            $longitude_array = array();

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()) 
                {
                    //adding the locations to arrays
                    //Add location filtering
                    // if($row["state_"] == "CA")
                    // {
                    //     $latitude_array[] = $row["latitude"];
                    //     $longitude_array[] = $row["longitude"];
                    // }

                    $latitude_array[] = $row["latitude"];
                    $longitude_array[] = $row["longitude"];
                    
                    // {lat: $row["latitude"], lng: $row["longitude"]};
                }

            }
            else 
            {
                echo "No rows in this table";
            }
            mysqli_close($connection);
        ?>

        <script type="text/javascript">

            function initMap()
            {
                var lon_array = <?php echo json_encode($longitude_array); ?>;
                var lat_array =<?php echo json_encode($latitude_array); ?>;

                console.log("map is not showing...");

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 3,
                    center: new google.maps.LatLng(lat_array[0], lon_array[0]),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                // Add some markers to the map.
                // Using map function to create an array of markers based on a given "locations" array.
                var markers = lat_array.map(function(location, i) {
                    return new google.maps.Marker({
                        position: new google.maps.LatLng(lat_array[i], lon_array[i]),
                        map: map
                    });
                });

                // Add a marker clusterer to manage the markers.
                var markerCluster = new MarkerClusterer(map, markers,
                    {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            }

        </script>

    </head>

<body <?php body_class();?>>