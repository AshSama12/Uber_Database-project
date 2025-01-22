CREATE DATABASE test;

use test;

CREATE TABLE trips (
	trip_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT(11) NOT NULL,
	startlocation VARCHAR(30) NOT NULL,
	endlocation VARCHAR(30) NOT NULL,
	tripdays INT(10) NOT NULL,
	vehicletype VARCHAR(10) NOT NULL,
	date TIMESTAMP
);

CREATE INDEX idx_trips_trip_id ON trips(trip_id);

CREATE TABLE users (
	user_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	NIC INT(11) NOT NULL,
	name VARCHAR(30) NOT NULL,
	address VARCHAR(50) NOT NULL,
	telephone INT(10) NOT NULL,
	trip_id INT(10) NOT NULL,
	destination VARCHAR(30) NOT NULL,
	date TIMESTAMP
);

CREATE INDEX idx_users_user_id ON users(user_id);

CREATE TABLE trip_user (
    trip_user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    trip_id INT(11) UNSIGNED,
    user_id INT(11) UNSIGNED,
    FOREIGN KEY (trip_id) REFERENCES trips(trip_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
