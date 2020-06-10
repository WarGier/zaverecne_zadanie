<?php
include_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\POP3;
use PHPMailer\PHPMailer\OAuth;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/OAuth.php';
require 'PHPMailer/src/POP3.php';

if(isset($_POST['exportCSV'])){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

    $output = fopen("php://output", "w");
    fputcsv($output, array('id', 'datum_cas', 'prikazy', 'info', 'chyba'));
    $query = "SELECT * FROM skuskaPDF ORDER BY id asc";
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }

    fclose($output);
} else if(isset($_POST['sendToMail'])){
    $mail = new PHPMailer(true);
    $email = $_POST['emailAddress'];

    $sql = "SELECT * from statistika";
    $stmt =  $link->query($sql);

    $emailBodyMessage = "";
    while ($result = $stmt->fetch_assoc()) {
        $emailBodyMessage .= "<tr>" . "<td>" . $result['id'] . "</td>";
        $emailBodyMessage .=  "<td>" . $result['name'] . "</td>";
        $emailBodyMessage .=  "<td>" . $result['count'] . "</td>" . "</tr>";
    }

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPDebug = 2;// Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'webovyteam123@gmail.com';              // SMTP username
        $mail->Password   = 'Mojeheslo123';                         // SMTP password
        $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_SMTPS';         // Enable TLS encryption; `` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($email);               // Name is optional
        $mail->addCC($email);

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Statistics';
        $mail->Body    = '
                <html>
                <head>
                  <title>Some title</title>
                </head>
                <body>
                  <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Model</th>
                            <th>Počet spustení</th>
                        </tr>
                    </thead>
                     <tbody>'.
            $emailBodyMessage.'
                     </tbody>
                  </table>
                </body>
                </html>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



        $mail->send();
        echo 'Message has been sent';
        header('location: statistics.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}else if(isset($_POST['exportPDF'])){


    require('fpdf181/fpdf.php');
    require_once('config.php');
    $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD, DBNAME);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $conn->set_charset("utf8");
    }

    $sql = "SELECT `datum_cas`, `prikazy`, `info`, `chyba` FROM `skuskaPDF` ";
    $result = $conn->query($sql);

    $conn->close();


    class PDF_Table extends FPDF
    {
        var $widths;
        var $aligns;

        function SetWidths($w)
        {
            //Set the array of column widths
            $this->widths = $w;
        }

        function header()
        {
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(276, 5, 'Poziadavky zasielane do CAS', 0, 0, 'C');
            $this->Ln();
            $this->SetFont('Times', '', 12);
            $this->Cell(276, 10, 'Uchovane v PDF', 0, 0, 'C');
            $this->Ln(20);

        }


        function footer()
        {

            $this->SetY(-15);
            $this->SetFont('Arial', '', 8);
            $this->Cell(0, 10, 'Page' . $this->PageNo() . '\{nb}', 0, 0, 'C');
        }


        function Row($data)
        {
            //Calculate the height of the row
            $nb = 0;
            for ($i = 0; $i < count($data); $i++)
                $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
            $h = 7 * $nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for ($i = 0; $i < count($data); $i++) {
                $w = $this->widths[$i];
                $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                //Save the current position
                $x = $this->GetX();
                $y = $this->GetY();
                //Draw the border
                $this->Rect($x, $y, $w, $h);
                //Print the text
                $this->MultiCell($w, 7, $data[$i], 0, $a);
                //Put the position to the right of the cell
                $this->SetXY($x + $w, $y);
            }
            //Go to the next line
            $this->Ln($h);
        }

        function Row1($data)
        {
            //Calculate the height of the row

            $nb = 0;
            for ($i = 0; $i < count($data); $i++)
                $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
            $h = 10 * $nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for ($i = 0; $i < count($data); $i++) {
                $w = $this->widths[$i];
                $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                //Save the current position
                $x = $this->GetX();
                $y = $this->GetY();
                //Draw the border
                $this->Rect($x, $y, $w, $h);
                //Print the text
                $this->MultiCell($w, 10, $data[$i], 0, "C");
                //Put the position to the right of the cell
                $this->SetXY($x + $w, $y);
            }
            //Go to the next line
            $this->Ln($h);
        }


        function CheckPageBreak($h)
        {
            //If the height h would cause an overflow, add a new page immediately
            if ($this->GetY() + $h > $this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }

        function NbLines($w, $txt)
        {
            //Computes the number of lines a MultiCell of width w will take
            $cw =& $this->CurrentFont['cw'];
            if ($w == 0)
                $w = $this->w - $this->rMargin - $this->x;
            $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
            $s = str_replace("\r", '', $txt);
            $nb = strlen($s);
            if ($nb > 0 and $s[$nb - 1] == "\n")
                $nb--;
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $nl = 1;
            while ($i < $nb) {
                $c = $s[$i];
                if ($c == "\n") {
                    $i++;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                    continue;
                }
                if ($c == ' ')
                    $sep = $i;
                $l += $cw[$c];
                if ($l > $wmax) {
                    if ($sep == -1) {
                        if ($i == $j)
                            $i++;
                    } else
                        $i = $sep + 1;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                } else
                    $i++;
            }
            return $nl;
        }
    }


    $pdf = new PDF_Table();
    $pdf->AddPage("L", 'A4');
    $pdf->SetFont("Times", "B", 14);

    $pdf->AliasNbPages();
//Table with 20 rows and 4 columns
    $pdf->SetWidths(array(70, 70, 70, 70));


    $pdf->Row1(array("Datum a cas", "Prikaz", "Info o chybe", "Chyba"));
    $pdf->SetFont('Arial', '', 12);
    while ($row = $result->fetch_assoc()) {


        $pdf->Row(array($row['datum_cas'], $row['prikazy'], $row['info'], $row['chyba']));
    }
    $pdf->Output();


}else if(isset($_POST['exportPDF_API'])){

    require_once "convertToPdf.php";

}
