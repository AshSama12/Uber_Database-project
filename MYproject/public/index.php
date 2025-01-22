<?php include "templates/header.php"; ?>
<h2>Trips</h2>

<?php
/**
 * Retrieve and display the last 3 created entries from the trips table.
 */

try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $query = "SELECT * FROM trips ORDER BY trip_id DESC LIMIT 3";

    // Execute the query
    $result = $connection->query($query);
} catch (PDOException $error) {
    // Display an error message if there's a PDO exception
    echo "Error: Connection failure" . $error->getMessage();
}
?>



<div class="container">
    <?php if (!empty($result)) : ?>
        <h3>Last Trip Registered</h3>
        <table>
            <thead>
                <tr>
                    <th>Trip ID</th>
                    <th>User ID</th>
                    <th>Start Location</th>
                    <th>End Location</th>
                    <th>Number of Trip Days</th>
                    <th>Vehicle Type</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?php echo escape($row["trip_id"]); ?></td>
                        <td><?php echo escape($row["user_id"]); ?></td>
                        <td><?php echo escape($row["startlocation"]); ?></td>
                        <td><?php echo escape($row["endlocation"]); ?></td>
                        <td><?php echo escape($row["tripdays"]); ?></td>
                        <td><?php echo escape($row["vehicletype"]); ?></td>

                        <td><a href="vieworder.php?trip_id=<?php echo $row['trip_id']; ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <blockquote>No results found.</blockquote>
    <?php endif; ?>

    <br>

    <a href="home.php">Back to Home</a>
</div>

<?php require "templates/footer.php"; ?>


