<?php
include_once 'config.php';

?>

<!doctype html>
<html lang="sk">
    <head>
        <meta charset="utf-8">
        <title><?php echo $lang['title'] ." | ". $lang['home'] ?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/styles.css" />

    </head>
    <body>
        <!-- Navigation  -->
        <nav class="navbar-custom navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 bg-white rounded">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
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

        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="margin-bottom">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1" class="subtext1"><?php echo $lang['entry'] ?></label>
                            <textarea class="form-control" name="command" id="command" rows="3"></textarea>
                        </div>
                        <input type="submit" name="submit" id="submitBtn" class="btn btn-custom" value="<?php echo $lang['submit'] ?>">

                        <script>
                            $(document).ready(function(){
                                $("#submitBtn").click(function () {
                                    $hodnota = $('#command').val();
                                    console.log('dasdadasdad' + $hodnota);
                                    console.log(encodeURIComponent($hodnota));
                                    $.ajax({
                                        type: 'GET',
                                        url: 'http://147.175.121.210:8204/skuska/restapi.php?&action=command&api_key=fb5aa167-1ae0-4ead-a7bd-6fac6326ca42&command=' + encodeURIComponent($hodnota),
                                        success: function(msg){
                                            $('#response').html(msg);
                                        }
                                    });
                                });

                            });
                        </script>
                    </div>

                    <div id="export-options">
                        <span class="subtext1"><?php echo $lang['command export'] ?></span>
                        <form method="post" action="export.php" id="export-options-form">
                            <button type="submit" name="exportCSV" class="btn btn-custom-csv">CSV Export</button>
                            <button type="submit" name="exportPDF"  class="btn btn-custom-pdf">PDF Export</button>
                        </form>
                    </div>
                </div>
                <div class="col">
                    <!-- Response from the TextArea-->
                    <span class="subtext1"><?php echo $lang['response'] ?></span>
                    <p id="response"></p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <table class="table table-stripped">
                    <thead>
                        <h2>Rozdelenie prác</h2>
                        <tr>
                            <th>Ľuboš Trčálek</th>
                            <th>Martin Némethy</th>
                            <th>Peter Zbín</th>
                            <th>Dan Kohout</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <?php echo $lang['aircraft'] ?>
                        </td>
                        <td>
                            <?php echo $lang['pendulum'] ?>
                        </td>
                        <td>
                            <?php echo $lang['ball'] ?>
                        </td>
                        <td>
                            <?php echo $lang['damping'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            CSV export
                        </td>
                        <td>
                            PDF export
                        </td>
                        <td>
                            <?php echo $lang['statistics'] ?>
                        </td>
                        <td>
                            REST API
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $lang['webDesign'] ?>
                        </td>
                        <td>
                            <?php echo $lang['apiDocumentation'] ?>
                        </td>
                        <td>
                            <?php echo $lang['logs'] ?>
                        </td>
                        <td>
                            <?php echo $lang['apiKeyVerification'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $lang['sendStatisticsByMail'] ?>
                        </td>
                        <td>

                        </td>
                        <td>
                            <?php echo $lang['translation'] ?>
                        </td>
                        <td>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- **********************SCRIPTS********************** /-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>