<!DOCTYPE html>
<html>

    <head>

        <?php wp_head();?>
        <title>Simple Markers</title>

        <?php

            //database credentials
            $dbhost = "localhost";
            $dbuser = "root";
            $dbpass = "wordpressadmin";
            $dbname = "wordpress";

            //connecting to the database
            $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

            //checking if the connection is successful
            if($connection -> connect_error) //if(!connection)
            {
                die("Connection failed: " . $connection->connect_error);
            }

            $sql_query = "select * from locations_";
            $result = $connection->query($sql_query);
            $latitude_array = array();
            $longitude_array = array();

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()) 
                {
                    //adding the locations to arrays
                    //Add location filtering
                    if($row["state_"] == "CA")
                    {
                        $latitude_array[] = $row["latitude"];
                        $longitude_array[] = $row["longitude"];
                    }
                    
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

                var marker, i;
                for (i = 0; i < lat_array.length; i++) {  
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(lat_array[i], lon_array[i]),
                        map: map
                    });
                }
            }

        </script>

    </head>

<body <?php body_class();?>>