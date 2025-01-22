<?php

/**
 * List all trips with a link to edit
 */

require "../config.php";
require "../common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM trips";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Update trips</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>NIC</th>
            <th>Start Location</th>
            <th>End Location</th>
            <th>How many days you want vehicle</th>
            <th>Vehicle Type</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["NIC"]); ?></td>
            <td><?php echo escape($row["startlocation"]); ?></td>
            <td><?php echo escape($row["endlocation"]); ?></td>
            <td><?php echo escape($row["tripdays"]); ?></td>
            <td><?php echo escape($row["vehicletype"]); ?></td>
            <td><a href="update-single.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>