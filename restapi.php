<?php
include 'config.php';
header("Content-Type:application/json");
$result = json_decode(file_get_contents('php://input'), true);

switch ($_GET['action']){
    case "command":
        $command = $_GET['command'];
        $output = ltrim(shell_exec('octave --no-gui --quiet --eval "pkg load control;'. $command .'"'));
        echo json_encode($output);
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
        $pendulumController = new PendulumController($_SERVER['REQUEST_METHOD'], $result, $link, $_GET['r']);
        $output = $pendulumController->controller();
        echo json_encode($output);
        break;
    }



?>







