<!DOCTYPE html>
<html>

    <head>

        <?php wp_head();?>
        <title>Simple Markers</title>
        <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>

        <?php
            include 'conf-db.php';

            //connecting to the database
            $dbConnection = new PDO('mysql:dbname='.$dbname_.';host='.$dbhost_.';charset=utf8', $dbuser_, $dbpass_);

            $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //checking if the connection is successful
            if($dbConnection -> connect_error)
            {
                die("Connection failed: " . $dbConnection->connect_error);
            }

            //taking filter data
            $zip_code = $_POST["zip_code"];
            $city = $_POST["city"];
            $state = $_POST["state"];
            $first_point_latitude = $_POST["first_point_latitude"];
            $first_point_longitude = $_POST["first_point_longitude"];
            $second_point_latitude = $_POST["second_point_latitude"];
            $second_point_longitude = $_POST["second_point_longitude"];

            //initial map area to be loaded with markers;
            $start_point_latitude = 41;
            $start_point_longitude = -73;
            $end_point_latitude = 30;
            $end_point_longitude = -90;
            $initial_map_description = 0;

            $sql_query = "";
            $params = array();

            //filter data only by two selected points
            function generateInitialQuery()
            {
                return "select city, state, zipcode, latitude, longitude from locations where longitude <= :filter_first_point_longitude
                                                                    and longitude >= :filter_second_point_longitude
                                                                    and latitude <= :filter_first_point_latitude
                                                                    and latitude >= :filter_second_point_latitude";
            }

            if($first_point_latitude == ""
                && $first_point_longitude == ""
                && $second_point_latitude == ""
                && $second_point_longitude == ""
                && $zip_code == ""
                && $city == ""
                && $state == "")
            {
                $sql_query = generateInitialQuery();

                $params = array("filter_first_point_longitude" => $start_point_longitude, 
                                "filter_second_point_longitude" => $end_point_longitude, 
                                "filter_first_point_latitude" => $start_point_latitude, 
                                "filter_second_point_latitude" => $end_point_latitude);

                $statement = $dbConnection->prepare($sql_query);
                $statement-> execute($params);
                
                $initial_map_description = 1; //used when putting description for the loaded markers on the map
            }
            else
            {
                $sql_query = "select city, state, zipcode, latitude, longitude from locations where";

                if($state != "")
                {
                    $sql_query = $sql_query . " state = :state";
                    $params["state"] = $state;
                }
                if($city != "")
                {
                    if($state != "")
                    {
                        $sql_query = $sql_query . " and city = :city";
                    }
                    else
                    {
                        $sql_query = $sql_query . " city = :city";
                    }
                    $params["city"] = $city;
                }
                if($zip_code != "")
                {
                    if($state != "" || $city != "")
                    {
                        $sql_query = $sql_query . " and zipcode = :zipcode";
                    }
                    else
                    {
                        $sql_query = $sql_query . " zipcode = :zipcode";
                    }
                    $params["zipcode"] = $zip_code;
                }
                if($first_point_latitude != "" && $first_point_longitude != "" && $second_point_latitude != "" && $second_point_longitude != "")
                {
                    if($state != "" || $city != "" || $zip_code != "")
                    {
                        $sql_query = $sql_query . " and longitude <= :filter_first_point_longitude
                                                and longitude >= :filter_second_point_longitude
                                                and latitude <= :filter_first_point_latitude
                                                and latitude >= :filter_second_point_latitude";
                    }
                    else
                    {
                        $sql_query = $sql_query . " longitude <= :filter_first_point_longitude
                                                and longitude >= :filter_second_point_longitude
                                                and latitude <= :filter_first_point_latitude
                                                and latitude >= :filter_second_point_latitude";
                    }

                    $params["filter_first_point_longitude"] = $first_point_longitude;
                    $params["filter_second_point_longitude"] = $second_point_longitude;
                    $params["filter_first_point_latitude"] = $first_point_latitude;
                    $params["filter_second_point_latitude"] = $second_point_latitude;
                }
            }

            $statement = $dbConnection->prepare($sql_query);
            $statement->execute($params);

            $latitude_array = array();
            $longitude_array = array();
            $cities = array();
            $states = array();
            $zipcodes = array();
            $result = $statement->fetchAll();

            if(count($result) > 0)
            {
                foreach($result as $row)
                {
                    $latitude_array[] = $row["latitude"];
                    $longitude_array[] = $row["longitude"];
                    $cities[] = $row["city"];
                    $states[] = $row["state"];
                    $zipcodes[] = $row["zipcode"];
                }
                
                $center_latitude = $latitude_array[0];
                $center_longitude = $longitude_array[0];
                $initial_zoom_level = 6;
            }
            else 
            {
                echo "\nThe input data is not matching any markers.";
                $center_latitude = 40;
                $center_longitude = -90;
                $initial_zoom_level = 4;
            }
            $dbConnection = null;
        ?>

        <script type="text/javascript">

            function initMap()
            {
                var lat_array =<?php echo json_encode($latitude_array); ?>;
                var lng_array = <?php echo json_encode($longitude_array); ?>;
                var cities = <?php echo json_encode($cities); ?>;
                var states = <?php echo json_encode($states); ?>;
                var zipcodes = <?php echo json_encode($zipcodes); ?>;

                //initial map options variables;
                var center_latitude = <?php echo $center_latitude; ?>;
                var center_longitude = <?php echo $center_longitude; ?>;
                var initial_zoom_level = <?php echo $initial_zoom_level; ?>;
                var initial_map_description = <?php echo $initial_map_description; ?>;
                
                if(!lat_array.length == 0 && !lng_array.length == 0)
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
                            position: new google.maps.LatLng(lat_array[i], lng_array[i]),
                            map: map,
                            city: cities[i],
                            state: states[i],
                            zipcode: zipcodes[i],
                            self_latitude: lat_array[i],
                            self_longitude: lng_array[i]
                        });
                    });

                    // Add a marker clusterer to manage the markers.
                    var markerCluster = new MarkerClusterer(map, markers,
                        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                    
                    //true -> for first marker
                    //false -> for second marker
                    var currentMarker = true;
                    var infowindow = new google.maps.InfoWindow();  
                    for (i = 0; i < markers.length; i++)
                    {
                        var marker = markers[i];

                        google.maps.event.addListener(marker,'click', (function(marker, infowindow){ 
                            return function() {
                                var contentString = "<div>" +
                                                        "<h1>City: " + marker.city + " </h1>" +
                                                        "<h3>State: " + marker.state + " </h3>" +
                                                        "<h3>Zipcode: " + marker.zipcode + " </h3>" +
                                                        "<h4> Latitude: " + marker.self_latitude + "  Longitude: " + marker.self_longitude + " </h4>" +
                                                    "</div>";
                                infowindow.setContent(contentString);
                                infowindow.open(map,marker);

                                if(currentMarker)
                                {
                                    document.forms["Form"]["first_point_latitude"].value = marker.self_latitude;
                                    document.forms["Form"]["first_point_longitude"].value = marker.self_longitude;
                                    currentMarker = !currentMarker;
                                }
                                else
                                {
                                    document.forms["Form"]["second_point_latitude"].value = marker.self_latitude;
                                    document.forms["Form"]["second_point_longitude"].value = marker.self_longitude;
                                    currentMarker = !currentMarker;
                                }
                            };
                        })(marker, infowindow));
                    }

                    document.getElementById('markers_count').innerHTML = '<p>Markers count: ' + markers.length + '</p>';
                    
                    //Description for the markers currently loaded on the map 
                    if(initial_map_description == 1)
                    {
                        document.getElementById('markers_description').innerHTML = '<p>These are the initial loaded markers around the east side of USA.<br>However, there are markers all around USA.<br>Use the filters below to select which markers you want to see.</p>';
                    }
                    else
                    {
                        document.getElementById('markers_description').innerHTML = '<p>These are the selected markers</p>';
                    }
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