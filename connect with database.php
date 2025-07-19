<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $db_server = "localhost";
        $db_user="root";
        $db_pass="";
        $db_name="mydatabase";

        $conn="";

        try{
            $conn=mysqli_connect($db_server, $db_user, $db_pass, $db_name);
        }catch (mysqli_sql_exception) {
            echo "404 not found";
        } 

        if($conn){
            echo "your database is connected";
        }
    ?>
</body>
</html>