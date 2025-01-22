<?php

/**
 * Use an HTML form to edit an entry in the
 * trips table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
      "NIC"        => $_POST['NIC'],
      "startlocation" => $_POST['startlocation'],
      "endlocation"  => $_POST['endlocation'],
      "tripdays"     => $_POST['tripdays'],
      "age"       => $_POST['age'],
      "location"  => $_POST['location'],
      "date"      => $_POST['date']
    ];

    $sql = "UPDATE trips
            SET NIC = :NIC,
              startlocation = :startlocation,
              endlocation = :endlocation,
              tripdays = :tripdays,
              vehicletype = :vehicletype,
              date = :date
            WHERE NIC = :NIC";
  
  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['NIC'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $NIC = $_GET['NIC'];

    $sql = "SELECT * FROM trips WHERE NIC = :NIC";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':NIC', $NIC);
    $statement->execute();
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['startlocation']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" NIC="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'NIC' ? 'readonly' : null); ?>>
    <?php endforeach; ?> 
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
