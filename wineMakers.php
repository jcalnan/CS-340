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
        <link rel="stylesheet" href="./public/css/wineMakers.css">
    </head>
    <body>
        <div id="main">
            <h2>
                If you would like more information about a particular wine,<br>
                for example, who makes it, we can provide a little bit of information<br>
                about the wine makers themselves, if their winery is connected to the tasting room.<br> 
				Or, if you are looking for a great new wine to try, the wine maker's favorite 
				vino could be a great place to start! <br>
                (Choose a specific location)
            </h2>

            <form class="form-inline" action="wm_search.php" method="GET">

                <select class="c-select" name="wm_locations">
                    <option selected>Choose Tasting Room Location</option>
                    <?php
                    $query =<<<stmt
                    SELECT city, state FROM locations;
stmt;
                    $stmt = $mysqli->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($city, $state);
                    while ( $stmt->fetch() ) {
                        echo <<<res
                        <option>$city, $state</option>
res;
                    }
                    ?>
                </select>

                <button type="submit" class="btn btn-primary">Search Tasting Room Locations</button>
            </form>
        </div>
    </body>
</html>
