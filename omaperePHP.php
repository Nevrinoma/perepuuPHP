<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $xml = simplexml_load_file('perepuu.xml');

    $nimi = $_POST['nimi'];
    $elus = $_POST['elus'];
    $synd = $_POST['synd'];
    $elukoht = $_POST['elukoht'];

    if ($_POST['hasChildren'] == 'yes') {
        $lapsed = $xml->addChild('lapsed');
        $laps_nimi = $_POST['laps_nimi'];
        $laps_elus = $_POST['laps_elus'];

        $inimene = $lapsed->addChild('inimene');
        $inimene->addChild('nimi', $laps_nimi);
        $inimene->addChild('elus', $laps_elus);
    }

    $inimene = $xml->addChild('inimene');
    $inimene->addChild('nimi', $nimi);
    $inimene->addChild('elus', $elus);
    $inimene->addAttribute('synd', $synd);
    $inimene->addAttribute('elukoht', $elukoht);

    $xml->asXML('perepuu.xml');
}

$inimesed = simplexml_load_file('perepuu.xml');
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inimeste lisamine</title>
</head>
<body>
<h2>Inimeste sisestamine</h2>
<form action="" method="post">
    <table>
        <tr>
            <td><label for="nimi">Inimese nimi:</label></td>
            <td><input type="text" name="nimi" id="nimi" required></td>
        </tr>
        <tr>
            <td><label for="synd">Sunni Aasta:</label></td>
            <td><input type="number" name="synd" id="synd" required min="0" max="2023" value="1900"></td>
        </tr>
        <tr>
            <td><label for="elukoht">Elukoht:</label></td>
            <td><input type="text" name="elukoht" id="elukoht" required></td>
        </tr>
        <tr>
            <td><label for="elus">Elus:</label></td>
            <td>
                <input type="radio" name="elus" value="Jah" id="elus_da" required>
                <label for="elus_da">Jah</label>
                <input type="radio" name="elus" value="Ei" id="elus_net" required>
                <label for="elus_net">Ei</label>
            </td>
        </tr>
        <tr>
            <td><label>Lapsed:</label></td>
            <td>
                <input type="radio" name="hasChildren" value="yes" id="hasChildren_yes">
                <label for="hasChildren_yes">On</label>
                <input type="radio" name="hasChildren" value="no" id="hasChildren_no">
                <label for="hasChildren_no">Ei ole</label>
            </td>
        </tr>
    </table>
    <div id="childrenForm" style="display: none;">
        <h3>Lapse info:</h3>
        <table>
            <tr>
                <td><label for="laps_nimi">Nimi:</label></td>
                <td><input type="text" name="laps_nimi" id="laps_nimi"></td>
            </tr>
            <tr>
                <td><label for="laps_elus">Elus:</label></td>
                <td>
                    <input type="radio" name="laps_elus" value="Jah" id="laps_elus_da">
                    <label for="laps_elus_da">Jah</label>
                    <input type="radio" name="laps_elus" value="Ei" id="laps_elus_net">
                    <label for="laps_elus_net">Ei</label>
                </td>
            </tr>
        </table>
    </div>
    <input type="submit" name="submit" value="Lisa">
</form>

<h2>Andmed xml failist perepuu.xml</h2>
<table>
    <?php

    echo "<table border='1'>";
    echo "<tr><th>Nimi</th><th>Synd</th><th>Elukoht</th><th>Elus</th></tr>";

    function processInimene($inimene) {
        echo "<tr>";
        echo "<td>" . $inimene->nimi . "</td>";
        echo "<td>" . $inimene['synd'] . "</td>";
        echo "<td>" . $inimene['elukoht'] . "</td>";
        echo "<td>" . $inimene->elus . "</td>";
        echo "</tr>";
        if ($inimene->lapsed) {
            foreach ($inimene->lapsed->inimene as $laps) {
                processInimene($laps);
            }
        }
    }
    processInimene($inimesed);
    ?>
</table>

<script>
    document.querySelector('input[name="hasChildren"]').addEventListener('change', function () {
        if (this.value === 'yes') {
            document.getElementById('childrenForm').style.display = 'block';
        }
        else if (this.value === 'no'){
            document.getElementById('childrenForm').style.display = 'none';
        }
        else {
            document.getElementById('childrenForm').style.display = 'none';
        }
    });
</script>
</body>
</html>
