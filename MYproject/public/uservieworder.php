<?php
require "../config.php"; // Include your database configuration
require "../common.php"; // Include any common functions you might need

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM users WHERE user_id = :user_id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $trip = $statement->fetch();

        if ($trip) { // Corrected variable name to $trip
            echo '<h2>View User Details</h2>';
            echo '<table>';
            echo '<tr><td><strong>User ID:</strong></td><td>' . escape($trip['user_id']) . '</td></tr>';
            echo '<tr><td><strong>Trip ID:</strong></td><td>' . escape($trip['trip_id']) . '</td></tr>';
            echo '<tr><td><strong>NIC Number:</strong></td><td>' . escape($trip['NIC']) . '</td></tr>';
            echo '<tr><td><strong>Name:</strong></td><td>' . escape($trip['name']) . '</td></tr>';
            echo '<tr><td><strong>Address:</strong></td><td>' . escape($trip['address']) . '</td></tr>';
            echo '<tr><td><strong>Telephone Number:</strong></td><td>' . escape($trip['telephone']) . '</td></tr>';
            echo '<tr><td><strong>Destination:</strong></td><td>' . escape($trip['destination']) . '</td></tr>';

            // Add more rows for additional fields
            echo '</table>';

            // Add an "Edit" link to go to the edit page
            echo '<a href="edituser.php?user_id=' . $user_id . '"><strong>Edit</strong></a>';
        } else {
            echo 'User not found.';
        }
    } catch (PDOException $error) {
        echo 'Error: ' . $error->getMessage();
    }
} else {
    echo 'No User ID provided.';
}
?>

<a href="userindex.php">Back</a>

