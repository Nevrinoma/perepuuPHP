<?php
if(isset($_POST['submit'])){
    $xmlDoc = new DOMDocument("1.0","UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load('tooted.xml');
    $xmlDoc->formatOutput = true;

    $xml_root = $xmlDoc->documentElement;
    $xmlDoc->appendChild($xml_root);

    $xml_toode = $xmlDoc->createElement("toode");
    $xmlDoc->appendChild($xml_toode);

    $xml_root->appendChild($xml_toode);

    $xml_toode->appendChild($xmlDoc->createElement('nimetus', $_POST['nimetus']));
    $xml_toode->appendChild($xmlDoc->createElement('kirjeldus', $_POST['kirjeldus']));
    $xml_toode->appendChild($xmlDoc->createElement('hind', $_POST['hind']));
    $lisad=$xml_toode->appendChild($xmlDoc->createElement('lisad'));
    $lisad->appendChild($xmlDoc->createElement('nimetus', $_POST['lisa']));


    /*
        unset($_POST['submit']);
        foreach($_POST as $voti=>$vaartus){
            $kirje = $xmlDoc->createElement($voti,$vaartus);
            $xml_toode->appendChild($kirje);
        }*/
    $xmlDoc->save('tooted.xml');
}
$tooted=simplexml_load_file('tooted.xml');
?>
<!DOCTYPE html>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toote lisamine</title>
</head>

<body>
<h2>Toote sisestamine</h2>
<form action="" method="post" name="vorm1">
    <table>
        <tr>
            <td><label for="nimetus">Toote nimetus:</label></td>
            <td><input type="text" name="nimetus" id="nimetus" autofocus></td>
        </tr>
        <tr>
            <td><label for="kirjeldus">Kirjeldus:</label></td>
            <td><input type="text" name="kirjeldus" id="kirjeldus"></td>
        </tr>
        <tr>
            <td><label for="hind">Hind:</label></td>
            <td><input type="text" name="hind" id="hind"></td>
        </tr>
        <tr>
            <td><label for="lisa">Lisade nimetus:</label></td>
            <td><input type="text" name="lisa" id="lisa"></td>
        </tr>
        <tr>
            <td><input type="submit" name="submit" id="submit" value="Sisesta"></td>
            <td></td>
        </tr>

    </table>
</form>
<h2>Andmed xml failist tooted.xml</h2>
<table>
    <?php
    foreach($tooted->toode as $toode){
        echo "<tr>";
        echo "<td>".$toode->nimetus."</td>";
        echo "<td>".$toode->kirjeldus."</td>";
        echo "<td>".$toode->hind."</td>";
        echo "<td>".$toode->lisad->nimetus."</td>";
        echo "</tr>";
    }

    ?>
</table>
</body>
</html>