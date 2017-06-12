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
        <link rel="stylesheet" href="./public/css/wine.css">
    </head>
    <body>
        <h2>Wines returned from query:</h2>
        <div id="main">
            <table class="table">
                <tr>
                    <th>Wine Name</th>
                    <th>Type</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Found At</th>
                </tr>
            <?php

                if ($_GET["w_type"] != "Select Wine Type" && $_GET["w_color"] != "Select Wine Color"
                    && $_GET["w_price"] != "Select Price Per Glass") {
		    $type = mysqli_real_escape_string($mysqli, $_GET["w_type"]);
                    $color = mysqli_real_escape_string($mysqli, $_GET["w_color"]);
                    $price = mysqli_real_escape_string($mysqli, $_GET["w_price"]);
	            $lo = 0;
                    $hi = 0;
                    if ($price == "0-5") {
                        $lo = 0; $hi = 5;
                    } else if ($price == "5-10") {
                        $lo = 5; $hi = 10;
                    } else {
                        $lo = 10; $hi = 100;
                    }
			
                    $query = <<<stmt
                    SELECT wines.name, wines.type, wines.color, wines.price, GROUP_CONCAT(tastingRooms.name) AS found_at
                    FROM tastingRooms INNER JOIN serves on tastingRooms.id = serves.tastingRooms_id INNER JOIN wines ON
                    wines.id = serves.wines_id WHERE wines.type = ? AND wines.color = ? AND wines.price > ?
                    AND wines.price < ? GROUP BY wines.name;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('ssii', $type, $color, $lo, $hi);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($name, $color, $type, $price, $found_at);
                    $num_rows = $stmt->num_rows;
                    if ($num_rows > 0) {
                        while ( $stmt->fetch() ) {
                            echo <<<res
                            <tr>
                                <td>$name</td>
                                <td>$color</td>
                                <td>$type</td>
                                <td>$price</td>
                                <td>$found_at</td>
                            </tr>
res;
                        }
                    } else {
                        echo <<<res
                        <h2>I'm sorry, no matching wines were found in the database with your search parameters.
                        Please go back and try again, or add a wine that you know fits
                        the description!</h2>
res;
                    }
                } else {
                    $query = <<<stmt
                    SELECT wines.name, wines.type, wines.color, wines.price, GROUP_CONCAT(tastingRooms.name) AS found_at
                    FROM tastingRooms INNER JOIN serves on tastingRooms.id = serves.tastingRooms_id INNER JOIN wines ON
                    wines.id = serves.wines_id GROUP BY wines.name;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($name, $color, $type, $price, $found_at);
                    $num_rows = $stmt->num_rows;
                    if ($num_rows > 0) {
                        while ( $stmt->fetch() ) {
                            echo <<<res
                        <tr>
                            <td>$name</td>
                            <td>$color</td>
                            <td>$type</td>
                            <td>$price</td>
                            <td>$found_at</td>
                        </tr>
res;
                        }
                    } else {
                        echo <<<res
                        <h2>I'm sorry, no matching wines were found in the database with your search parameters.
                        Please go back and try again, or add a wine that you know fits 
                        the description!</h2>
res;
                    }
                }
            ?>

            </table>
        </div>
    </body>

</html>
