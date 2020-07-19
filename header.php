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
            $zip_code = $_POST["zip_code"];
            $city = $_POST["city"];
            $state = $_POST["state"];
            $first_point_latitude = $_POST["first_point_latitude"];
            $first_point_longitude = $_POST["first_point_longitude"];
            $second_point_latitude = $_POST["second_point_latitude"];
            $second_point_longitude = $_POST["second_point_longitude"];

            //initial map options variables;
            $start_point_latitude = 41;
            $start_point_longitude = -73;
            $end_point_latitude = 30;
            $end_point_longitude = -90;

            $sql_query = "";

            if($zip_code != "")
            {
                $sql_query = "select * from locations where zipcode = '".$zip_code."'";
            }
            else if($city == "" && $state == "")
            {
                if($first_point_latitude == "" && $first_point_longitude == "" && $second_point_latitude == "" & $second_point_longitude == "")
                {
                    $sql_query = "select * from locations where longitude <= '" . $start_point_longitude . "'" 
                                                        . "and longitude >= '" . $end_point_longitude . "'"
                                                        . "and latitude <= '" . $start_point_latitude . "'"
                                                        . "and latitude >= '" . $end_point_latitude . "'";
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
                    $sql_query = "select * from locations where city = '".$city."'";
                }
                else
                {
                    if($first_point_longitude > $second_point_longitude)
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where city = '".$city."'" 
                                                                . "and longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where city = '".$city."'" 
                                                                . "and longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude >= '" . $first_point_latitude . "'"
                                                                . "and latitude <= '" . $second_point_latitude . "'";
                        }

                    }
                    else
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where city = '".$city."'" 
                                                                . "and longitude >= '" . $first_point_longitude . "'" 
                                                                . "and longitude <= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where city = '".$city."'" 
                                                                . "and longitude >= '" . $first_point_longitude . "'" 
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
                    $sql_query = "select * from locations where state_ = '".$state."'";
                }
                else
                {
                    if($first_point_longitude > $second_point_longitude)
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where state_ = '".$state."'" 
                                                                . "and longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where state_ = '".$state."'" 
                                                                . "and longitude <= '" . $first_point_longitude . "'" 
                                                                . "and longitude >= '" . $second_point_longitude . "'"
                                                                . "and latitude >= '" . $first_point_latitude . "'"
                                                                . "and latitude <= '" . $second_point_latitude . "'";
                        }

                    }
                    else
                    {
                        if($first_point_latitude > $second_point_latitude)
                        {
                            $sql_query = "select * from locations where state_ = '".$state."'" 
                                                                . "and longitude >= '" . $first_point_longitude . "'" 
                                                                . "and longitude <= '" . $second_point_longitude . "'"
                                                                . "and latitude <= '" . $first_point_latitude . "'"
                                                                . "and latitude >= '" . $second_point_latitude . "'";
                        }
                        else
                        {
                            $sql_query = "select * from locations where state_ = '".$state."'" 
                                                                . "longitude >= '" . $first_point_longitude . "'" 
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
                $center_latitude = $latitude_array[0];
                $center_longitude = $longitude_array[0];
                $initial_zoom_level = 6;
            }
            else 
            {
                echo "The input data is not matching any markers.";
                $center_latitude = 40;
                $center_longitude = -90;
                $initial_zoom_level = 4;
            }
            mysqli_close($connection);
            
        ?>

        <script type="text/javascript">

            function initMap()
            {
                var lat_array =<?php echo json_encode($latitude_array); ?>;
                var lon_array = <?php echo json_encode($longitude_array); ?>;

                //initial map options variables;
                var center_latitude = <?php echo $center_latitude; ?>;
                var center_longitude = <?php echo $center_longitude; ?>;
                var initial_zoom_level = <?php echo $initial_zoom_level; ?>;
                
                if(!lat_array.length == 0 && !lon_array.length == 0)
                {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: initial_zoom_level,
                        center: new google.maps.LatLng(center_latitude, center_longitude),
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
                            first_marker = new google.maps.Marker({
                                position: new google.maps.LatLng(evt.latLng.lat().toFixed(6), evt.latLng.lng().toFixed(6)),
                            });
                            
                            document.getElementById('marker_position').innerHTML = '<p>Marker position: Lat: ' + first_marker.position.lat() + 
                                                                ' Lng: ' + first_marker.position.lng() + '</p>';
                        });
                    }

                    document.getElementById('markers_count').innerHTML = '<p>Markers count: ' + markers.length + '</p>';
                }
                else
                {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: initial_zoom_level,
                        center: new google.maps.LatLng(center_latitude, center_longitude),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

                    document.getElementById('markers_count').innerHTML = '<p>No markers in the selected area. Please enter positions where there are existing markers.</p>';
                }
            }

        </script>

    </head>

<body <?php body_class();?>>