<?php
include 'config.php';
header("Content-Type:application/json");
$result = json_decode(file_get_contents('php://input'), true);

switch ($_GET['action']){
    case "command":
        $command = $_GET['command'];
        $command = "octave --no-gui --silent --eval '$command' 2>&1";
        $outputArray = array();

        exec($command, $outputArray, $returnVar);
        if ($returnVar == 0) {
            sqlQuery($link,time(),$command,$outputArray[0],"nie");
            echo json_encode($outputArray[0]);
        } else {
            sqlQuery($link,time(),$command,$outputArray[0],"ano");
            echo json_encode($outputArray[0]);
        }
        break;

    case "ball" :
        include 'controllers/BallController.php';
        $ballController = new BallController($_SERVER['REQUEST_METHOD'], $result, $link, $_GET['r']);
        $output = $ballController->controller();
        echo json_encode($output);
        break;

    case "aircraft" :
        include 'controllers/AircraftController.php';
        $aircraftController = new AircraftController($_SERVER['REQUEST_METHOD'], $result, $link, $_GET['r']);
        $output = $aircraftController->controller();
        echo json_encode($output);
        break;

    case "damping" :
        include 'controllers/DampingController.php';
        $dampingController = new DampingController($_SERVER['REQUEST_METHOD'], $result, $link, $_GET['r']);
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

 function sqlQuery($link,$date,$command,$info,$bool){
     if($stmt = $link->prepare("INSERT INTO skuskaPDF(datum_cas,prikazy,info_chyba,chyba) VALUES(?,?,?,?)")){
         $stmt->bind_param("bsss", $date, $command,$info,$bool);
         $stmt->execute();
         $stmt->close();
     }
 }

?>







