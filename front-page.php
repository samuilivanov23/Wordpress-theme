<?php get_header();?>

    <h1> The map with locations</h1>
    <h3 id="markers_count"></h3>

    <form action="/wordpress/index.php" method="post">
        <label for="city">City</label><br>
        <input type="text" id="city" name="city"><br>
        <label for="state">State</label><br>
        <input type="text" id="state" name="state"><br><br>
        <label for="state">First point latitude</label><br>
        <input type="text" id="first_point_latitude" name="first_point_latitude"><br><br>
        <label for="state">First point longitude</label><br>
        <input type="text" id="first_point_longitude" name="first_point_longitude"><br><br>
        <label for="state">Second point latitude</label><br>
        <input type="text" id="second_point_latitude" name="second_point_latitude"><br><br>
        <label for="state">Second point longitude</label><br>
        <input type="text" id="second_point_longitude" name="second_point_longitude"><br><br>
        <input type="submit" value="Submit">
    </form>

    <div id="map"></div>
    <div id="marker_position">No selected marker yet.</div>
<?php get_footer();?>