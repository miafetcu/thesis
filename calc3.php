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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css"> <!-- Add the second CSS file -->
    <style>
         body {
            padding: 20px;
            display: flex; 
            justify-content: center;
            align-items: center;
            height: 100vh;
        } 
    </style>
</head>
<body>
    <?php include "./base.html" ?>

    <?php
    // Retrieve session data
    session_start();
    $capacity = $_SESSION['capc'];

    $panels = ceil($capacity / 2.1);
    $energy = $panels * 0.5;
    $savings = $energy * 2.5 * 1000/19;
    $investment = $panels * 500;
    $time=25;
    ?>

    <div class="simulator-container">
        <h1>Solar Simulator</h1>
        <div class="popup" onclick="myFunction()"> <div class="info-icon"><i class="fas fa-info"></i></div>  Check your maximum potential Case!
        <div class="popuptext" id="myPopup">
            <p><strong>Number of Panels:</strong> <?php echo $panels; ?></p>
            <p><strong>Energy Generated:</strong> <?php echo $energy; ?> kWh/year</p>
            <p><strong>Estimated Annual Savings:</strong> <span id="sav"><?php echo number_format($savings, 2); ?></span> eur</p>
            <p><strong>Investment:</strong>  <?php echo number_format($investment, 2); ?> eur</p>
            </div>
    
        </div>
        
    
         <!-- Range Slide -->
        <div class="simulator-container2">
            <span>Investment Amount:</span>
            <span id="selectedValue"><?php echo $investment; ?> eur</span>
            <input type="range" min="1" max="<?php echo $investment; ?>" value="<?php echo $investment; ?>" class="range-slider" id="myRange">
            
            <span>Number of Panels:</span>
            <span id="selectedValue2"><?php echo $panels; ?></span>
            <input type="range" min="1" max="<?php echo $panels; ?>" value="<?php echo $panels; ?>" class="range-slider2" id="myRange2">

            <span>Period Life Time:</span>
            <span id="selectedValue3"><?php echo $time; ?> years</span>
            <input type="range" min="5" max="<?php echo $time; ?>" value="<?php echo $time; ?>" class="range-slider3" id="myRange3">
        </div>
        <!-- Result Display -->
        <div class="result-container">
            <p><strong>Payback Period:</strong> <span id="result">0</span> years</p>
            <p><strong>Return on Investment (ROI):</strong> <span id="result2">25</span>%</p>
            <p><strong>Price per Solar Panel:</strong> <span id="pricePerPanel"></span> eur</p>
        </div>

        <!-- Slider for Investment -->
      
    </div>

    <script>
    // Function to update calculations and display
    function updateCalculations() {
        // Get the investment amount from the investment slider
        var investment = parseFloat(document.getElementById("myRange").value);
        var time = parseFloat(document.getElementById("myRange3").value);

        // Retrieve annual savings and number of panels from the PHP calculations
        var annualSavings =document.getElementById("sav").textContent;
        annualSavings = parseFloat(annualSavings.replace(/[^0-9.-]+/g,""));

        
        var numberOfPanels = parseFloat(document.getElementById("myRange2").value); // Get current number of panels from the slider

        // Calculate total savings over the expected lifetime (e.g., 25 years)
        var totalSavings = annualSavings * time; // Assuming 25 years for ROI calculation

        // Calculate ROI (%)
        var roi = (totalSavings  / investment) * 100;

        // Update displayed values
        document.getElementById("result").textContent = (investment / annualSavings).toFixed(1); // Payback Period
        document.getElementById("result2").textContent = roi.toFixed(1); // ROI
        document.getElementById("pricePerPanel").textContent = (investment / numberOfPanels).toFixed(2); // Price per Panel
    }

    // Update calculations when investment slider value changes
    document.getElementById("myRange").addEventListener("input", function() {
        // Update investment amount display
        document.getElementById("selectedValue").textContent = this.value;

        // Update all calculations and display
        updateCalculations();
    });

    // Update calculations when number of panels slider value changes
    document.getElementById("myRange2").addEventListener("input", function() {
        // Update number of panels display
        document.getElementById("selectedValue2").textContent = this.value;

        // Update all calculations and display
        updateCalculations();
    });
     // Update calculations when number of panels slider value changes
     document.getElementById("myRange3").addEventListener("input", function() {
        // Update number of panels display
        document.getElementById("selectedValue3").textContent = this.value;

        // Update all calculations and display
        updateCalculations();
    });

    // Initial update of all calculations and display
    updateCalculations();
</script>


</body>
</html>
