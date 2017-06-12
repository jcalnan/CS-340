<?php
ini_set('display_errors', 'On');
	//Connects to the database
	$mysqli = new mysqli("classmysql.engr.oregonstate.edu","cs340_calnanj","6902","cs340_calnanj");
	if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}
    include 'template.php'

?>

<html>
    <head>
        <link rel="stylesheet" href="./public/css/wineMakers.css">
    </head>
    <body>
        <h2>Wine Makers returned by query:</h2>
        <div id="main">

            <table class="table">
                <tr>
                    <th>Tasting Room</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Years as Vintner</th>
                    <th>Favorite Wine</th>
                </tr>
                <?php
                    if ($_GET["wm_locations"] != "Choose Tasting Room Location") {
                        $loc_str = $_GET["wm_locations"];
                        $loc_pieces = explode(",", $loc_str);
                        $city = trim($loc_pieces[0]);
                        $state = trim($loc_pieces[1]);
                        echo <<<res
                        Showing all wineMakers working at tastingRooms in $city, $state.
res;
                        $query = <<<stmt
                        SELECT tastingRooms.name AS TR_name, wineMakers.f_name, wineMakers.l_name,
                        wineMakers.age, wineMakers.gender, wineMakers.yrs, wines.name AS fav_wine
                        FROM wineMakers INNER JOIN wines ON wineMakers.wines_id = wines.id INNER JOIN
                        tastingRooms ON wineMakers.tastingRooms_id = tastingRooms.id INNER JOIN locations ON
                        tastingRooms.locations_id = locations.id WHERE locations.city = ?
                        AND locations.state = ?;
stmt;
                        $stmt = $mysqli->prepare($query);
                        $stmt->bind_param('ss', $city, $state);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($TR_name, $f_name, $l_name, $age, $gen, $yrs, $fav_wine);
                        $num_rows = $stmt->num_rows;
                        if ($num_rows == 0) {
                            echo <<<res
                            <h2>Sorry, we do not show any wine makers' records for that specific location at this time.</h2>
res;
                            exit();
                        }
                        while ( $stmt->fetch() ) {
                            echo <<<res
                            <tr>
                                <td>$TR_name</td>
                                <td>$f_name $l_name</td>
                                <td>$age</td>
                                <td>$gen</td>
                                <td>$yrs</td>
                                <td>$fav_wine</td>
                            </tr>
res;
                        }
                    } else {
                        echo <<<res
                        <h2>Showing all wine makers stored in the database.</h2>
res;
                        $query = <<<stmt
                        SELECT tastingRooms.name AS TR_name, wineMakers.f_name, wineMakers.l_name,
                        wineMakers.age, wineMakers.gender, wineMakers.yrs, wines.name AS fav_wine
                        FROM wineMakers INNER JOIN wines ON wineMakers.wines_id = wines.id INNER JOIN
                        tastingRooms ON wineMakers.tastingRooms_id = tastingRooms.id;
stmt;
                        $stmt = $mysqli->prepare($query);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($TR_name, $f_name, $l_name, $age, $gen, $yrs, $fav_wine);
                        $num_rows = $stmt->num_rows;
                        if ($num_rows == 0) {
                            echo <<<res
                            <h2>Sorry, we do not show any wine makers' records for that specific location at this time.</h2>
res;
                            exit();
                        }
                        while ( $stmt->fetch() ) {
                            echo <<<res
                            <tr>
                                <td>$TR_name</td>
                                <td>$f_name, $l_name</td>
                                <td>$age</td>
                                <td>$gen</td>
                                <td>$yrs</td>
                                <td>$fav_wine</td>
                            </tr>
res;
                        }
                    }
                ?>

            </table>
        </div>
    </body>
</html>
