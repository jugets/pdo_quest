
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="index.php" method="post">
    <label for="firstname">Firstname :</label>
    <input type="text" name="firstname" id="firstname" required>
    <label for="lastname">Lastname :</label>
    <input type="text" name="lastname" id="lastname" required>
    <input type="submit" value="Enter">
  </form>
<?php

require_once '_connec.php';
$pdo = new \PDO(DSN, USER, PASS);

//$query = "INSERT INTO friend (firstname, lastname) VALUES ('Chandler', 'Bing')";
//$statement = $pdo->exec($query);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_OBJ);

foreach($friends as $friend){
  echo '<li>'.$friend-> firstname . ' ' . $friend-> lastname.'</li>';  
}

if(isset($_POST['firstname']) && isset($_POST['lastname'])){
  $firstname = trim($_POST['firstname']);
  $lastname = trim($_POST['lastname']);

  if(empty($firstname)){
    echo 'Firstname is mandatory';
  }
  if(empty($lastname)){
    echo 'Lastname is mandatory';
  }


  $query = 'INSERT INTO friend (firstname,lastname) VALUES (:firstname,:lastname)';
  $statement = $pdo->prepare($query);

  $statement-> bindValue (':firstname', $firstname, \PDO::PARAM_STR);
  $statement-> bindValue (':lastname', $lastname, \PDO::PARAM_STR);

  $statement->execute();

  $friends = $statement->fetchAll();

  foreach($friends as $friend){
    echo '<li>'.$friend-> firstname . ' ' . $friend-> lastname.'</li>';  
  }

  header('Location: index.php');
  die();
}

?>

</body>

</html>


