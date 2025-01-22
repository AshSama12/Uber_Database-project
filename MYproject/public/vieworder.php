<?php
require "../config.php"; // Include your database configuration
require "../common.php"; // Include any common functions you might need

if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM trips WHERE trip_id = :trip_id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':trip_id', $trip_id);
        $statement->execute();
        $trip = $statement->fetch();

        if ($trip) { // Corrected variable name to $trip
            echo '<h2>View Trip Details</h2>';
            echo '<table>';
            echo '<tr><td><strong>Trip ID:</strong></td><td>' . escape($trip['trip_id']) . '</td></tr>';
            echo '<tr><td><strong>User ID Number:</strong></td><td>' . escape($trip['user_id']) . '</td></tr>';
            echo '<tr><td><strong>Start location:</strong></td><td>' . escape($trip['startlocation']) . '</td></tr>';
            echo '<tr><td><strong>End location:</strong></td><td>' . escape($trip['endlocation']) . '</td></tr>';
            echo '<tr><td><strong>Trip days:</strong></td><td>' . escape($trip['tripdays']) . '</td></tr>';
            echo '<tr><td><strong>Vehicle type:</strong></td><td>' . escape($trip['vehicletype']) . '</td></tr>';

            // Add more rows for additional fields
            echo '</table>';

            // Add an "Edit" link to go to the edit page
            echo '<a href="editTrip.php?trip_id=' . $trip_id . '"><strong>Edit</strong></a>';
        } else {
            echo 'Trip not found.';
        }
    } catch (PDOException $error) {
        echo 'Error: ' . $error->getMessage();
    }
} else {
    echo 'No Trip ID provided.';
}
?>

<a href="index.php">Back</a>

