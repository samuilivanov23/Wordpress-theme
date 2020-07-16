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

            //taking filter data
            $city = $_POST["city"];
            $state = $_POST["state"];
            $first_point_latitude = $_POST["first_point_latitude"];
            $first_point_longitude = $_POST["first_point_longitude"];
            $second_point_latitude = $_POST["second_point_latitude"];
            $second_point_longitude = $_POST["second_point_longitude"];

            $sql_query = "";

            if($city == "" && $state == "")
            {
                if($first_point_latitude == "" && $first_point_longitude == "" && $second_point_latitude == "" & $second_point_longitude == "")
                {
                    echo "<p>i dvete sa null</p>";
                    $sql_query = "select * from locations";
                }
                else 
                {
                    if($first_point_longitude > $second_point_longitude)
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude >= '" . $first_point_latitude . "'"
                                                                . "and latitude <= '" . $second_point_latitude . "'";
                        }

                    }
                    else
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where longitude >= '" . $first_point_longitude . "'" 
                                                                . "and longitude <= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where longitude >= '" . $first_point_longitude . "'" 
                                                                . "and longitude <= '" . $second_point_longitude . "'"
                                                                . "and latitude >= '" . $first_point_latitude . "'"
                                                                . "and latitude <= '" . $second_point_latitude . "'";
                        }
                    }
                }
            }
            else if($_POST["city"] != "")
            {
                if($first_point_latitude == "" && $first_point_longitude == "" && $second_point_latitude == "" & $second_point_longitude == "")
                {
                    echo "<p>state e null</p>";
                    $sql_query = "select * from locations where city = '".$city."'";
                }
                else
                {
                    if($first_point_longitude > $second_point_longitude)
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude >= '" . $first_point_latitude . "'"
                                                                . "and latitude <= '" . $second_point_latitude . "'";
                        }

                    }
                    else
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where longitude >= '" . $first_point_longitude . "'" 
                                                                . "and longitude <= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where longitude >= '" . $first_point_longitude . "'" 
                                                                . "and longitude <= '" . $second_point_longitude . "'"
                                                                . "and latitude >= '" . $first_point_latitude . "'"
                                                                . "and latitude <= '" . $second_point_latitude . "'";
                        }
                    }
                }
            }
            else if($_POST["state"] != "")
            {
                if($first_point_latitude == "" && $first_point_longitude == "" && $second_point_latitude == "" & $second_point_longitude == "")
                {
                    echo "<p>city e null</p>";
                    $sql_query = "select * from locations where state_ = '".$state."'";
                }
                else
                {
                    if($first_point_longitude > $second_point_longitude)
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude >= '" . $first_point_latitude . "'"
                                                                . "and latitude <= '" . $second_point_latitude . "'";
                        }

                    }
                    else
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where longitude >= '" . $first_point_longitude . "'" 
                                                                . "and longitude <= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where longitude >= '" . $first_point_longitude . "'" 
                                                                . "and longitude <= '" . $second_point_longitude . "'"
                                                                . "and latitude >= '" . $first_point_latitude . "'"
                                                                . "and latitude <= '" . $second_point_latitude . "'";
                        }
                    }
                }
            }

            $result = $connection->query($sql_query);
            $latitude_array = array();
            $longitude_array = array();

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()) 
                {
                    //adding the locations to arrays
                    $latitude_array[] = $row["latitude"];
                    $longitude_array[] = $row["longitude"];
                }
            }
            else 
            {
                echo "No rows in this table ......";
            }
            mysqli_close($connection);
            
        ?>

        <script type="text/javascript">

            function initMap()
            {
                var lat_array =<?php echo json_encode($latitude_array); ?>;
                var lon_array = <?php echo json_encode($longitude_array); ?>;

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
                
                var first_marker;

                for (i = 0; i < markers.length; i++)
                {
                    google.maps.event.addListener(markers[i], 'click', function (evt) {
                        
                        // document.getElementById('current').innerHTML = '<p>Marker position: Lat: ' + evt.latLng.lat().toFixed(6) + 
                        //                                       ' Lng: ' + evt.latLng.lng().toFixed(6) + '</p>';

                        first_marker = new google.maps.Marker({
                            position: new google.maps.LatLng(evt.latLng.lat().toFixed(6), evt.latLng.lng().toFixed(6)),
                            //my_index = i
                        });
                        
                        document.getElementById('current').innerHTML = '<p>AGAIN...111..Marker position: Lat: ' + first_marker.position.lat() + 
                                                            ' Lng: ' + first_marker.position.lng() + '</p>';
                    });
                }
            }

        </script>

    </head>

<body <?php body_class();?>>