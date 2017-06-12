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
        <link rel="stylesheet" href="./public/css/add.css">
        <script src="./public/js/delete.js"></script>
    </head>

    <body>
        <h2>
            Please select one of the forms below and click 'Delete' to delete an item from the database!<br>
        </h2>

        <div id="main">

            <select class="c-select" id="form_toggle">
                <option selected>Select Option To Delete...</option>
                <option>Delete Tasting Room</option>
                <option>Delete Wine</option>
            </select>
                <br>
                <br>

            <form method="POST" action="tastingRoom_delete.php" id="f_TR_delete">
                <label for="TR_select">Tasting Room:</label>
                <select class="c-select" name="TR_select" id="TR_select">
                    <option selected>Select Tasting Room...</option>
                    <?php
                    $query = <<<stmt
                    SELECT name FROM tastingRooms;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($name);
                    while ( $stmt->fetch() ) {
                        echo <<<res
                        <option>$name</option>
res;
                    }
                    ?>
                </select>
                <br><br>
                <button type="submit" class="btn btn-primary" id="TR_delete">Delete</button>
            </form>

            <form method="POST" action="wine_delete.php" id="f_w_delete">
                <label for="w_select">Wine:</label>
                <select class="c-select" name="w_select" id="w_select">
                    <option selected>Select wine...</option>
                    <?php
                    $query = <<<stmt
                    SELECT name FROM wines;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($name);
                    while ( $stmt->fetch() ) {
                        echo <<<res
                        <option>$name</option>
res;
                    }
                    ?>
                </select>
                <br><br>
                <button type="submit" class="btn btn-primary" id="w_delete">Delete</button>
            </form>

        </div>
    </body>
</html>
