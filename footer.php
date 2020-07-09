<?php wp_footer();?>

<?php

    echo "
    <table>
        <tr>
            <th>Id</th>
            <th>Latitude<th>
            <th>Longitude</th>
        </tr>";

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
        echo "not working";
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
            $latitude_array[] = $row["latitude"];
            $longitude_array[] = $row["longitude"];

            echo "<tr><td>" . $row["id"] . "</td><td>" 
            . $row["latitude"] . "</td><td>" 
            . $row["longitude"] . "</td><tr>";
        }

        echo "</table>";
    }
    else 
    {
        echo "No rows in this table";
    }
    // print_r($longitude_array[0]);
    // print_r($latitude_array[1]);
    mysqli_close($connection);
?>

</body>
</html>