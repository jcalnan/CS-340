<?php
	ini_set('display_errors', 'On');
					//Connects to the database
					$mysqli = new mysqli("classmysql.engr.oregonstate.edu","cs340_calnanj","6902","cs340_calnanj");
					if(!$mysqli || $mysqli->connect_errno){
					echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
    include 'template.php';
?>

<html>

    <head>
        <link rel="stylesheet" href="./public/css/add.css">
        <script src="./public/js/add.js"></script>
    </head>

    <body>
        <h2>
            Please complete a form below and click 'Add' to add your information to our database!<br>
            *Please enter all information and only submit one form at a time.
        </h2>

        <div id="main">

            <select class="c-select" id="form_toggle">
                <option selected>Select Information To Add...</option>
                <option>Add Tasting Room</option>
                <option>Add Wine</option>
            </select>
                <br>
                <br>
            <form method="POST" action="tastingRoom_add.php" id="f_TR_add">
                <label for="TR_name">Tasting Room Name</label>
                <input type="text" name="TR_name" id="TR_name">

                <label for="TR_city">City</label>
                <input type="text" name="TR_city" id="TR_city">

                <label for="TR_state">State</label>
                <select id="TR_state" name="TR_state">
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>
                    <br><br>
                <label for="TR_amenities">Tasting Room Features (Ctrl + Click for multiple)</label>
                <select multiple class="c_select" id="TR_amenities" name="TR_amenities[]">
                    <?php
                    $query = <<<stmt
                    SELECT feature FROM amenities;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($feature);
                    while ( $stmt->fetch() ) {
                        echo <<<res
                        <option>$feature</option>
res;
                    }
                    ?>
                </select>

                <label for="TR_rank">Tasting Room Ranking</label>
                <select class="c-select" id="TR_rank" name="TR_rank">
                    <option selected>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
                    <br>
                    <br>
                <button type="submit" class="btn btn-primary" id="TR_add">Add Tasting Room</button>
            </form>

            <form method="POST" action="wine_add.php" id="f_w_add">
                <label for="w_name">Wine Name</label>
                <input type="text" name="w_name" id="w_name">

                <label for="w_type">Wine Type</label>
                <select class="c_select" id="w_type" name="w_type">
                    <option selected>Select Type...</option>
                    <option>Riesling</option>
                    <option>Chardonnay</option>
					<option>Sauvignon Blanc</option>
					<option>Pinot Grigio</option>
					<option>Syrah</option>
					<option>Merlot</option>
					<option>Malbec</option>
					<option>Pinot Noir</option>
					<option>Cabernet Sauvignon</option>
					<option>Red Blend</option>
					<option>White Blend</option>
					<option>Rose</option>
                </select>
				
				<label for="w_color">Wine Color</label>
                <input type="text" name="w_color" id="w_color">
				
                <label for="w_price">Price Per Glass</label>
                <input type="int" name="w_price" id="w_price">
                    <br><br>
                <label for="w_found_at">Found At (Ctrl + Click for multiple)</label>
                <select multiple class="c_select" id="w_found_at" name="w_found_at[]">
                    <?php
                        $query = <<<stmt
                        SELECT name FROM tastingRooms;
stmt;
                        $stmt = $mysqli->prepare($query);
                        $stmt->execute();
                        $stmt->bind_result($name);
                        while( $stmt->fetch() ) {
                            echo <<<res
                            <option>$name</option>
res;
                        }
                    ?>
                </select>
                    <br>
                    <br>
                <button type="submit" class="btn btn-primary" id="w_add">Add Wine</button>
            </form>

        </div>

    </body>
</html>
