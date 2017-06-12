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
        SELECT id FROM wines WHERE wines.name = ?;
stmt;
        $i_stmt = $mysqli->prepare($init_query);
        $i_stmt->bind_param('s', $_POST["w_name"]);
        $i_stmt->execute();
        $i_stmt->store_result();
        $i_stmt->bind_result($i_id);
        $i_num_rows = $i_stmt->num_rows;
        if ($i_num_rows > 0) {
            echo <<<res
            <h2>That wine is already stored in the database.</h2>
res;
            exit();
        }
        $i_stmt->close();
        $w_type = $_POST["w_type"];
        $w_color = $_POST["w_color"];
        $w_price = $_POST["w_price"];
        $query = <<<stmt
        INSERT INTO wines (name, color, type, price) VALUES (?, ?, ?, ?);
stmt;
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sssi', $_POST["w_name"], $w_color, $w_type, $w_price);
        $stmt->execute();
        $last_id = $stmt->insert_id;
        foreach ($_POST["w_found_at"] as $tastingRooms) {
            $temp_query = <<<stmt
            SELECT id FROM tastingRooms WHERE tastingRooms.name = ?;
stmt;
            $stmt_2 = $mysqli->prepare($temp_query);
            $stmt_2->bind_param('s', $tastingRooms);
            $stmt_2->execute();
            $stmt_2->bind_result($id);
            $stmt_2->fetch();
            $stmt_2->close();
            $temp_query_2 = <<<stmt
            INSERT INTO serves (wines_id, tastingRooms_id) VALUES (?, ?);
stmt;
            $stmt_3 = $mysqli->prepare($temp_query_2);
            $stmt_3->bind_param('ii', $last_id, $id);
            $stmt_3->execute();
            $stmt_3->close();
        }
        echo <<<res
        <h2> Thanks for contributing to my database, cheers!</h2>
res;
    ?>
    </body>
</html>
