<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Die 3 Meta-Tags oben *müssen* zuerst im head stehen; jeglicher sonstiger head-Inhalt muss *nach* diesen Tags kommen -->
    <link rel="icon" href="img/favicon.ico">
    <title>Distanzrechner</title>
    <!-- Bootstrap via MaxCDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Eigene Styles -->
    <!-- <link rel="stylesheet" href="css/bootstrap-custom.css">  -->
    <!-- ACHTUNG: IE < 9 unterstützen wir nicht mehr! -->
</head>
<body id="bg1">
<div class="container">

    <form class="form-signin" name="formular" method="get" action="index.php">
        <h2 class="form-signin-heading"><b>Distanzrechner</b></h2>
        <h3 class="form-signin-heading"><b><br>Eingaben</b></h3>
        <p class="form-signin-heading">Masseinheit</p>
        <select class="form-control form-custom" name="masseinheit">
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

        <p class="form-signin-heading"><br>Wert</p>
        <input type="number" step="any" id="input" class="form-control form-custom" placeholder="Eingabe" name="inputA"
               required autofocus>

        <?php

        //error_reporting(0);
        $input = $_GET['inputA'];
        ?>

        <h3 class="form-signin-heading"><b><br>Ausgaben</b></h3>

        <p class="form-signin-heading"><?php echo $option1; ?></p>
        <input type="number" id="input" class="form-control form-custom" placeholder="" name="outputA" required readonly
               autofocus value="<?php echo $outputA; ?>">
        <p class="form-signin-heading"><?php echo $option2; ?></p>
        <input type="number" id="input" class="form-control form-custom" placeholder="" name="outputB" required readonly
               autofocus value="<?php echo $outputB; ?>">
        <p class="form-signin-heading"><?php echo $option3; ?></p>
        <input type="number" id="input" class="form-control form-custom" placeholder="" name="outputC" required readonly
               autofocus value="<?php echo $outputC; ?>">
        <p class="form-signin-heading"><?php echo $option4; ?></p>
        <input type="number" id="input" class="form-control form-custom" placeholder="" name="outputD" required readonly
               autofocus value="<?php echo $outputD; ?>">
        <br>
        <button class="btn btn-lg btn-primary btn-block btn-custom" id="button" type="submit" name="submit"
                value="Senden">Berechnen
        </button>

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
