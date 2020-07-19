<?php get_header();?>

    <h1 class="margin_style"> The map with locations</h1>
    <h3 class="margin_style" id="markers_count"></h3>
    <h4 class="margin_style" id="markers_description"></h4>

    <form class="margin_style" action="/wordpress/index.php" method="post">
        <label for="city">City</label><br>
        <input type="text" id="city" 
                            name="city" 
                            value="<?php if (isset($_POST["city"])) echo $_POST["city"]; ?>"><br><br>

        <label for="state">State</label><br>
        <input type="text" id="state" 
                            name="state" 
                            value="<?php if (isset($_POST["state"])) echo $_POST["state"]; ?>"><br><br>

        <label for="zip_code">Zipcode</label><br>
        <input type="text" id="zip_code" 
                            name="zip_code" 
                            value="<?php if (isset($_POST["zip_code"])) echo $_POST["zip_code"]; ?>"><br><br>

        <label for="state">First point latitude</label><br>
        <input type="text" id="first_point_latitude" 
                            name="first_point_latitude" 
                            value="<?php if (isset($_POST["first_point_latitude"])) echo $_POST["first_point_latitude"]; ?>"><br><br>

        <label for="state">First point longitude</label><br>
        <input type="text" id="first_point_longitude" 
                            name="first_point_longitude" 
                            value="<?php if (isset($_POST["first_point_longitude"])) echo $_POST["first_point_longitude"]; ?>"><br><br>

        <label for="state">Second point latitude</label><br>
        <input type="text" id="second_point_latitude" 
                            name="second_point_latitude" 
                            value="<?php if (isset($_POST["second_point_latitude"])) echo $_POST["second_point_latitude"]; ?>"><br><br>

        <label for="state">Second point longitude</label><br>
        <input type="text" id="second_point_longitude" 
                            name="second_point_longitude" 
                            value="<?php if (isset($_POST["second_point_longitude"])) echo $_POST["second_point_longitude"]; ?>"><br>

        <input class="button button_style" type="submit" value="Submit">
    </form>

    <div id="marker_position">No selected marker yet. 
                            <br>Make sure that the first marker is the top right and the second is the bottom left marker.
                            <br>Otherwise the input data will not be valid</div>
    <div id="map"></div>
<?php get_footer();?>