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
</head>
    <body>
        <?php
            $query = <<<stmt
                    DELETE FROM wines WHERE wines.name = ?;
stmt;
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $_POST["w_select"]);
            if ( !$stmt->execute() ) {
                echo <<<res
                    <h2>Oops! Please try again.</h2>
res;
            } else {
                echo <<<res
                    <h2>That wine was deleted!</h2>
res;
            }
            $stmt->close();
        ?>
    </body>
</html>
