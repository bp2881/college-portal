<?php
$host = 'localhost';
$db = 'college-data';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if (isset($_POST['name']) && isset($_POST['pass'])) {
    $uname = $_POST['name'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO users (uid, upass) VALUES(?, ?);');
    $stmt->bind_param('ss', $uname, $password);
    $stmt->execute();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="temp.php" method="post">
        Name: <input type="text" name="name"> <br>
        Password: <input type="password" name="pass"> <br><br>
        <input type="submit" value="Register">
    </form>
</body>

</html>