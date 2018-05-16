<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Die 3 Meta-Tags oben *müssen* zuerst im head stehen; jeglicher sonstiger head-Inhalt muss *nach* diesen Tags kommen -->
    <link rel="icon" href="img/favicon.ico">
    <title>Eidgenössische Abstimmungen auf Gemeindeebene</title>
    <!-- Bootstrap via MaxCDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Eigene Styles -->
    <!-- <link rel="stylesheet" href="css/bootstrap-custom.css">  -->
    <!-- ACHTUNG: IE < 9 unterstützen wir nicht mehr! -->
</head>
<body id="bg1">
<div class="container">

    <?php
    header('Content-Type: text/html; charset=ISO-8859-1');

    error_reporting(0);

    session_start();

    //From W3Schools: Select Data With MySQL
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "test";
    $dates = array();
    $names = array();
    $i = 0;
    $gemeinde = $_GET['gemeinde'];
    $sucheName = $_GET['namesuche'];
    $sucheJahr = $_GET['jahrsuche'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (($sucheName == null || $sucheName == "") && ($sucheJahr == null || $sucheJahr == "")) {
        $sql = "SELECT distinct AbBez, AbDatum FROM TAbstimmungen";
    } else if ($sucheJahr == null || $sucheJahr == "") {
        $sql = "SELECT distinct AbBez, AbDatum FROM TAbstimmungen WHERE AbBez like" . "'%" . $sucheName . "%'";
    } else if ($sucheName == null || $sucheName == "") {
        $sql = "SELECT distinct AbBez, AbDatum FROM TAbstimmungen WHERE year(AbDatum) like" . "'%" . $sucheJahr . "%'";
    } else {
        $sql = "SELECT distinct AbBez, AbDatum FROM TAbstimmungen WHERE year(AbDatum) like" . "'%" . $sucheJahr . "%' and AbBez like" . "'%" . $sucheName . "%'";
    }


    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $dates[$i] = $row["AbDatum"];
            $names[$i] = $row['AbBez'];
            $i++;
        }
        for ($i = 0; $i < 10; $i++) {
            echo $dates[$i] . " " . $names[$i] . "<br>";
        }
    } else {
        echo "0 results";
    }
    mysqli_close($conn);
    ?>

    <h3 class="form-signin-heading"><b><br>Filter</b></h3>

    <form class="form-signin" name="formular" method="get" action="index.php">
        <h2 class="form-signin-heading"><b>Eidgen&ouml;ssische Abstimmungen auf Gemeindeebene</b></h2>
        <h3 class="form-signin-heading"><b><br>Eingaben</b></h3>
        <p class="form-signin-heading">Gemeinde</p>
        <select class="form-control form-custom" name="gemeinde">
            <optgroup label="Arbon">
                <option>Amriswil</option>
                <option>Arbon</option>
                <option>Dozwil</option>
                <option>Egnach</option>
                <option>Hefenhofen</option>
                <option>Horn</option>
                <option>Kesswil</option>
                <option>Roggwil</option>
                <option>Romanshorn</option>
                <option>Salmsach</option>
                <option>Sommeri</option>
                <option>Uttwil</option>
            </optgroup>
            <optgroup label="Frauenfeld">
                <option>Basadingen-Schlattingen</option>
                <option>Berlingen</option>
                <option>Diessenhofen</option>
                <option>Eschenz</option>
                <option>Felben-Wellhausen</option>
                <option>Frauenfeld</option>
                <option>Gachnang</option>
                <option>Herdern</option>
                <option>Homburg</option>
                <option>Hüttlingen</option>
                <option>Hüttwilen</option>
                <option>Mammern</option>
                <option>Matzingen</option>
                <option>Müllheim</option>
                <option>Neunforn</option>
                <option>Pfyn</option>
                <option>Schlatt</option>
                <option>Steckborn</option>
                <option>Stettfurt</option>
                <option>Thundorf</option>
                <option>Uesslingen-Buch</option>
                <option>Wagenhausen</option>
                <option>Warth-Weiningen</option>
            </optgroup>
            <optgroup label="Kreuzlingen">
                <option>Altnau</option>
                <option>Bottighofen</option>
                <option>Ermatingen</option>
                <option>Gottlieben</option>
                <option>Güttingen</option>
                <option>Kemmental</option>
                <option>Kreuzlingen</option>
                <option>Langrickenbach</option>
                <option>Lengwil</option>
                <option>Münsterlingen</option>
                <option>Raperswilen</option>
                <option>Salenstein</option>
                <option>Tägerwilen</option>
                <option>Wäldi</option>
            </optgroup>
            <optgroup label="Münchwilen">
                <option>Aadorf</option>
                <option>Bettwiesen</option>
                <option>Bichelsee-Balterswil</option>
                <option>Braunau</option>
                <option>Eschlikon</option>
                <option>Fischingen</option>
                <option>Lommis</option>
                <option>Münchwilen</option>
                <option>Rickenbach</option>
                <option>Sirnach</option>
                <option>Tobel-Tägerschen</option>
                <option>Wängi</option>
                <option>Wilen</option>
            </optgroup>
            <optgroup label="Weinfelden">
                <option>Affeltrangen</option>
                <option>Amlikon-Bissegg</option>
                <option>Berg</option>
                <option>Birwinken</option>
                <option>Bischofszell</option>
                <option>Bürglen</option>
                <option>Bussnang</option>
                <option>Erlen</option>
                <option>Hauptwil-Gottshaus</option>
                <option>Hohentannen</option>
                <option>Kradolf-Schönenberg</option>
                <option>Märstetten</option>
                <option>Schönholzerswilen</option>
                <option>Sulgen</option>
                <option>Weinfelden</option>
                <option>Wigoltingen</option>
                <option>Wuppenau</option>
                <option>Zihlschlacht-Sitterdorf</option>
            </optgroup>
        </select>
        <div class="form-inline">
            <p class="form-signin-heading"><br>Nach Name/Jahr suchen:</p>
        </div>
        <div class="form-inline">
            <input type="text" id="input" class="form-control form-custom" placeholder="Name" name="namesuche"
                   autofocus>


            <input type="text" id="input" class="form-control form-custom" placeholder="Jahr" name="jahrsuche"
                   autofocus>

            <button class="btn btn-primary" id="button" type="submit" name="submit"
                    value="Senden">Berechnen
            </button>
        </div>


    </form>

</div>
<!-- /container -->        <!-- Eigene JavaScripts -->
<script src="js/myscripts.js"></script>
<!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
