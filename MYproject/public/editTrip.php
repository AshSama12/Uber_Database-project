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

        if ($trip) {
            // Handle form submission for updating trip details
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $trip_id = $_POST['trip_id'];
                $user_id = $_POST['user_id'];
                $startlocation = $_POST['startlocation'];
                $endlocation = $_POST['endlocation'];
                $tripdays = $_POST['tripdays'];
                $vehicletype = $_POST['vehicletype'];
                $Date = $_POST['Date'];

                $updateSql = "UPDATE trips
                              SET trip_id = :trip_id,
                                  user_id = :user_id'
                                  startlocation = :startlocation,
                                  endlocation = :endlocation,
                                  tripdays = :tripdays,
                                  vehicletype = :vehicletype,
                                  Date = :Date
                              WHERE trip_id = :trip_id";

                $updateStatement = $connection->prepare($updateSql);
                $updateStatement->bindValue(':trip_id', $trip_id);
                $updateStatement->bindValue(':user_id', $user_id);
                $updateStatement->bindValue(':startlocation', $startlocation);
                $updateStatement->bindValue(':endlocation', $endlocation);
                $updateStatement->bindValue(':tripdays', $tripdays);
                $updateStatement->bindValue(':vehicletype', $vehicletype);
                $updateStatement->bindValue(':Date', $Date);

                if ($updateStatement->execute()) {
                    // Display success message and redirect
                    $successMessage = 'Trip details for trip ID ' . escape($trip_id) . ' successfully updated.';
                    header("Location: editTrip.php?trip_id=" . $trip_id . "&successMessage=" . urlencode($successMessage));
                    exit();
                } else {
                    echo 'Error updating trip details.';
                }
            }

            // Display the edit form for trip details
            ?>
            <?php require "templates/header.php"; ?>

            <h2>Edit Trip Details</h2>

            <!-- Display success message if successMessage parameter is present -->
            <?php if (isset($_GET['successMessage'])) : ?>
                <p><?php echo urldecode($_GET['successMessage']); ?></p>
            <?php endif; ?>

            <form method="post">
                <label>Trip Number: <input type="text" name="trip_id" value="<?php echo escape($trip['trip_id']); ?>"></label><br>
                <label>User ID Number: <input type="text" name="user_id" value="<?php echo escape($trip['user_id']); ?>"></label><br>
                <label>Start Location: <input type="text" name="startlocation" value="<?php echo escape($trip['startlocation']); ?>"></label><br>
                <label>End Location: <input type="text" name="endlocation" value="<?php echo escape($trip['endlocation']); ?>"></label><br>
                <label>Number of Trip Days: <input type="text" name="tripdays" value="<?php echo escape($trip['tripdays']); ?>"></label><br>
                <label>VehicleType: <input type="text" name="vehicletype" value="<?php echo escape($trip['vehicletype']); ?>"></label><br>
                <label for="Date">Date:<input type="date" name="Date" id="Date" value="<?php echo date('Y-m-d', strtotime(escape($trip['Date']))); ?>"></label><br>

                <input type="submit" value="Save">
            </form>

            <a href="vieworder.php?trip_id=<?php echo $trip_id; ?>">Back to Trip Details</a>

            <?php require "templates/footer.php"; ?>
            <?php
        } else {
            echo 'Trip not found.';
        }
    } catch (PDOException $error) {
        echo 'Error: ' . $error->getMessage();
    }
} else {
    echo 'No trip ID provided.';
}
?>

