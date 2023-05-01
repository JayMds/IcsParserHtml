<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Title</title>
</head>

<body>

<label for="menuToggle">
    <div class="svgGroup">
        <svg class="menu" viewBox="0 0 448 512" width="100" title="bars">
            <path
                d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/>
        </svg>
        <svg class="close" viewBox="0 0 384 512" width="100" title="times">
            <path
                d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/>
        </svg>
    </div>
</label>
<input type="checkbox" id="menuToggle">

<div class="filterAndNavGroup">

    <div class="filterMenu">
        <button type="button" id="resetButton" class="btn btn-outline-secondary">Afficher Tout</button>
        <button type="button" id="filterBeforeDate" class="btn btn-outline-secondary">Antérieur à Année
            (comprise)
        </button>
        <input type="number" min="2000" max="2099" step="1" value="2023" id="dateFilterInput">

        <button type="button" id="filterAtDate" class="btn btn-outline-secondary">Afficher année saisie</button>
        <button type="button" id="filterAfterDate" class="btn btn-outline-secondary">Posterieur à Année
            (comprise)
        </button>
    </div>

    <ul class="ulZones">
        <li><a id="lienZoneA" class="link-secondary" href="http://localhost:8080/?zone=a">Zone A</a></li>
        <li><a id="lienZoneB" class="link-secondary" href="http://localhost:8080/?zone=b">Zone B</a></li>
        <li><a id="lienZoneC" class="link-secondary" href="http://localhost:8080/?zone=c">Zone C</a></li>
        <li><a id="lienZoneA-B-C-Corse" class="link-secondary" href="http://localhost:8080/">Toutes</a></li>
    </ul>

</div>


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './icsparseclass/IcsCalendarUnit.php';
include './icsparseclass/IcsEventUnit.php';
include './icsparseclass/FileReader.php';
include './htmlclass/HtmlElement.php';
include './htmlclass/SpanElement.php';
include './htmlclass/ContainerElement.php';
include './htmlclass/HxElement.php';
include './htmlclass/DivElement.php';
include './htmlclass/PElement.php';
include './htmlclass/SmallElement.php';

//todo: gerer la vue responsive mobile

$reader = new FileReader();
$div = new DivElement();
if (isset($_GET['zone'])) {
    $zone = strtoupper($_GET['zone']);
} else {
    $zone = 'A-B-C-Corse';
}

if (!in_array($zone, FileReader::ALLOWED_ZONE)) {
    throw new Exception('Zone inconnue');
}

$reader->setIcsCalendarText("icsfiles/Zone-" . $zone . ".ics");

try {
    $calendar = $reader->parseIcs();
} catch (Exception $e) {

}
$reader->exportCalendarToJson();


echo "<div id='zone' data-zone='$zone'>";
echo $calendar;
echo "</div>";

?>
<script style="module" src="index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>


</body>


</html>




