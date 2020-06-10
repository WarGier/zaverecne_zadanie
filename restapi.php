<?php
include 'config.php';
header("Content-Type:application/json");
date_default_timezone_set('Europe/Berlin');

$result = json_decode(file_get_contents('php://input'), true);

if($_GET['api_key'] == $API_KEY){
    switch ($_GET['action']){
        case "command":
            $command = $_GET['command'];
            $command = "octave --no-gui --silent --eval '$command' 2>&1";
            $outputArray = array();
            $time = time();

            exec($command, $outputArray, $returnVar);
            if ($returnVar == 0) {
                echo json_encode($outputArray[0]);
                sqlQuery($link, $command, $outputArray[0],"nie");
            } else {
                echo json_encode($outputArray[0]);
                sqlQuery($link, $command, $outputArray[0],"ano");
            }
            break;

        case "ball" :
            include 'controllers/BallController.php';
            $ballController = new BallController($_SERVER['REQUEST_METHOD'], $result, $link, $_GET['r'], $_GET['speed'],$_GET['acceleration']);
            $output = $ballController->controller();
            echo json_encode($output);
            break;

        case "aircraft" :
            include 'controllers/AircraftController.php';
            $aircraftController = new AircraftController($_SERVER['REQUEST_METHOD'], $result, $link, $_GET['r'], $_GET['plane_angle'], $_GET['flap_angle']);
            $output = $aircraftController->controller();
            echo json_encode($output);
            break;

        case "damping" :
            include 'controllers/DampingController.php';
            $dampingController = new DampingController($_SERVER['REQUEST_METHOD'], $result, $link, $_GET['r'], $_GET['pos']);
            $output = $dampingController->controller();
            echo json_encode($output);
            break;

        case "pendulum" :
            include 'controllers/PendulumController.php';
            $pendulumController = new PendulumController($_SERVER['REQUEST_METHOD'], $result, $link, $_GET['r'],$_GET['pos'],$_GET['angle']);
            $output = $pendulumController->controller();
            echo json_encode($output);
            break;
    }

    function sqlQuery($link,$command,$info,$bool){
        $dateFormat = date("Y-m-d H:i:s");
        $command = preg_replace( "/\n/", "", $command);

        $stmt = $link->prepare("INSERT INTO skuskaPDF(datum_cas,prikazy,info,chyba) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $dateFormat, $command, $info, $bool);
        $stmt->execute();
        $stmt->close();
    }
}

?>







