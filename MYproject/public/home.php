<?php
/**
 * Retrieve and show the last 3 created
 * entries from the trips table
 */

try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $query = "SELECT * FROM trips ORDER BY NIC DESC LIMIT 3";

    // Execute the query
    $result = $connection->query($query);
} catch (PDOException $error) {
    // Display an error message if there's a PDO exception
    echo "Error: Connection failure" . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<h2>Welcome to Our Database!</h2>

<h2>Trips</h2>
<ul>
    <li><a href="index.php"><strong>Trip Home</strong></a> - go trips</li>
	<li><a href="trip.php"><strong>Create</strong></a> - add a trip</li>
	<li><a href="read.php"><strong>Read</strong></a> - find a trip</li>


</ul>
<h2>Users</h2>
<ul>
    <li><a href="userindex.php"><strong>User Home</strong></a> - go users</li>
	<li><a href="createuser.php"><strong>Create</strong></a> - add a user</li>
	<li><a href="readuser.php"><strong>Read</strong></a> - find a user</li>


</ul>

<h3>Can't use without any permission!!!</h3>

<?php if (!empty($result)) : ?>

<?php endif; ?>

<footer>
        <p>&copy; <?php echo date("Y"); ?> UBER Database. All rights reserved.</p>
    </footer>

<?php require "templates/footer.php"; ?>
