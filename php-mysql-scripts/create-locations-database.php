<?php
    //database credentials
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "wordpressadmin";
    $dbname = "wordpress";

    //connecting to the database
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    //checking if the connection is successful
    if($connection -> connect_error)
    {
        die("Connection failed: " . $connection->connect_error);
    }
    
    // sql to create locations table
    $sql = "CREATE TABLE locations (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        zipcode VARCHAR(5) NOT NULL,
        city VARCHAR(30) NOT NULL,
        state_ VARCHAR(2) NOT NULL,
        latitude DECIMAL(9, 6) NOT NULL,
        longitude DECIMAL(9, 6) NOT NULL
    )";
    
    if ($connection->query($sql) === TRUE) {
        echo "Table locations was created successfully\n";
    } else {
        echo "Error creating locations table: " . $connection->error . "\n";
    }
    
    $connection->close();
?>