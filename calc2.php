<!DOCTYPE html>
<html>
<head>
    <title>Solar Calculator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css"> <!-- Add the second CSS file -->
</head>

<body><!-- About Section -->
    <!--bar top-->
    <?php include "./base.html" ?>

    <?php
    // Retrieve session data
    session_start();
    $consomption = $_SESSION['cons'];
    $capacity = $_SESSION['capc'];
    $levels = $_SESSION['levels'];
    $region = $_SESSION['region'];

    $areaPanel = 2.1;
    $maxpanels = ceil($capacity/$areaPanel);
    // $energy = $panels*0.5;

    
    $solarCapacityFactor = 0.14;

   // <--Energy Generated (kWh/year)=Capacity of Roof (kW)×Solar Capacity Factor×8760 hours/year-->//
    if($region=='north'){
    $energy=$capacity*$solarCapacityFactor*4*365;
    }elseif($region=="center"){
        $energy=$capacity*$solarCapacityFactor*4.5*365;
    }elseif($region=="south"){
        $energy=$capacity*$solarCapacityFactor*5*365;
    }
    echo "mia1 " . "$energy";
    $energyPanel = 500;
    if($levels=='high'){
        $nr=$consomption*1.2/$energyPanel;
        }elseif($levels=="medium"){
            $nr=$consomption*1.1/$energyPanel;
        }elseif($levels=="low"){
            $nr=$consomption/$energyPanel;
        }
        $nr = ceil($nr);

        echo "mia2 " . "$nr";

        $convertEUR = 19;
    $priceKwh = 2.5;
    $savings = $energy*$priceKwh/$convertEUR;
    $savings = ceil($savings);
    echo "$savings";
    $price1panel = 400;
    $investment = $nr*$price1panel;
    
    if (isset($_POST['simulate'])) {
        $redirect_url = "calc3.php?$query_string";
       echo "<script>window.location.href = '$redirect_url';</script>"; // Redirect to calc3.php
   }
  
    ?>

    <!-- multistep form -->
    <form id="msform">
        
        <!-- progressbar -->

        <!-- fieldsets -->
        <fieldset>
        <h1 class="big-title">Your Power Calculator</h1>

            <div class="result-container">
                <div class="result-box">
                    <p>The Potential Energy Generation from Solar Panels <br><?php echo '<span style="font-size: 40px;">' . $energy . '</span>'; ?> kWh/year</p>
                </div>
                <div class="result-box">
                    <p>Maximum Number of Solar Panels:<br><?php echo '<span style="font-size: 40px;">' . $maxpanels .  '</span>'; ?></p>
                    <p>The number of solar panels needed:<br><?php echo '<span style="font-size: 40px;">' . $nr .  '</span>'; ?></p>
                </div>

                <div class="result-box">
                    <p>Total Annual Savings<br><?php echo '<span style="font-size: 40px;">' . number_format($savings,0) . '</span>'; ?><br> eur</p>
                </div>

                <div class="result-box">
                    <p>Investment: <br><?php echo '<span style="font-size: 40px;">' . number_format($investment, 0)  . '</span>'; ?> euro</p>
                </div>

            </div>
            <button type="submit" name="simulate" class="simulate" onclick="redirectToSimulation()">Do a Simulation</button>
        </fieldset>
    </form>

</body>
</html>
