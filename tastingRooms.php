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
        <link rel="stylesheet" href="./public/css/tastingRooms.css">
    </head>
    <body>

        <div id="main">
            <h2>
                All the tasting rooms in the database are shown below. Please help me build my database by<br>
                adding any wine tasting rooms you know of. *If a tasting room already exists,<br>
                you will not ba able to add it.
            </h2>

        <table class="table">
                <tr>
                    <th>Tasting Room Name</th>
                    <th>Rank Based on Reviews (Out of 5)</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Features</th>
                </tr>
            <?php
                $query = <<<stmt
                SELECT tastingRooms.name, tastingRooms.rank, locations.city, locations.state,
                GROUP_CONCAT(amenities.feature) AS feature FROM tastingRooms INNER JOIN locations ON
                tastingRooms.locations_id = locations.id INNER JOIN contains ON tastingRooms.id = contains.tastingRooms_id
                INNER JOIN amenities ON amenities.id = contains.amenities_id GROUP BY tastingRooms.name;
stmt;
                $stmt = $mysqli->prepare($query);
                $stmt->execute();
                $stmt->bind_result($TR_name, $TR_rank, $TR_city, $TR_state, $amenities);
                while ( $stmt->fetch() ) {
                    echo <<<res
                    <tr>
                        <td>$TR_name</td>
                        <td>$TR_rank</td>
                        <td>$TR_city</td>
                        <td>$TR_state</td>
                        <td>$amenities</td>
                    </tr>
res;
                }
            ?>
        </table>

        </div>

    </body>
</html>
