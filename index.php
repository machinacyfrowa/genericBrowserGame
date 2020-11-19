<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <pre>
    <?php 
        require('./class/Village.class.php');
        session_start();
        
        

        if(!isset($_SESSION['v'])) // jeżeli nie ma w sesji naszej wioski
        {
            echo "Tworzę nową wioskę...";
            $v = new Village();
            $_SESSION['v'] = $v;
        } 
        else //mamy już wioskę w sesji - przywróć ją
        {
            $v = $_SESSION['v'];
        }
        

        var_dump($v);
    ?>
    </pre>
</body>
</html>