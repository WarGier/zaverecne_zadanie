<?php
include_once 'config.php';


$sql = "SELECT * from statistika";
$stmt =  $link->query($sql);
while ($result = $stmt->fet){

}
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <title><?php echo $lang['title'] ." | " . $lang['statistics']?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css"
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
            <li class="nav-item">
                <a class="nav-link" href="api.php">API</a>
            </li>
            <li class="nav-item active">
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

<div class="container">
    <div class="row">
        <div class="col">
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th>Model</th>
                        <th>Počet spustení</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- **********************SCRIPTS********************** /-->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>