<?php
include_once 'config.php';

?>

<!doctype html>
<html lang="sk">
    <head>
        <meta charset="utf-8">
        <title><?php echo $lang['title'] ." | API" ?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/styles.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="aircraft.php"><?php echo $lang['aircraft'] ?></a>
                    </li>
                    <li class="nav-item active">
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

        <h2 class="docHeader"><?php echo $lang['apiDocumentation'] ?></h2>

        <form method="post" action="export.php" id="export-options-form">
            <div class="endpoints">
                <h2>Endpoints</h2>
                <button type="submit" name="exportPDF_API" class="btn btn-custom-csv"><?php echo $lang['exportPDF'] ?></button>
            </div>
        </form>

        <div class="container2">
            <h2 class="getHeader"><div class="get">GET</div>  ?action=ball</h2>
            <p><?php echo $lang["ballDescription"]?></p>
            <strong>Example Resource URL</strong>
            <p>http://147.175.121.210:8204/skuska/restapi.php?action=ball&speed=0&acceleration=0&r=0.2&api_key=fb5aa167-1ae0-4ead-a7bd-6fac6326ca42</p>

            <strong>Example Response</strong>
            <pre>

    {
            "speed":"0.19794",
            "acceleration":"-0.00002
    }
</pre>

            <table class="table table-striped">
                <tbody>
                <tr>
                    <th><?php echo $lang['name']?></th>
                    <th><?php echo $lang['options']?></th>
                </tr>

                <tr>
                    <td>speed</td>
                    <td>[<?php echo $lang['speed']?>]</td>
                </tr>

                <tr>
                    <td>acceleration</td>
                    <td>[<?php echo $lang['acceleration']?>]</td>
                </tr>
                <tr>
                    <td>r</td>
                    <td>[<?php echo $lang['radius']?>]</td>
                </tr>
                </tbody>
            </table>
        </div>



        <div class="container2">
            <h2 class="getHeader"><div class="get">GET</div>  ?action=pendulum</h2>
            <p><?php echo $lang['pendulumDescription'] ?></p>
            <strong>Example Resource URL</strong>
            <p>http://147.175.121.210:8204/skuska/restapi.php?action=pendulum&pos=0&angle=0&r=0.2&api_key=fb5aa167-1ae0-4ead-a7bd-6fac6326ca42</p>

            <strong>Example Response</strong>
            <pre>

    {
            "position":"0.17053",
            "angle":"0.15998"
    }
</pre>

            <table class="table table-striped">
                <tbody>
                <tr>
                    <th><?php echo $lang['name'] ?></th>
                    <th><?php echo $lang['options'] ?></th>
                </tr>
                <tr>
                    <td>pos</td>
                    <td>[<?php echo $lang['position']?>] </td>

                </tr>
                <tr>
                    <td>angle</td>
                    <td>[<?php echo $lang['angle']?>]</td>

                </tr>
                <tr>
                    <td>r</td>
                    <td>[<?php echo $lang['radius']?>]</td>
                </tr>
                </tbody>
            </table>
        </div>



        <div class="container2">
            <h2 class="getHeader"><div class="get">GET</div>  ?action=damping</h2>
            <p><?php echo $lang['dampingDescription']?></p>
            <strong>Example Resource URL</strong>
            <p>http://147.175.121.210:8204/skuska/restapi.php?action=damping&pos=0&r=0.2&api_key=fb5aa167-1ae0-4ead-a7bd-6fac6326ca42</p>

            <strong>Example Response</strong>
            <pre>

    {
                "carPos":"0.20001",
                "wheelPos":"0.00001"
    }
</pre>

            <table class="table table-striped">
                <tbody>
                <tr>
                    <th> <?php echo $lang['name']?></th>
                    <th> <?php echo $lang['options']?></th>
                </tr>
                <tr>
                    <td>pos</td>
                    <td>[<?php echo $lang['position']?>]</td>
                </tr>
                <tr>
                    <td>r</td>
                    <td>[<?php echo $lang['radius']?>]</td>
                </tr>

                </tbody>
            </table>
        </div>



        <div class="container2">
            <h2 class="getHeader"><div class="get">GET</div>  ?action=aircraft</h2>
            <p> <?php echo $lang['planeDescription']?> </p>
            <strong>Example Resource URL</strong>
            <p>http://147.175.121.210:8204/skuska/restapi.php?action=aircraft&plane_angle=0&flap_angle=0&r=0.2&api_key=fb5aa167-1ae0-4ead-a7bd-6fac6326ca42</p>

            <strong>Example Response</strong>
            <pre>

            {
                    "planeAngle":"0.00154",
                    "flapAngle":"0.25648"

             }
</pre>

            <table class="table table-striped">
                <tbody>
                <tr>
                    <th> <?php echo $lang['name']?></th>
                    <th> <?php echo $lang['options']?></th>
                </tr>
                <tr>
                    <td>plane_angle</td>
                    <td>[<?php echo $lang['planeAngle']?>]</td>
                </tr>
                <tr>
                    <td>flap_angle</td>
                    <td>[<?php echo $lang['flapAngle']?>]</td>
                </tr>
                <tr>
                    <td>r</td>
                    <td>[<?php echo $lang['radius']?>]</td>
                </tr>

                </tbody>
            </table>



        </div>




        <!-- **********************SCRIPTS********************** /-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>