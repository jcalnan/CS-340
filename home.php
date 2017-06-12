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
        <link rel="stylesheet" href="./public/css/home.css">
    </head>
    <body>
        <div id="main">
            <h2>Welcome to the Wine Tasting Room Database!</h2>
            <h3>
                <p>
                    I have dedicated this website to access a database providing
                    information on tasting rooms in the USA.  Whether you want to discover
                    great new wines or find out what winemakers themselves are drinking,
                    you have come to the right place! This database also covers the locations 
					of tasting rooms nationwide, their rankins based on reviews, the wines they 
					serve, and the wonderful features of each establishment. The great news is, you 
					get to be a part of expanding this database for the use of other wine lovers 
					by simply clicking the 'add' flag at the top of your screen and typing in your 
					information! (*Most information in this database is fictional for the purpose of
					the final project. Some information is accurate based on research.)
                </p>
            </h3>
            <h4>
                Top 5 Rated Tasting Rooms:
            </h4>
            <ol>
                <?php
                $query = <<<stmt
                SELECT name, rank FROM tastingRooms
                ORDER BY rank DESC limit 5;
stmt;
                $stmt = $mysqli->prepare($query);
                $stmt->execute();
                $stmt->bind_result($name, $rank);
                while ($stmt->fetch()) {
                    echo <<<res
                    <li>$name $rank/5</li>
res;
                }
                ?>
            </ol>
        </div>
    </body>
</html>
