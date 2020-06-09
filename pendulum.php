<?php
include_once 'config.php';

?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <title><?php echo $lang['title'] ." | ". $lang['pendulum']?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css"/>
    <?php
    if(isset($_POST['submit'])){
    $r = $_POST['r'];
    echo "<script>
        $.ajax({
            type: 'GET',
            url: 'http://147.175.121.210:8204/skuska/restapi.php?action=pendulum&r=" .$r. "',
            success: function (msg) {
                printGraph(msg);
            }
        });
    </script>";
    } ?>
</head>
<body>
<!-- Navigation  -->
<nav class="navbar-custom navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 bg-white rounded">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link " href="index.php"><?php echo $lang['home'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ball.php"><?php echo $lang['ball'] ?></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="pendulum.php"><?php echo $lang['pendulum'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="damping.php"><?php echo $lang['damping'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="aircraft.php"><?php echo $lang['aircraft'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="api.php">API</a>
            </li>
        </ul>
        <form method="get" class="form-inline my-2 my-lg-0 align-right">
            <?php if($_SESSION['lang'] == 'sk'): ?>
                <a class="nav-link" href="?lang=en"><img height="25" class="language-flag" src="img/united-kingdom-flag-small.png"></a>
            <?php elseif($_SESSION['lang'] == 'en'): ?>
                <a class="nav-link" href="?lang=sk"><img height="30" class="language-flag" src="img/slovakia-flag-small.png"></a>
            <?php endif; ?>
        </form>
    </div>
</nav>

<div class="container-subpage w-75 p-3">
    <div class="row">
        <div class="col">
            <h1 class="subpage-heading-1"><?php echo $lang['pendulum'] ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="container-checkboxes">
                <div class="row">
                    <div class="col">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chartCheckBox">
                            <label class="custom-control-label" for="chartCheckBox"><?php echo $lang['chart'] ?></label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="animationCheckBox">
                            <label class="custom-control-label" for="animationCheckBox"><?php echo $lang['animation'] ?></label>
                        </div>
                        <form method="POST" action="">
                            <div class="form-group mt-4">
                                <label for="exampleFormControlTextarea1" class="subtext1"><?php echo $lang['entry'] ?></label>
                                <input class="form-control" type="number" step="0.01" min="0" name="r" id="exampleFormControlTextarea1">
                            </div>
                            <button type="submit" name="submit" class="btn btn-custom"><?php echo $lang['submit'] ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <span id="information" class="subtext1"><?php echo $lang['information'] ?></span>
                        <img id="myAnimation" src="img/united-kingdom-flag-small.png">
                        <canvas id="myChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- **********************SCRIPTS********************** /-->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</body>
</html>

<script>
function printGraph(data) {
    var ctx = document.getElementById('myChart').getContext('2d');
    var positions = [], angles = [], time = [];
    console.log(data);

    $.each(data, function (key,value) {
        positions.push(value['position']);
        angles.push(value['angle']);
        time.push(key);
        setInterval(function () {
            update(myLineChart,time,positions,angles)
        }, 4000);
    });



    function update(chart, label, position, angle) {
        chart.data.labels.pop();
        chart.data.labels.push(label);
        chart.data.datasets[0].data = position;
        chart.data.datasets[1].data = angle;
        chart.update();
    }

    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: time,
            datasets: [
                {
                   label: "Position",
                   backgroundColor : ['rgba(35, 203, 167, 1)'],
                   borderColor : ['rgba(35, 203, 167, 1)'],
                   fill: false
                },{
                    label: "Angle",
                    backgroundColor : ['rgba(30, 139, 195, 1)'],
                    borderColor : ['rgba(30, 139, 195, 1)'],
                    fill: false
                }
            ]
        },
        options: {
            title : {
                display : true,
                position : "top",
                text : "Kyvadlo graf",
                fontSize : 18,
                fontcolor: "#111"
            },
            legend : {
                display : true,
                position: "bottom"
            }
        }
    });

    let animationCheckBox = document.querySelector("input[id=animationCheckBox]");
    $("#myAnimation").hide();
    animationCheckBox.addEventListener( 'change', function() {
        if(this.checked) {

            $("#myAnimation").show();
            check();
        } else {
            $("#myAnimation").hide();
            check();
        }
    });

    let chartCheckBox = document.querySelector("input[id=chartCheckBox]");
    $("#myChart").hide();
    chartCheckBox.addEventListener( 'change', function() {
        if(this.checked) {
            $("#myChart").show();
            check();
        } else {
            $("#myChart").hide();
            check();
        }
    });

    function check(){
        if($("#myChart").is(":hidden") && $("#myAnimation").is(":hidden")){
            $("#information").show();
        } else{
            $("#information").hide();
        }
    }
}
</script>