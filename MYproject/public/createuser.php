<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_trip = array(
             "user_id" => $_POST['user_id'],
                     "NIC" => $_POST['NIC'],
                     "name" => $_POST['name'],
                     "address" => $_POST['address'],
                     "telephone" => $_POST['telephone'],
                     "trip_id" => $_POST['trip_id'],
                     "destination" => $_POST['destination'],
                       );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_trip)),
            ":" . implode(", :", array_keys($new_trip))
        );


        $statement = $connection->prepare($sql);
        $statement->execute($new_trip);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>User successfully added.</blockquote>
<?php endif; ?>

<h2>Add a user</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
        <label for="name">User ID</label>
        <input type="text" name="user_id" id="user_id">
       <label for="NIC">NIC Number</label>
        <input type="text" name="NIC" id="NIC">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="address">Address</label>
        <input type="text" name="address" id="address">
        <label for="telephone">Telephone Number</label>
        <input type="text" name="telephone" id="telephone">
        <label for="name">Trip ID</label>
        <input type="text" name="trip_id" id="trip_id">
        <label for="name">Destination</label>
        <input type="text" name="destination" id="destination">
        <input type="submit" name="submit" value="Submit">
</form>

<a href="home.php">Back to home</a>

<?php require "templates/footer.php"; ?>
