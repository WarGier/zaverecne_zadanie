
<?php

require_once "dompdf/autoload.inc.php";

use Dompdf\Dompdf;


$dompdf= new Dompdf();
$dompdf->loadHtml('<!doctype html>
<html lang="sk">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>

        <h2 class="docHeader">Dokumentácia API</h2>

      
        <div class="container2" style="margin-bottom: 20px">
            <h2 class="getHeader"><div class="get">GET</div>  ?action=ball</h2>
            <p>Vracia hodnoty rýchlosti a zrýchlenia k casu.</p>
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
                    <th>Meno</th>
                    <th>Možnosti</th>
                </tr>

                <tr>
                    <td>speed</td>
                    <td>Rýchlost</td>
                </tr>

                <tr>
                    <td>acceleration</td>
                    <td>Zrýchlenie</td>
                </tr>
                <tr>
                    <td>r</td>
                    <td>Polomer</td>
                </tr>
                </tbody>
            </table>
        </div>



        <div class="container2" style="margin-bottom: 100px">
            <h2 class="getHeader"><div class="get">GET</div>  ?action=pendulum</h2>
            <p>Vracia hodnoty pre pozíciu a uhol k casu.</p>
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
                    <th>Meno</th>
                    <th>Možnosti</th>
                </tr>
                <tr>
                    <td>pos</td>
                    <td>Pozícia</td>

                </tr>
                <tr>
                    <td>angle</td>
                    <td>Uhol</td>

                </tr>
                <tr>
                    <td>r</td>
                    <td>Polomer</td>
                </tr>
                </tbody>
            </table>
        </div>



        <div class="container2" style="margin-bottom: 170px">
            <h2 class="getHeader"><div class="get">GET</div>  ?action=damping</h2>
            <p>Vracia pozíciu auta a pozíciu kolesa k casu.</p>
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
                    <th>Meno</th>
                    <th>Možnosti</th>
                </tr>
                <tr>
                    <td>pos</td>
                    <td>Pozícia</td>
                </tr>
                <tr>
                    <td>r</td>
                    <td>Polomer</td>
                </tr>

                </tbody>
            </table>
        </div>



        <div class="container2">
            <h2 class="getHeader"><div class="get">GET</div>  ?action=aircraft</h2>
            <p> Vracia hodnoty nákolonu lietadla a jeho klapiek k casu. </p>
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
                    <th>Meno</th>
                    <th>Možnosti</th>
                </tr>
                <tr>
                    <td>plane_angle</td>
                    <td>náklon lietadla</td>
                </tr>
                <tr>
                    <td>flap_angle</td>
                    <td>náklon klapky</td>
                </tr>
                <tr>
                    <td>r</td>
                    <td>Polomer</td>
                </tr>

                </tbody>
            </table>



        </div>




        <!-- **********************SCRIPTS********************** /-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("codexworld", array("Attachment" => 0));

?>
