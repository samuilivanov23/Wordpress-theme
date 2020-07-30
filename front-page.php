<?php get_header();?>

    <h1 class="margin_style"> The map with locations</h1>
    <h3 class="margin_style" id="markers_count"></h3>
    <h4 class="margin_style" id="markers_description"></h4>

    <form name="Form" autocomplete="off" class="margin_style" action="/wordpress/index.php" method="post">
        <div class="autocomplete" style="width:300px">
            <label for="city">City</label><br>
            <input id = "myInputCities" type="text" id="city" 
                                name="city" 
                                value="<?php if (isset($_POST["city"])) echo $_POST["city"]; ?>"><br><br>
        </div>
        
        <div class="autocomplete" style="width:300px">
            <label for="state">State</label><br>
            <input id = "myInputStates" type="text" id="state" 
                                name="state" 
                                value="<?php if (isset($_POST["state"])) echo $_POST["state"]; ?>"><br><br>
        </div>
        
        <div class="autocomplete" style="width:300px">
            <label for="zip_code">Zipcode</label><br>
            <input id = "myInputZipcodes" type="text" id="zip_code" 
                                name="zip_code" 
                                value="<?php if (isset($_POST["zip_code"])) echo $_POST["zip_code"]; ?>"><br><br>
        </div>
        
        <div class="autocomplete" style="width:300px">
            <label for="state">First point latitude</label><br>
            <input type="text" id="first_point_latitude" 
                                name="first_point_latitude" 
                                value="<?php if (isset($_POST["first_point_latitude"])) echo $_POST["first_point_latitude"]; ?>"><br><br>
        </div>
        
        <div class="autocomplete" style="width:300px">
            <label for="state">First point longitude</label><br>
            <input type="text" id="first_point_longitude" 
                                name="first_point_longitude" 
                                value="<?php if (isset($_POST["first_point_longitude"])) echo $_POST["first_point_longitude"]; ?>"><br><br>
        </div>
        
        <div class="autocomplete" style="width:300px">
            <label for="state">Second point latitude</label><br>
            <input type="text" id="second_point_latitude" 
                                name="second_point_latitude" 
                                value="<?php if (isset($_POST["second_point_latitude"])) echo $_POST["second_point_latitude"]; ?>"><br><br>
        </div>
        
        <div class="autocomplete" style="width:300px">
            <label for="state">Second point longitude</label><br>
            <input type="text" id="second_point_longitude" 
                                name="second_point_longitude" 
                                value="<?php if (isset($_POST["second_point_longitude"])) echo $_POST["second_point_longitude"]; ?>"><br>
        </div>
        
        <div>
            <input class="button button_style" type="submit" value="Submit">
            <?php
                if($_POST["city"] != "" || 
                   $_POST["state"] != "" || 
                   $_POST["zip_code"] != "" || 
                   $_POST["first_point_latitude"] != "" || 
                   $_POST["first_point_longitude"] != "" || 
                   $_POST["second_point_latitude"] != "" || 
                   $_POST["second_point_longitude"] != "")
                   {
                       echo "<a onclick='clearFilters()' class='button button_style margin_style'>Clear</a>";
                   }
            ?>
        </div>
    </form>


    <div id="marker_position">
                            <br><b>Make sure that the first marker is the top right and the second is the bottom left marker.</b>
                            <br>Otherwise the input data will not be valid</div>
    <div id="map"></div>

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

        $sql_query = "";

        //takes all zipcodes existing in the databse
        if($_POST["city"] != "")
        {
            $sql_query = "select zipcode from locations where city = '" . $_POST["city"] . "'";
        }
        else if($_POST["state"] != "")
        {
            $sql_query = "select zipcode from locations where state = '" . $_POST["state"] . "'";
        }
        else
        {
            $sql_query = "select zipcode from locations";
        }

        $statement = $dbConnection->prepare($sql_query);
        $statement-> execute();
        $result = $statement->fetchAll();
        $zipcodes = array();

        foreach($result as $row)
        {
           $zipcodes[] = $row["zipcode"];
        }

        //takes all cities existing in the database
        if ($_POST["state"] != "")
        {
            $sql_query = "select distinct city from locations where state = '" . $_POST["state"] . "'";
        }
        else
        {
            $sql_query = "select distinct city from locations";
        }

        $statement = $dbConnection->prepare($sql_query);
        $statement-> execute();
        $result = $statement->fetchAll();
        $cities = array();

        foreach($result as $row)
        {
           $cities[] = $row["city"];
        }

        //takes all states existing in the database
        $sql_query = "select distinct state from locations";
        $statement = $dbConnection->prepare($sql_query);
        $statement-> execute();
        $result = $statement->fetchAll();
        $states = array();

        foreach($result as $row)
        {
           $states[] = $row["state"];
        }
    ?>

    <script type="text/javascript">

        function clearFilters()
        {
            document.forms["Form"]["city"].value = "";
            document.forms["Form"]["state"].value = "";
            document.forms["Form"]["zip_code"].value = "";
            document.forms["Form"]["first_point_latitude"].value = "";
            document.forms["Form"]["first_point_longitude"].value = "";
            document.forms["Form"]["second_point_latitude"].value = "";
            document.forms["Form"]["second_point_longitude"].value = "";
        }

        //first arg -> the text field
        //second arg -> the array of cities
        function autocomplete(input, cities) 
        {
            //used to track which is the active city we are about to choose
            var currentFocus;
            
            //executed when someone writes in the text field
            input.addEventListener("input", function(e) 
            {
                var all_items_div, single_item_div, i, val = this.value;
                //close any already open lists of autocompleted values
                closeAllLists();

                if (!val) 
                {
                    return false;
                }

                currentFocus = -1;

                //create div element that will contain all the items
                all_items_div = document.createElement("DIV");
                all_items_div.setAttribute("id", this.id + "autocomplete-list");
                all_items_div.setAttribute("class", "autocomplete-items");

                //append this div elemetn as a child of the input field
                this.parentNode.appendChild(all_items_div);

                //iterate through the array of cities
                for (i = 0; i < cities.length; i++) {

                    //check if the item's first letter matches with the text field value first letter
                    if (cities[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) 
                    {
                        //create div element for each maching item
                        single_item_div = document.createElement("DIV");

                        //make the matching letters bold
                        single_item_div.innerHTML = "<strong>" + cities[i].substr(0, val.length) + "</strong>";
                        //the rest of the letters are normal
                        single_item_div.innerHTML += cities[i].substr(val.length); 
                        
                        //add input field that will hold the current items's value (the name of the city)
                        single_item_div.innerHTML += "<input type='hidden' value='" + cities[i] + "'>";
                        
                        //close all autocomplete items (matching items) if someone click on the current item's value
                        single_item_div.addEventListener("click", function(e) {
                            //insert the clicked item's value in the input text field
                            input.value = this.getElementsByTagName("input")[0].value;

                            //then close the list of all other autocomplete values (matching values)
                            closeAllLists();
                        });

                        //add the individual item's div element as a child of the autocomplete container
                        all_items_div.appendChild(single_item_div);
                    }
                }
            });

            //executed when a key is pressed
            input.addEventListener("keydown", function(pressed_key) 
            {
                var items = document.getElementById(this.id + "autocomplete-list");
                if (items) items = items.getElementsByTagName("div");

                //if the arrow DOWN is pressed
                if (pressed_key.keyCode == 40) 
                {
                    //increase the currentFocus 
                    //and make the current item active
                    currentFocus++;
                    addActive(items);
                }
                //if the arrow UP is pressed
                else if (pressed_key.keyCode == 38) 
                {
                    //decrease the currentFocus 
                    //and make the current item active
                    currentFocus--;
                    addActive(items);
                } 
                //if the ENTER key is pressed, prevent the form from being submitted
                else if (pressed_key.keyCode == 13) 
                {
                    pressed_key.preventDefault();
                    if (currentFocus > -1) 
                    {
                        //simulate click on the current "active" item
                        if (items) items[currentFocus].click();
                    }
                }
            });

            //classify and item as "active"
            function addActive(items) 
            {
                if (!items) return false; //no active items

                //remove the "active" class from all items
                removeActive(items);

                if (currentFocus >= items.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (items.length - 1);

                //adding the "autocomplete-active" class
                items[currentFocus].classList.add("autocomplete-active");
            }

            //remove the "active" classe from all autocomplete items;
            function removeActive(autocomplete_active_items)
            {
                for (var i = 0; i < autocomplete_active_items.length; i++) 
                {
                    autocomplete_active_items[i].classList.remove("autocomplete-active");
                }
            }

            //close all autocomplete lists
            //except the one passed as an argument
            function closeAllLists(element) 
            {
                var items = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < items.length; i++) {
                    if (element != items[i] && element != input) {
                        items[i].parentNode.removeChild(items[i]);
                    }
                }
            }

            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) 
            {
                closeAllLists(e.target);
            });
        }

        var cities = <?php echo json_encode($cities); ?>;
        var states = <?php echo json_encode($states); ?>;
        var zipcodes = <?php echo json_encode($zipcodes); ?>;

        autocomplete(document.getElementById("myInputCities"), cities);
        autocomplete(document.getElementById("myInputStates"), states);
        autocomplete(document.getElementById("myInputZipcodes"), zipcodes);

    </script>
<?php get_footer();?>