<?php

/**
 * Function to query information based on
 * a parameter: in this case, location.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
            FROM trips
            WHERE trip_id = :trip_id"; // Check the column name 'trip_id' in your database

    $trip_id = $_POST['trip_id'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':trip_id', $trip_id, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
        <tr>

          <th>Trip ID</th>
          <th>User ID Number</th>
          <th>Start Location</th>
          <th>End Location</th>
          <th>How many days you want vehicle</th>
          <th>Vehicle Type</th>


        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["trip_id"]); ?></td>
          <td><?php echo escape($row["user_id"]); ?></td>
          <td><?php echo escape($row["startlocation"]); // Check column name ?></td>
          <td><?php echo escape($row["endlocation"]); // Check column name ?></td>
          <td><?php echo escape($row["tripdays"]); // Check column name ?></td>
          <td><?php echo escape($row["vehicletype"]); // Check column name ?></td>

        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['trip_id']); ?>.</blockquote>
    <?php }
} ?>

<h2>Find Trip based on Trip ID</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="trip_id">Trip ID</label>
  <input type="text" id="trip_id" name="trip_id">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="home.php">Back to Home</a>

<?php require "templates/footer.php"; ?>
