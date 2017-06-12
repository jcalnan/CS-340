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
    </head>
    <body>
    <?php
		
        $init_query = <<<stmt
        SELECT id FROM tastingRooms WHERE tastingRooms.name = ?;
stmt;
        $i_stmt = $mysqli->prepare($init_query);
        $i_stmt->bind_param('s', $_POST["TR_name"]);
        $i_stmt->execute();
        $i_stmt->store_result();
        $i_stmt->bind_result($i_id);
        $i_num_rows = $i_stmt->num_rows;
        if ($i_num_rows > 0) {
            echo <<<res
            <h2>That tasting room is already in the database.</h2>
res;
            exit();
        }
        $i_stmt->close();
        $city = $_POST["TR_city"];
        $state = $_POST["TR_state"];
        $rank = $_POST["TR_rank"];
        $query = <<<stmt
        SELECT id FROM locations WHERE locations.city = ? AND locations.state = ?;
stmt;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ss', $city, $state);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);
        $num_rows = $stmt->num_rows;
        if ($num_rows > 0) {
            $stmt->fetch();
            $secondary_query = <<<stmt
            INSERT INTO tastingRooms (name, rank, locations_id) VALUES (?, ?, ?);
stmt;
            $stmt_2 = $mysqli->prepare($secondary_query);
            $stmt_2->bind_param('sii', $_POST["TR_name"], $rank, $id);
            $stmt_2->execute();
            $last_id = $stmt_2->insert_id;
            foreach ($_POST["TR_amenities"] as $amenities) {
                $temp_query = <<<stmt
                SELECT id FROM amenities WHERE amenities.feature = ?;
stmt;
                $stmt_3 = $mysqli->prepare($temp_query);
                $stmt_3->bind_param('s', $amenities);
                $stmt_3->execute();
                $stmt_3->bind_result($id);
                $stmt_3->fetch();
                $stmt_3->close();
                $temp_query_2 = <<<stmt
                INSERT INTO contains (amenities_id, tastingRooms_id) VALUES (?, ?);
stmt;
                $stmt_4 = $mysqli->prepare($temp_query_2);
                $stmt_4->bind_param('ii', $id, $last_id);
                $stmt_4->execute();
                $stmt_4->close();
            }
            echo <<<res
            <h2>
                Thanks for contributing to the database, cheers!
            </h2>
res;
        } else {
            $secondary_query = <<<stmt
            INSERT INTO locations (city, state) VALUES (?, ?);
stmt;
            $stmt_2 = $mysqli->prepare($secondary_query);
            $stmt_2->bind_param('ss', $city, $state);
            $stmt_2->execute();
            $last_loc_id = $stmt_2->insert_id;
            $ter_query = <<< stmt
            INSERT INTO tastingRooms (name, rank, locations_id) VALUES (?, ?, ?);
stmt;
            $stmt_3 = $mysqli->prepare($ter_query);
            $stmt_3->bind_param('sii', $_POST["TR_name"], $rank, $last_loc_id);
            $stmt_3->execute();
            $last_TR_id = $stmt_3->insert_id;
            foreach ($_POST["TR_amenities"] as $amenities) {
                $temp_query = <<<stmt
                SELECT id FROM amenities WHERE amenities.feature = ?;
stmt;
                $stmt_4 = $mysqli->prepare($temp_query);
                $stmt_4->bind_param('s', $amenities);
                $stmt_4->execute();
                $stmt_4->bind_result($id);
                $stmt_4->fetch();
                $stmt_4->close();
                $temp_query_2 = <<<stmt
                INSERT INTO contains (amenities_id, tastingRooms_id) VALUES (?, ?);
stmt;
                $stmt_5 = $mysqli->prepare($temp_query_2);
                $stmt_5->bind_param('ii', $id, $last_TR_id);
                $stmt_5->execute();
                $stmt_5->close();
            }
            echo <<<res
            <h2>
                Thanks for contributing to the database, cheers!
            </h2>
res;
        }
    ?>
    </body>
</html>
