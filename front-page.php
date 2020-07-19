<?php get_header();?>

    <h1 class="margin_style"> The map with locations</h1>
    <h3 class="margin_style" id="markers_count"></h3>

    <form class="margin_style" action="/wordpress/index.php" method="post">
        <label for="city">City</label><br>
        <input type="text" id="city" name="city"><br><br>
        <label for="state">State</label><br>
        <input type="text" id="state" name="state"><br><br>
        <label for="zip_code">Zipcode</label><br>
        <input type="text" id="zip_code" name="zip_code"><br><br>
        <label for="state">First point latitude</label><br>
        <input type="text" id="first_point_latitude" name="first_point_latitude"><br><br>
        <label for="state">First point longitude</label><br>
        <input type="text" id="first_point_longitude" name="first_point_longitude"><br><br>
        <label for="state">Second point latitude</label><br>
        <input type="text" id="second_point_latitude" name="second_point_latitude"><br><br>
        <label for="state">Second point longitude</label><br>
        <input type="text" id="second_point_longitude" name="second_point_longitude"><br>
        <input class="button button_style" type="submit" value="Submit">
    </form>

    <div id="marker_position">No selected marker yet.</div>
    <div id="map"></div>
<?php get_footer();?>