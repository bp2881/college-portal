<?php
$pass = password_hash("deveshrayudu");
echo $pass;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php echo $pass; ?>
    <h1>Welcome to Vignan College</h1>
</body>

</html>