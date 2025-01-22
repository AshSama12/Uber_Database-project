<?php include "templates/header.php"; ?>
<h2>Users</h2>

<?php
/**
 * Retrieve and display the last 3 created entries from the trips table.
 */

try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $query = "SELECT * FROM users ORDER BY user_id DESC LIMIT 3";

    // Execute the query
    $result = $connection->query($query);
} catch (PDOException $error) {
    // Display an error message if there's a PDO exception
    echo "Error: Connection failure" . $error->getMessage();
}
?>



<div class="container">
    <?php if (!empty($result)) : ?>
        <h3>Last User Registered</h3>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>NIC</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Telephone Number</th>
                    <th>Trip ID</th>
                    <th>Destination</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?php echo escape($row["user_id"]); ?></td>
                        <td><?php echo escape($row["NIC"]); ?></td>
                        <td><?php echo escape($row["name"]); ?></td>
                        <td><?php echo escape($row["address"]); ?></td>
                        <td><?php echo escape($row["telephone"]); ?></td>
                        <td><?php echo escape($row["trip_id"]); ?></td>
                        <td><?php echo escape($row["destination"]); ?></td>
                        <td><a href="uservieworder.php?user_id=<?php echo $row['user_id']; ?>">View</a></td>
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


