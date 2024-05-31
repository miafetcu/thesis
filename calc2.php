<!DOCTYPE html>
<html>
<head>
    <title>Solar Calculator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
    <script src="nav_bar.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css"> <!-- Add the second CSS file -->
</head>

<body><!-- About Section -->
<div id="content">Nav-Bar</div>
   
<?php
session_start();
$consomption = $_SESSION['cons'] ?? '';
$capacity = $_SESSION['capc'] ?? '';
$levels = $_SESSION['levels'] ?? '';
$region = $_SESSION['region'] ?? '';

$areaPanel = 2.1;
$maxpanels = ceil($capacity / $areaPanel);

$solarCapacityFactor = 0.14;

if ($region == 'north') {
    $energy = $capacity * $solarCapacityFactor * 4 * 365;
} elseif ($region == "center") {
    $energy = $capacity * $solarCapacityFactor * 4.5 * 365;
} elseif ($region == "south") {
    $energy = $capacity * $solarCapacityFactor * 5 * 365;
}

$energyPanel = 400;
if ($levels == 'high') {
    $nr = $consomption * 1.2 / $energyPanel;
} elseif ($levels == "medium") {
    $nr = $consomption * 1.1 / $energyPanel;
} elseif ($levels == "low") {
    $nr = $consomption / $energyPanel;
}
$nr = ceil($nr);

$convertEUR = 19;
$priceKwh = 2.5;
$savings = $energy * $priceKwh / $convertEUR;
$savings = ceil($savings);
$price1panel = 400;
$investment = $nr * $price1panel;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['simulate'])) {
        $query_string = http_build_query([
            'cons' => $consomption,
            'capc' => $capacity,
            'levels' => $levels,
            'region' => $region,
            'maxpanels' =>$maxpanels,
            'investment'=>$investment
        ]);
        $redirect_url = "calc3.php?$query_string";
        echo "<script>window.location.href = '$redirect_url';</script>";
        exit();
    }
}
?>


<div >
    <!-- multistep form -->
    <form id="msform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset>
            <h1 class="big-title">Your Power Calculator</h1>

            <p>Actionable Insights</p>
            <div class="result-container">
                <div class="result-box">
                    <p>Annual Energy Generation:<br><?php echo '<span style="font-size: 40px;">' . $energy . '</span>'; ?> kWh/year</p>
                </div>
                <div class="result-box">
                    <p>Number of Solar Panels Needed:<br><?php echo '<span style="font-size: 40px;">' . $nr . '</span>'; ?></p>
                    <p>Maximum Number of Solar Panels:<br><?php echo '<span style="font-size: 40px;">' . $maxpanels . '</span>'; ?></p>
                </div>
</div>
<p>Financial Insights</p>
            <div class="result-container">    
                <div class="result-box">
                    <p>Total Annual Savings:<br><?php echo '<span style="font-size: 40px;">' . number_format($savings, 0) . '</span>'; ?> <br>EUR</p>
                </div>
                <div class="result-box">
                    <p>Investment Cost:<br><?php echo '<span style="font-size: 40px;">' . number_format($investment, 0) . '</span>'; ?> <br> EUR</p>
                </div>
            </div>
            <button type="submit" name="simulate" class="next action-button">Simulate</button>
        </fieldset>
    </form>
</div>

</body>
</html>


