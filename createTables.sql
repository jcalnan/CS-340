CREATE TABLE locations (
	id INT NOT NULL AUTO_INCREMENT,
	city VARCHAR(255),
	state VARCHAR(255) NOT NULL,
	UNIQUE (city, state),
	PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE wines (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	color VARCHAR(255) NOT NULL,
	type VARCHAR(255) NOT NULL,
	price INT,
	PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE amenities (
	id INT NOT NULL AUTO_INCREMENT,
	feature VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE tastingRooms (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	rank INT,
	locations_id INT NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (locations_id) REFERENCES locations (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE wineMakers (
	id INT NOT NULL AUTO_INCREMENT,
	age INT NOT NULL,
	f_name VARCHAR(255) NOT NULL,
	l_name VARCHAR(255) NOT NULL,
	yrs INT,
	gender VARCHAR(255) NOT NULL,
	tastingRooms_id INT NOT NULL,
	wines_id INT NOT NULL,
	PRIMARY KEY (id), 
	FOREIGN KEY (tastingRooms_id) REFERENCES tastingRooms (id) ON DELETE CASCADE,
	FOREIGN KEY (wines_id) REFERENCES wines (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE contains (
	amenities_id INT NOT NULL,
	tastingRooms_id INT NOT NULL,
	PRIMARY KEY (amenities_id, tastingRooms_id),
	FOREIGN KEY (amenities_id) REFERENCES amenities (id) ON DELETE CASCADE,
	FOREIGN KEY (tastingRooms_id) REFERENCES tastingRooms (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE serves (
	wines_id INT NOT NULL,
	tastingRooms_id INT NOT NULL,
	PRIMARY KEY (wines_id, tastingRooms_id),
	FOREIGN KEY (wines_id) REFERENCES wines (id) ON DELETE CASCADE,
	FOREIGN KEY (tastingRooms_id) REFERENCES tastingRooms (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
