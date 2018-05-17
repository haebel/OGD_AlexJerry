<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Die 3 Meta-Tags oben *müssen* zuerst im head stehen; jeglicher sonstiger head-Inhalt muss *nach* diesen Tags kommen -->
    <link rel="icon" href="img/favicon.ico">
    <title>Eidgen&ouml;ssische Abstimmungen auf Gemeindeebene</title>
    <!-- Bootstrap via MaxCDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Eigene Styles -->
    <!-- <link rel="stylesheet" href="css/bootstrap-custom.css">  -->
    <!-- ACHTUNG: IE < 9 unterstützen wir nicht mehr! -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        .row {
            display: flex;
        }

        .column {
            flex: 50%;
            padding: 10px;


    }
</style>


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
    $test = array();
    $i = 0;
    $gemeinde = $_GET['gemeinde'];
    $sucheName = $_GET['namesuche'];
    $sucheJahr = $_GET['jahrsuche'];
    if (!empty($_GET['typ'])) {
        $typ = $_GET['typ'];
    } else {
        $typ = "Ja/Nein";
    }

    if (!empty($_GET['gemeinde'])) {
        $dropDownVal = $_GET['gemeinde'];
    } else {
        $dropDownVal = 1;
    }
    $ja = 0;
    $nein = 0;

    if ($_GET['dataSel'] == null || $_GET['dataSel'] == '') {

    } else {
        $name = $_GET['dataSel'];
    }


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $gemeindesql = "SELECT distinct AbJaStimmen, AbNeinStimmen, AbStimmbeteiligung, AbStimmberechtigte FROM TAbstimmungen WHERE AbGemeindeName = '" . $gemeinde . "' and AbBez = '" . $name . "' ";


    if (($sucheName == null || $sucheName == "") && ($sucheJahr == null || $sucheJahr == "")) {
        $sql = "SELECT distinct AbBez, AbDatum FROM TAbstimmungen";
    } else if ($sucheJahr == null || $sucheJahr == "") {
        $sql = "SELECT distinct AbBez, AbDatum FROM TAbstimmungen WHERE AbBez like" . "'%" . $sucheName . "%'";
    } else if ($sucheName == null || $sucheName == "") {
        $sql = "SELECT distinct AbBez, AbDatum FROM TAbstimmungen WHERE year(AbDatum) = " . $sucheJahr;
    } else {
        $sql = "SELECT distinct AbBez, AbDatum FROM TAbstimmungen WHERE year(AbDatum) = " . $sucheJahr . " and AbBez like" . "'%" . $sucheName . "%'";
    }

    $gemeinderesult = $conn->query($gemeindesql);
    $result = $conn->query($sql);

    $succrow = mysqli_fetch_assoc($gemeinderesult);

    if ($typ == "Ja/Nein") {
        $jaAusgabe = (float)$succrow["AbJaStimmen"];
        $neinAusgabe = (float)$succrow["AbNeinStimmen"];
    } else {
        $ja1 = (float)$succrow['AbStimmbeteiligung'];
        $total = (float)$succrow['AbStimmberechtigte'];
        $jaAusgabe = $total * $ja1 / 100;
        $jaAusgabe = round($jaAusgabe);
        $neinAusgabe = $total - $jaAusgabe;
        $neinAusgabe = round($neinAusgabe);
    }

    ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var data;
        var chart;

        // Load the Visualization API and the piechart package.
        google.charts.load('current', {'packages': ['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create our data table.
            data = new google.visualization.DataTable();
            data.addColumn('string', 'State');
            data.addColumn('number', 'Number');
            data.addRows([
                ['<?php if ($typ == "Ja/Nein") { echo "Ja"; } else { echo "Stimmende"; }?>', <?php echo $jaAusgabe;?>],
                ['<?php if ($typ == "Ja/Nein") { echo "Nein"; } else { echo "Nicht-Stimmende"; }?>', <?php echo $neinAusgabe;?>]
            ]);

            // Set chart options
            var options = {
                'title': '<?php echo $name;?>',
                'width': 600,
                'height': 450,
                'is3D': true
            };

            // Instantiate and draw our chart, passing in some options.
            chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            google.visualization.events.addListener(chart, 'select', selectHandler);
            chart.draw(data, options);
        }

        function selectHandler() {
            var selectedItem = chart.getSelection()[0];
            var value = data.getValue(selectedItem.row, 0);
            alert('The user selected ' + value);
        }

    </script>


    <div id="content">

    </div>
    <form class="form-signin" name="formular" method="get" action="index.php">
        <h2 class="form-signin-heading"><b>Eidgen&ouml;ssische Abstimmungen auf Gemeindeebene</b></h2>
        <div class="row">
            <div class="column">
                <h3 class="form-signin-heading"><br>Filter</h3>
                <br>
                <h4 class="form-signin-heading">Gemeinde</h4>
                <select class="form-control form-custom" name="gemeinde">
                    <optgroup label="Arbon">
                        <option value="Amriswil" <?php if ($dropDownVal == "Amriswil") echo 'selected="selected"'; ?>>
                            Amriswil
                        </option>
                        <option value="Arbon" <?php if ($dropDownVal == "Arbon") echo 'selected="selected"'; ?>>Arbon
                        </option>
                        <option value="Dozwil" <?php if ($dropDownVal == "Dozwil") echo 'selected="selected"'; ?>>
                            Dozwil
                        </option>
                        <option value="Egnach" <?php if ($dropDownVal == "Egnach") echo 'selected="selected"'; ?>>
                            Egnach
                        </option>
                        <option value="Hefenhofen" <?php if ($dropDownVal == "Hefenhofen") echo 'selected="selected"'; ?>>
                            Hefenhofen
                        </option>
                        <option value="Horn" <?php if ($dropDownVal == "Horn") echo 'selected="selected"'; ?>>Horn
                        </option>
                        <option value="Kesswil" <?php if ($dropDownVal == "Kesswil") echo 'selected="selected"'; ?>>
                            Kesswil
                        </option>
                        <option value="Roggwil" <?php if ($dropDownVal == "Roggwil") echo 'selected="selected"'; ?>>
                            Roggwil
                        </option>
                        <option value="Romanshorn" <?php if ($dropDownVal == "Romanshorn") echo 'selected="selected"'; ?>>
                            Romanshorn
                        </option>
                        <option value="Salmsach" <?php if ($dropDownVal == "Salmsach") echo 'selected="selected"'; ?>>
                            Salmsach
                        </option>
                        <option value="Sommeri" <?php if ($dropDownVal == "Sommeri") echo 'selected="selected"'; ?>>
                            Sommeri
                        </option>
                        <option value="Uttwil" <?php if ($dropDownVal == "Uttwil") echo 'selected="selected"'; ?>>
                            Uttwil
                        </option>
                    </optgroup>
                    <optgroup label="Frauenfeld">
                        <option value="Basadingen-Schlattingen" <?php if ($dropDownVal == "Basadingen-Schlattingen") echo 'selected="selected"'; ?>>
                            Basadingen-Schlattingen
                        </option>
                        <option value="Berlingen" <?php if ($dropDownVal == "Berlingen") echo 'selected="selected"'; ?>>
                            Berlingen
                        </option>
                        <option value="Diessenhofen" <?php if ($dropDownVal == "Diessenhofen") echo 'selected="selected"'; ?>>
                            Diessenhofen
                        </option>
                        <option value="Eschenz" <?php if ($dropDownVal == "Eschenz") echo 'selected="selected"'; ?>>
                            Eschenz
                        </option>
                        <option value="Felben-Wellhausen" <?php if ($dropDownVal == "Felben-Wellhausen") echo 'selected="selected"'; ?>>
                            Felben-Wellhausen
                        </option>
                        <option value="Frauenfeld" <?php if ($dropDownVal == "Frauenfeld") echo 'selected="selected"'; ?>>
                            Frauenfeld
                        </option>
                        <option value="Gachnang" <?php if ($dropDownVal == "Gachnang") echo 'selected="selected"'; ?>>
                            Gachnang
                        </option>
                        <option value="Herdern" <?php if ($dropDownVal == "Herdern") echo 'selected="selected"'; ?>>
                            Herdern
                        </option>
                        <option value="Homburg" <?php if ($dropDownVal == "Homburg") echo 'selected="selected"'; ?>>
                            Homburg
                        </option>
                        <option value="H&uuml;ttlingen" <?php if ($dropDownVal == "H&uuml;ttlingen") echo 'selected="selected"'; ?>>
                            H&uuml;ttlingen
                        </option>
                        <option value="H&uuml;ttwilen" <?php if ($dropDownVal == "H&uuml;ttwilen") echo 'selected="selected"'; ?>>
                            H&uuml;ttwilen
                        </option>
                        <option value="Mammern" <?php if ($dropDownVal == "Mammern") echo 'selected="selected"'; ?>>
                            Mammern
                        </option>
                        <option value="Matzingen" <?php if ($dropDownVal == "Matzingen") echo 'selected="selected"'; ?>>
                            Matzingen
                        </option>
                        <option value="M&uuml;llheim" <?php if ($dropDownVal == "M&uuml;llheim") echo 'selected="selected"'; ?>>
                            M&uuml;llheim
                        </option>
                        <option value="Neunforn" <?php if ($dropDownVal == "Neunforn") echo 'selected="selected"'; ?>>
                            Neunforn
                        </option>
                        <option value="Pfyn" <?php if ($dropDownVal == "Pfyn") echo 'selected="selected"'; ?>>Pfyn
                        </option>
                        <option value="Schlatt" <?php if ($dropDownVal == "Schlatt") echo 'selected="selected"'; ?>>
                            Schlatt
                        </option>
                        <option value="Steckborn" <?php if ($dropDownVal == "Steckborn") echo 'selected="selected"'; ?>>
                            Steckborn
                        </option>
                        <option value="Stettfurt" <?php if ($dropDownVal == "Stettfurt") echo 'selected="selected"'; ?>>
                            Stettfurt
                        </option>
                        <option value="Thundorf" <?php if ($dropDownVal == "Thundorf") echo 'selected="selected"'; ?>>
                            Thundorf
                        </option>
                        <option value="Uesslingen-Buch" <?php if ($dropDownVal == "Uesslingen-Buch") echo 'selected="selected"'; ?>>
                            Uesslingen-Buch
                        </option>
                        <option value="Wagenhausen" <?php if ($dropDownVal == "Wagenhausen") echo 'selected="selected"'; ?>>
                            Wagenhausen
                        </option>
                        <option value="Warth-Weiningen" <?php if ($dropDownVal == "Warth-Weiningen") echo 'selected="selected"'; ?>>
                            Warth-Weiningen
                        </option>
                    </optgroup>
                    <optgroup label="Kreuzlingen">
                        <option value="Altnau" <?php if ($dropDownVal == "Altnau") echo 'selected="selected"'; ?>>
                            Altnau
                        </option>
                        <option value="Bottighofen" <?php if ($dropDownVal == "Bottighofen") echo 'selected="selected"'; ?>>
                            Bottighofen
                        </option>
                        <option value="Ermatingen" <?php if ($dropDownVal == "Ermatingen") echo 'selected="selected"'; ?>>
                            Ermatingen
                        </option>
                        <option value="Gottlieben" <?php if ($dropDownVal == "Gottlieben") echo 'selected="selected"'; ?>>
                            Gottlieben
                        </option>
                        <option value="G&uuml;ttingen" <?php if ($dropDownVal == "G&uuml;ttingen") echo 'selected="selected"'; ?>>
                            G&uuml;ttingen
                        </option>
                        <option value="Kemmental" <?php if ($dropDownVal == "Kemmental") echo 'selected="selected"'; ?>>
                            Kemmental
                        </option>
                        <option value="Kreuzlingen" <?php if ($dropDownVal == "Kreuzlingen") echo 'selected="selected"'; ?>>
                            Kreuzlingen
                        </option>
                        <option value="Langrickenbach" <?php if ($dropDownVal == "Langrickenbach") echo 'selected="selected"'; ?>>
                            Langrickenbach
                        </option>
                        <option value="Lengwil" <?php if ($dropDownVal == "Lengwil") echo 'selected="selected"'; ?>>
                            Lengwil
                        </option>
                        <option value="M&uuml;nsterlingen" <?php if ($dropDownVal == "M&uuml;nsterlingen") echo 'selected="selected"'; ?>>
                            M&uuml;nsterlingen
                        </option>
                        <option value="Raperswilen" <?php if ($dropDownVal == "Raperswilen") echo 'selected="selected"'; ?>>
                            Raperswilen
                        </option>
                        <option value="Salenstein" <?php if ($dropDownVal == "Salenstein") echo 'selected="selected"'; ?>>
                            Salenstein
                        </option>
                        <option value="T&auml;gerwilen" <?php if ($dropDownVal == "T&auml;gerwilen") echo 'selected="selected"'; ?>>
                            T&auml;gerwilen
                        </option>
                        <option value="W&auml;ldi" <?php if ($dropDownVal == "W&auml;ldi") echo 'selected="selected"'; ?>>
                            W&auml;ldi
                        </option>
                    </optgroup>
                    <optgroup label="M&uuml;nchwilen">
                        <option value=Aadorf"" <?php if ($dropDownVal == "Aadorf") echo 'selected="selected"'; ?>>
                            Aadorf
                        </option>
                        <option value="Bettwiesen" <?php if ($dropDownVal == "Bettwiesen") echo 'selected="selected"'; ?>>
                            Bettwiesen
                        </option>
                        <option value="Bichelsee-Balterswil" <?php if ($dropDownVal == "Bichelsee-Balterswil") echo 'selected="selected"'; ?>>
                            Bichelsee-Balterswil
                        </option>
                        <option value="Braunau" <?php if ($dropDownVal == "Braunau") echo 'selected="selected"'; ?>>
                            Braunau
                        </option>
                        <option value="Eschlikon" <?php if ($dropDownVal == "Eschlikon") echo 'selected="selected"'; ?>>
                            Eschlikon
                        </option>
                        <option value="Fischingen" <?php if ($dropDownVal == "Fischingen") echo 'selected="selected"'; ?>>
                            Fischingen
                        </option>
                        <option value="Lommis" <?php if ($dropDownVal == "Lommis") echo 'selected="selected"'; ?>>
                            Lommis
                        </option>
                        <option value="M&uuml;nchwilen" <?php if ($dropDownVal == "M&uuml;nchwilen") echo 'selected="selected"'; ?>>
                            M&uuml;nchwilen
                        </option>
                        <option value="Rickenbach" <?php if ($dropDownVal == "Rickenbach") echo 'selected="selected"'; ?>>
                            Rickenbach
                        </option>
                        <option value="Sirnach" <?php if ($dropDownVal == "Sirnach") echo 'selected="selected"'; ?>>
                            Sirnach
                        </option>
                        <option value="Tobel-T&auml;gerschen" <?php if ($dropDownVal == "Tobel-T&auml;gerschen") echo 'selected="selected"'; ?>>
                            Tobel-T&auml;gerschen
                        </option>
                        <option value="W&auml;ngi" <?php if ($dropDownVal == "W&auml;ngi") echo 'selected="selected"'; ?>>
                            W&auml;ngi
                        </option>
                        <option value="Wilen" <?php if ($dropDownVal == "Wilen") echo 'selected="selected"'; ?>>Wilen
                        </option>
                    </optgroup>
                    <optgroup label="Weinfelden">
                        <option value="Affeltrangen" <?php if ($dropDownVal == "Affeltrangen") echo 'selected="selected"'; ?>>
                            Affeltrangen
                        </option>
                        <option value="Amlikon-Bissegg" <?php if ($dropDownVal == "Amlikon-Bissegg") echo 'selected="selected"'; ?>>
                            Amlikon-Bissegg
                        </option>
                        <option value="Berg" <?php if ($dropDownVal == "Berg") echo 'selected="selected"'; ?>>Berg
                        </option>
                        <option value="Birwinken" <?php if ($dropDownVal == "Birwinken") echo 'selected="selected"'; ?>>
                            Birwinken
                        </option>
                        <option value="Bischofszell" <?php if ($dropDownVal == "Bischofszell") echo 'selected="selected"'; ?>>
                            Bischofszell
                        </option>
                        <option value="B&uuml;rglen" <?php if ($dropDownVal == "B&uumlrglen") echo 'selected="selected"'; ?>>
                            B&uuml;rglen
                        </option>
                        <option value="Bussnang" <?php if ($dropDownVal == "Bussnang") echo 'selected="selected"'; ?>>
                            Bussnang
                        </option>
                        <option value="Erlen" <?php if ($dropDownVal == "Erlen") echo 'selected="selected"'; ?>>Erlen
                        </option>
                        <option value="Hauptwil-Gottshaus" <?php if ($dropDownVal == "Hauptwil-Gottshaus") echo 'selected="selected"'; ?>>
                            Hauptwil-Gottshaus
                        </option>
                        <option value="Hohentannen" <?php if ($dropDownVal == "Hohentannen") echo 'selected="selected"'; ?>>
                            Hohentannen
                        </option>
                        <option value="Kradolf-Sch&ouml;nenberg" <?php if ($dropDownVal == "Kradolf-Sch&ouml;nenberg") echo 'selected="selected"'; ?>>
                            Kradolf-Sch&ouml;nenberg
                        </option>
                        <option value="M&auml;rstetten" <?php if ($dropDownVal == "M&auml;rstetten") echo 'selected="selected"'; ?>>
                            M&auml;rstetten
                        </option>
                        <option value="Sch&ouml;nholzerswilen" <?php if ($dropDownVal == "Sch&ouml;nholzerswilen") echo 'selected="selected"'; ?>>
                            Sch&ouml;nholzerswilen
                        </option>
                        <option value="Sulgen" <?php if ($dropDownVal == "Sulgen") echo 'selected="selected"'; ?>>
                            Sulgen
                        </option>
                        <option value="Weinfelden" <?php if ($dropDownVal == "Weinfelden") echo 'selected="selected"'; ?>>
                            Weinfelden
                        </option>
                        <option value="Wigoltingen" <?php if ($dropDownVal == "Wigoltingen") echo 'selected="selected"'; ?>>
                            Wigoltingen
                        </option>
                        <option value="Wuppenau" <?php if ($dropDownVal == "Wuppenau") echo 'selected="selected"'; ?>>
                            Wuppenau
                        </option>
                        <option value="Zihlschlacht-Sitterdorf" <?php if ($dropDownVal == "Zihlschlacht-Sitterdorf") echo 'selected="selected"'; ?>>
                            Zihlschlacht-Sitterdorf
                        </option>
                    </optgroup>
                </select>
                <h4><br>Anzeigeart ausw&auml;hlen:</h4>
                <fieldset id="typ">
                    <input type="radio" id="jaNein" name="typ" value="Ja/Nein" <?php if ($typ == "Ja/Nein") echo 'checked';?>>
                    <label for="jaNein"> Ja/Nein</label><br>
                    <input type="radio" id="stimmbeteiligung" name="typ" value="Stimmbeteiligung" <?php if ($typ == "Stimmbeteiligung") echo 'checked';?>>
                    <label for="stimmbeteiligung"> Stimmbeteiligung</label>
                </fieldset>
                <br>
                <button class="btn btn-primary" id="button" type="submit" name="submit"
                        value="Senden">Filtern
                </button>
            </div>
            <div class="column">

                <div id="chart_div"></div>
            </div>
        </div>
        <div class="form-inline">
            <h4 class="form-signin-heading"><br>Nach Name/Jahr suchen:</h4>
        </div>
        <div class="form-inline">
            <input type="text" id="input" class="form-control form-custom" placeholder="Name" name="namesuche"
                   autofocus value="<?php echo $sucheName; ?>">
            <input type="number" min="1981" max="2017" id="input" class="form-control form-custom" placeholder="Jahr"
                   name="jahrsuche"
                   autofocus value="<?php echo $sucheJahr; ?>">
            <button class="btn btn-primary" id="button" type="submit" name="submit"
                    value="Senden">Suchen
            </button>
        </div>

        <?php


        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $dates[$i] = $row["AbDatum"];
                $names[$i] = $row['AbBez'];
                $test[$i] = $row['AbGemeindeName'];
                $i++;
            }
            $datalength = count($dates);
            echo "<br>";
            echo "<fieldset id='dataSel'>";
            echo "<table class='table'>";
            echo "<tr>";
            echo "<th>Datum</th>";
            echo "<th>Bezeichnung</th>";
            echo "</tr>";
            if ($datalength > 10) {
                for ($i = 0; $i < 10; $i++) {
                    if ($i == 0) {
                        echo "<td>" . $dates[$i] . "</td>";
                        echo "<td>" . $names[$i] . $test[$i] . "</td>";
                        echo "<td><input type='radio' id='" . "id" . $i . "' name='dataSel' value='$names[$i]' CHECKED></td>";
                        echo "</tr>";
                    } else {
                        echo "<td>" . $dates[$i] . "</td>";
                        echo "<td>" . $names[$i] . "</td>";
                        echo "<td><input type='radio' id='" . "id" . $i . "' name='dataSel' value='$names[$i]'></td>";
                        echo "</tr>";
                    }

                }
            } else {
                for ($i = 0; $i < $datalength; $i++) {
                    if ($i == 0) {
                        echo "<td>" . $dates[$i] . "</td>";
                        echo "<td>" . $names[$i] . "</td>";
                        echo "<td><input type='radio' id='" . "id" . $i . "' name='dataSel' value='$names[$i]' CHECKED></td>";
                        echo "</tr>";
                    } else {
                        echo "<td>" . $dates[$i] . "</td>";
                        echo "<td>" . $names[$i] . "</td>";
                        echo "<td><input type='radio' id='" . "id" . $i . "' name='dataSel' value='$names[$i]'></td>";
                        echo "</tr>";
                    }
                }
            }
            echo "</table>";
            echo "</fieldset>";
            echo $name;
        } else {
            echo "0 results";
        }
        mysqli_close($conn);

        ?>

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
