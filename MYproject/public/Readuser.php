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
            FROM users
            WHERE user_id = :user_id"; // Check the column name 'user_id' in your database

    $user_id = $_POST['user_id'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_STR);
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

          <th>User ID</th>
          <th>NIC Number  </th>
          <th>Name</th>
          <th>Address</th>
          <th>Telephone Number</th>
          <th>Trip ID</th>
          <th>Destination</th>


        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["user_id"]); ?></td>
          <td><?php echo escape($row["NIC"]); ?></td>
          <td><?php echo escape($row["name"]); // Check column name ?></td>
          <td><?php echo escape($row["address"]); // Check column name ?></td>
          <td><?php echo escape($row["telephone"]); // Check column name ?></td>
          <td><?php echo escape($row["trip_id"]); // Check column name ?></td>
          <td><?php echo escape($row["destination"]); // Check column name ?></td>

        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['user_id']); ?>.</blockquote>
    <?php }
} ?>

<h2>Find User based on User ID</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="user_id">User ID</label>
  <input type="text" id="user_id" name="user_id">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="home.php">Back to Home</a>

<?php require "templates/footer.php"; ?>
