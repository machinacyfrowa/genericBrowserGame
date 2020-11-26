<?php 
        require('./class/Village.class.php');
        require('./class/Log.class.php');
        session_start();
        if(!isset($_SESSION['v'])) // jeżeli nie ma w sesji naszej wioski
        {
            $l = new Log();
            $_SESSION['l'] = $l;
            echo "Tworzę nową wioskę...";
            $v = new Village();
            $_SESSION['v'] = $v;
            
            //reset czasu od ostatniego odświerzenia strony
            $deltaTime = 0;
        } 
        else //mamy już wioskę w sesji - przywróć ją
        {
            $l = $_SESSION['l'];
            $v = $_SESSION['v'];

            
            //ilosc sekund od ostatniego odświerzenia strony
            $deltaTime = time() - $_SESSION['time'];
        }
        $v->gain($deltaTime);
        
        if(isset($_REQUEST['action'])) 
        {
            switch($_REQUEST['action'])
            {
                case 'upgradeBuilding':
                    if($v->upgradeBuilding($_REQUEST['building']))
                    {
                        echo "Ulepszono budynek: ".$_REQUEST['building'];
                    }
                    else
                    {
                        echo "Nie udało się ulepszyć budynku: ".$_REQUEST['building'];
                    }
                    
                break;
                default:
                    echo 'Nieprawidłowa zmienna "action"';
            }
        }

        $_SESSION['time'] = time();
        
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <header class="row border-bottom">
            <div class="col-12 col-md-3">
                Informacje o graczu
            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-3">
                        Drewno: <span id="woodStorage"><?php echo $v->showStorage("wood"); ?></span>
                    </div>
                    <div class="col-12 col-md-3">
                        Żelazo: <span id="ironStorage"><?php echo $v->showStorage("iron"); ?></span>
                    </div>
                    <div class="col-12 col-md-3">
                        Zasób 3
                    </div>
                    <div class="col-12 col-md-3">
                        Zasób 4
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                Guzik wyloguj
            </div>
        </header>
        <main class="row border-bottom">
            <div class="col-12 col-md-3 border-right">
                Lista budynków<br>
                <div>
                    Drwal, poziom <?php echo $v->buildingLVL("woodcutter"); ?> <br>
                    Zysk/h: <?php echo $v->showHourGain("wood"); ?><br>
                    <!--<a href="index.php?action=upgradeBuilding&building=woodcutter">-->
                        <button onclick="upgradeBuilding(this)">Rozbuduj drwala</button>
                        
                    <!--</a>-->
                    <br>
                    Drewno: <span id="woodCost"><?php echo $v->showUpgradeCost("woodcutter", "wood"); ?></span>,
                    Żelazo: <span id="ironCost"><?php echo $v->showUpgradeCost("woodcutter", "iron"); ?></span>,
                </div>
                
                Kopalnia żelaza, poziom <?php echo $v->buildingLVL("ironMine"); ?> <br>
                Zysk/h: <?php echo $v->showHourGain("iron"); ?><br>
                <a href="index.php?action=upgradeBuilding&building=ironMine">
                    <button>Rozbuduj kopalnie żelaza</button>
                </a>
            </div>
            <div class="col-12 col-md-6">
                Widok wioski
            </div>
            <div class="col-12 col-md-3 border-left">
                Lista wojska
            </div>
        </main>
        <footer class="row">
            <div class="col-12">
            <pre>
            <?php
                
                $log = $l->getLog();
                var_dump($log);
                for($i = count($log) - 1 ; $i >= 0 ; $i--)
                {
                    $entry = $log[$i];
                    $timestamp = $entry['timestamp'];
                    $message = $entry['message'];
                    echo "<p>$timestamp $message</p>";
                }
                /*
                if($log[0]['type'] == 'alert')
                echo '  <span id="alert" style="display: none;">'.$log[0]['message'].'</span> ';
                */
            ?>
            </pre>
            </div>
        </footer>
    </div>

  
    <script>
        /*
        function showAlert()
        {
            let alertMsg = document.getElementById('alert').innerHTML;
            if(alertMsg != "") 
            {
                window.alert(alertMsg)
            }
        }
        */
        function upgradeBuilding(guzik)
        {
            let div = guzik.parentNode;
            let woodCost = parseInt(div.querySelector("#woodCost").innerHTML);
            let ironCost = parseInt(div.querySelector("#ironCost").innerHTML);
            let woodStorage = parseInt(document.getElementById('woodStorage').innerHTML);
            let ironStorage = parseInt(document.getElementById('ironStorage').innerHTML);
            if(woodCost > woodStorage || ironCost > ironStorage)
                alert("Masz za mało surowców");
            else
                window.location = "index.php?action=upgradeBuilding&building=woodcutter";
        }
    </script>           
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>