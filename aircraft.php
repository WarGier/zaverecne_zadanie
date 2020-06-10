<?php
include_once 'config.php';

?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <title><?php echo $lang['title'] ." | ". $lang['aircraft']?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.0.0-beta.12/fabric.js"> </script>
    <link rel="stylesheet" href="css/styles.css"/>

    <script>
        let planeAngle = 0, flapAngle = 0;

        function printGraph(data) {
            $(document).ready(function() {
                let trace1 = {
                    x: [],
                    y: [],
                    type: 'scatter',
                    name: '<?php echo $lang['planeAngle']; ?>',
                    mode: 'lines'
                };

                let trace2 = {
                    x: [],
                    y: [],
                    type: 'scatter',
                    name: '<?php echo $lang['flapAngle']; ?>',
                    mode: 'lines'
                };
                let newData = [trace1, trace2];
                let config = {responsive: true};
                let layout = {
                    title: '<?php echo $lang['aircraft']; ?>',
                    xaxis: {
                        title: '<?php echo $lang['time']; ?>',
                    },
                    yaxis: {
                        title: 'r',
                        //range: [-1,1],
                    }
                };

                Plotly.newPlot('myChart', newData, layout, config);
                let count = 0;
                let it = 0;
                let interval = setInterval(function () {
                    Plotly.extendTraces('myChart', {
                        x: [[count], [count]],
                        y: [[data[count]['planeAngle']], [data[count]['flapAngle']]]
                    }, [0, 1]);


                    count++;
                    if(count === data.length){
                        clearInterval(interval);
                        $("#button").attr("disabled", false);
                    }
                }, 50);

            });

            planeAngle = data[data.length-1]['planeAngle'];
            flapAngle = data[data.length-1]['flapAngle'];
        }

    </script>
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
            <li class="nav-item">
                <a class="nav-link" href="pendulum.php"><?php echo $lang['pendulum'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="damping.php"><?php echo $lang['damping'] ?></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="aircraft.php"><?php echo $lang['aircraft'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="api.php">API</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="statistics.php"><?php echo $lang['statistics'] ?></a>
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
            <h1 class="subpage-heading-1"><?php echo $lang['aircraft'] ?></h1>
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

                        <div class="form-group mt-4">
                            <label for="exampleFormControlTextarea1" class="subtext1"><?php echo $lang['entry'] ?></label>
                            <input class="form-control" type="number" step="0.01" min="0" name="r" id="inputGraphData">
                        </div>
                        <button  id="button" type="submit" class="btn btn-custom"><?php echo $lang['submit'] ?></button>
                        <script>
                            $(document).ready(function(){
                                $("#button").click(function(){
                                    var r = $("#inputGraphData").val();
                                    console.log(inputGraphData);
                                    $.ajax({
                                        type: 'GET',
                                        url: 'http://147.175.121.210:8204/skuska/restapi.php?action=aircraft&plane_angle=' + planeAngle + '&flap_angle=' + flapAngle + '&r=' + r + '&api_key=fb5aa167-1ae0-4ead-a7bd-6fac6326ca42',
                                        success: function (msg) {
                                            $("#button").attr("disabled", true);
                                            printGraph(msg);
                                        }
                                    });

                                    $.ajax({
                                        type: 'PUT',
                                        url: 'http://147.175.121.210:8204/skuska/restapi.php?action=aircraft&plane_angle=' + planeAngle + '&flap_angle=' + flapAngle + '&r=' + r + '&api_key=fb5aa167-1ae0-4ead-a7bd-6fac6326ca42',
                                        success: function (msg) {
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-sm">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <span id="information" class="subtext1"><?php echo $lang['information'] ?></span>

                        <div id = "planeCanvas" width="800px" height="600px"></div>

                        <div id="myChart" width="400" height="200"></div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>

<script>
     let animationCheckBox = document.querySelector("input[id=animationCheckBox]");
    $("#planeCanvas").hide();
    animationCheckBox.addEventListener( 'change', function() {
        if(this.checked) {
            // Checkbox is checked..
            console.log("CHECKED")
            $("#planeCanvas").show();
            check();
        } else {
            // Checkbox is not checked..
            console.log("NOT CHECKED")
            $("#planeCanvas").hide();
            check();
        }
    });

    let chartCheckBox = document.querySelector("input[id=chartCheckBox]");
    $("#myChart").hide();
    chartCheckBox.addEventListener( 'change', function() {
        if(this.checked) {
            // Checkbox is checked..
            console.log("CHECKED")
            $("#myChart").show();
            check();
        } else {
            // Checkbox is not checked..
            console.log("NOT CHECKED")
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
</script>