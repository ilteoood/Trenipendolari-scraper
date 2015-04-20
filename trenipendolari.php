<!--
Author: Matteo Pietro Dazzi <===> iLTeoooD
-->
<?php
$url='http://www.trenipendolari.it/cgi-bin/status?direttrice=D25';
$src=file_get_contents($url);
if(!empty($src)) {
    $pos1 = strpos($src, "Totale ", 0)+7;
    $pos2 = strpos($src, " treni", $pos1);
    $train=substr($src, $pos1, $pos2-$pos1);
    $pos1 = 0;
    $pos2 = 0;
    ?>
    <html>
    <title>
        Trenipendolari
    </title>
    <body>
    <table>
        <thead>
        <th>Numero treno</th>
        <th>Partenza</th>
        <th>Arrivo</th>
        <th>Stato</th>
        <th>Info</th>
        </thead>
        <tbody>
        <?php
        for ($i = 0; $i < $train; $i++) {
            echo "<tr><td>";
            //Numero treno
            $pos1 = strpos($src, "<a class=\"tooltip\"", $pos2) + 28;
            $pos2 = strpos($src, "<span class=\"classic\"", $pos1);
            $text = substr($src, $pos1, $pos2 - $pos1);
            echo $text . "</td><td>";
            //Tragitto, da-a:
            $pos1 = strpos($src, "<span class=\"classic\"", $pos2) + 22;
            $pos2 = strpos($src, "</span>", $pos1);
            $text = substr($src, $pos1, $pos2 - $pos1);
            $part = explode("-", $text);
            echo str_replace(":00","",str_replace("Partenza ","",$part[0])) . "</td><td>".str_replace(":00","",str_replace("Arrivo ","",$part[1]))."</td>";
            //Stato del ritardo
            $pos1 = strpos($src, "<span class=\"style1\"", $pos2) + 21;
            $pos2 = strpos($src, "</span>", $pos1);
            $text = substr($src, $pos1, $pos2 - $pos1);
            echo '<td>' . $text . '</td>';
            //Info
            $pos1_back = strpos($src, "<span class=\"style1\"", $pos2) + 21;
            $pos2_back = strpos($src, "</span>", $pos1_back);
            $text = substr($src, $pos1_back, $pos2_back - $pos1_back);
            if (strpos($text, 'min') === FALSE && strpos($text, 'orario') === FALSE && strpos($text, 'board') === FALSE) {
                $pos1 = $pos1_back;
                $pos2 = $pos2_back;
            } else {
                $pos1 = strpos($src, "<a class=\"tooltip\"", $pos2);
                $pos2 = strpos($src, "<span class=\"classic\"", $pos1);
                $text = substr($src, $pos1 + 28, $pos2 - $pos1 - 28);
                $text = str_replace(" - maggiori info", "", $text);
            }
            echo '<td>' . $text . '</td>';
            echo "</tr>";
        }
        ?>
        </td></tbody>
    </table>
    </body>
    </html>
<?php
}
?>
