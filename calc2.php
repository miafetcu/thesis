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


    $panels = ceil($capacity/2.1);
    $energy = $panels*0.5;
    $savings = $energy*2.5*1000/19;
    $investment = $panels*500;
    
    // if (isset($_POST['simulate'])) {
    //     echo "<script>window.location.href = 'calc3.php';</script>"; }
    // exit();
  
    ?>

    <!-- multistep form -->
    <form id="msform">
        
        <!-- progressbar -->

        <!-- fieldsets -->
        <fieldset>
        <h1 class="big-title">Your Power Calculator</h1>

            <div class="result-container">
                <div class="result-box">
                    <p>Solar System Size offered by panels <br><?php echo '<span style="font-size: 40px;">' . $energy . '</span>'; ?> kWh</p>
                </div>
                <div class="result-box">
                    <p>Maximum Number of Solar Panels:<br><?php echo '<span style="font-size: 40px;">' . $panels .  '</span>'; ?></p>
                </div>

                <div class="result-box">
                    <p>Total Annual Savings<br><?php echo '<span style="font-size: 40px;">' . number_format($savings,0) . '</span>'; ?><br> eur</p>
                </div>

                <div class="result-box">
                    <p>Investment: <br><?php echo '<span style="font-size: 40px;">' . number_format($investment, 0)  . '</span>'; ?> euro</p>
                </div>

            </div>
            <button type="submit" name="simulate" class="next action-button" >Do a Simulation</button>
        </fieldset>
    </form>

</body>
</html>
