<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    Hello, <?php session_start();
    echo $_SESSION['uid']; ?>!<br>
    <a href="logout.php">Logout</a><br>
</body>

</html>