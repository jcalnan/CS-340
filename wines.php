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

        <div id="main">
            <h2>
                Please use the search parameters below to view the many wine variations offered by the tasting rooms in the database.<br>
                Or, click 'Search Wines' without using advanced filters to get all the wines contained in the database.
            </h2>
            <form class="form-inline" action="w_search.php" method="GET">

                <select class="c-select" name="w_type">
                    <option selected>Select Wine Type</option>
                    <?php
                    $query = <<<stmt
                    SELECT DISTINCT type FROM wines;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($db_data);
                   while ( $stmt->fetch() ) {
                       echo <<<res
                        <option>$db_data</option>
res;
                    }
                    ?>
                </select>

                <select class="c-select" name="w_color">
                    <option selected>Select Wine Color</option>
                    <?php
                    $query = <<<stmt
                    SELECT DISTINCT color FROM wines;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($db_data);
                    while ($stmt->fetch()) {
                        echo <<<res
                        <option>$db_data</option>
res;
                    }
                    ?>
                </select>

                <select class="c-select" name="w_price">
                    <option selected>Select Price Per Glass</option>
		   <?php
					 
                    $query = <<<stmt
                    SELECT DISTINCT price FROM wines;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($db_data);
                    while ($stmt->fetch()) {
                        echo <<<res
                        <option>$db_data</option>
res;
                    }
                    ?>
                </select>

                <button type="submit" class="btn btn-primary">Search Wines</button>
            </form>
        </div>
    </body>
</html>
