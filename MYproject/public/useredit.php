<?php
require "../config.php"; // Include your database configuration
require "../common.php"; // Include any common functions you might need

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM user WHERE user_id = :user_id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $driver = $statement->fetch();

        if ($driver) {
            // Handle form submission for updating trip details
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_id = $_POST['user_id'];
                 $NIC = $_POST['NIC'];
                $name = $_POST['name'];
                $address = $_POST['address'];
                $telephone = $_POST['telephone'];
                $trip_id = $_POST['trip_id'];
                $destination = $_POST['destination'];

                $updateSql = "UPDATE user
                              SET user_id= :user_id,
                                  NIC = :NIC
                                  name = :name,
                                  address = :address,
                                  telephone = :telephone,
                                  trip_id = :trip_id,
                                  destination = :destination,
                              WHERE user_id = :user_id";

                $updateStatement = $connection->prepare($updateSql);
                $updateStatement->bindValue(':user_id', $user_id);
                $updateStatement->bindValue(':NIC', $NIC);
                $updateStatement->bindValue(':name', $name);
                $updateStatement->bindValue(':address', $address);
                $updateStatement->bindValue(':telephone', $telephone);
                $updateStatement->bindValue(':trip_id', $trip_id);
                 $updateStatement->bindValue(':destination', $destination);


                if ($updateStatement->execute()) {
                    // Display success message and redirect
                    $successMessage = 'user details user_id ' . escape($user_id) . ' successfully updated.';
                    header("Location: edituser.php?user_id=" . $user_id . "&successMessage=" . urlencode($successMessage));
                    exit();
                } else {
                    echo 'Error updating user details.';
                }
            }

            // Display the edit form for trip details
            ?>
            <?php require "templates/header.php"; ?>

            <h2>Edit driver Details</h2>

            <!-- Display success message if successMessage parameter is present -->
            <?php if (isset($_GET['successMessage'])) : ?>
                <p><?php echo urldecode($_GET['successMessage']); ?></p>
            <?php endif; ?>

            <form method="post">
                <label>User ID: <input type="text" name="user_id" value="<?php echo escape($user['user_id']); ?>"></label><br>
                <label>NIC : <input type="text" name="NIC" value="<?php echo escape($user['NIC']); ?>"></label><br>
                <label>Name: <input type="text" name="name" value="<?php echo escape($user['name']); ?>"></label><br>
                <label>Address: <input type="text" name="address" value="<?php echo escape($user['address']); ?>"></label><br>
                <label>Telephone Number: <input type="text" name="telephone" value="<?php echo escape($user['telephone']); ?>"></label><br>
                <label>trip_id: <input type="text" name="trip_id" value="<?php echo escape($user['trip_id']); ?>"></label><br>
                <label>Destination: <input type="text" name="destination" value="<?php echo escape($user['destination']); ?>"></label><br>

                <input type="submit" value="Save">
            </form>

            <a href="uservieworder.php?user_id=<?php echo $user_id; ?>">Back to user Details</a>

            <?php require "templates/footer.php"; ?>
            <?php
        } else {
            echo 'User not found.';
        }
    } catch (PDOException $error) {
        echo 'Error: ' . $error->getMessage();
    }
} else {
    echo 'No user_id provided.';
}
?>

