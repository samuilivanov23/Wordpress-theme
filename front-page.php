<?php get_header();?>

    <h1> The map with locations</h1>

    <form action="/wordpress/index.php" method="post">
        <label for="city">City</label><br>
        <input type="text" id="city" name="city"><br>
        <label for="state">State:</label><br>
        <input type="text" id="state" name="state"><br><br>
        <input type="submit" value="Submit">
    </form>

    <div id="map">
    </div>

<?php get_footer();?>