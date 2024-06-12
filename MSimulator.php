<!DOCTYPE html>
<html>
<head>
    <title>Solar Calculator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="javascript/script.js"></script>
    <script src="javascript/nav_bar.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style2.css"> <!-- Add the second CSS file -->
    <style>
        .simulator-container {
            margin-top: 130px;
            margin-left: 18%;
        }
    </style>
</head>
<body>
<div id="content">Nav-Bar</div>

<div class="simulator-container">
    <h1>Solar Simulator</h1>
    <div class="popup" onclick="myFunction()">
        <div class="info-icon"><i class="fas fa-info"></i></div>  
        Check your maximum potential Case!
        <div class="popuptext" id="myPopup">
            <p><strong>Number of Panels: </strong><span id="numberOfPanels"></span> - <span id="maxNumberOfPanels"></span></p>
            <p><strong>Energy Generated:</strong> <span id="annualEnergy"></span> kWh/year</p>
            <p><strong>Estimated Annual Savings:</strong> <span id="annualSavings"></span> eur</p>
            <p><strong>Investment:</strong> <span id="investmentCost"></span> eur</p>
        </div>
    </div>
    
    <!-- Range Sliders -->
    <div class="simulator-container2">
        <span>Investment Amount:</span>
        <span id="investmentCostDisplay">25000</span>
        <input type="range" min="1" max="50000" value="25000" class="range-slider" id="myRange">
        
        <span>Number of Panels:</span>
        <span id="selectedValue2">5</span>
        <input type="range" min="1" max="20" value="10" class="range-slider2" id="myRange2">

        <span>Period Life Time:</span>
        <span id="selectedValue3">25 years</span>
        <input type="range" min="5" max="25" value="25" class="range-slider3" id="myRange3">
    </div>

    <!-- Result Display -->
    <div class="result-container">
        <p><strong>Payback Period:</strong> <span id="result">0</span> years</p>
        <p><strong>Return on Investment (ROI):</strong> <span id="result2">25</span>%</p>
        <p><strong>Price per Solar Panel:</strong> <span id="pricePerPanel"></span> eur</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to get URL parameters
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Extract parameters from URL
    var energy = parseFloat(getUrlParameter('energy')) || 5000;
    var min_panels = parseFloat(getUrlParameter('min_panels')) || 5;
    var max_panels = parseFloat(getUrlParameter('max_panels')) || 20;
    var savings = parseFloat(getUrlParameter('savings')) || 1000;
    var investment = parseFloat(getUrlParameter('investment')) || 25000;

    document.getElementById('annualEnergy').innerText = energy;
    document.getElementById('numberOfPanels').innerText = min_panels;
    document.getElementById('maxNumberOfPanels').innerText = max_panels;
    document.getElementById('annualSavings').innerText = savings.toLocaleString();
    document.getElementById('investmentCost').innerText = investment.toLocaleString();
    document.getElementById('investmentCostDisplay').innerText = investment.toLocaleString();
    document.getElementById('selectedValue2').innerText = min_panels;

    // Set slider attributes based on URL parameters
    const price_panel = 400;
    document.getElementById('myRange2').max = max_panels;
    document.getElementById('myRange2').min = Math.floor(min_panels / 2);
    document.getElementById('myRange2').value = min_panels;

    document.getElementById('myRange').value = investment;
    document.getElementById('myRange').max = max_panels*price_panel * 1.3;
    document.getElementById('myRange').min = investment /2 ;

    // Function to update calculations and display
    function updateCalculations() {
        // Get the investment amount from the investment slider
        var investment = parseFloat(document.getElementById("myRange").value);
        var time = parseFloat(document.getElementById("myRange3").value);

        // Retrieve annual savings and number of panels from the input
        var annualSavings = parseFloat(document.getElementById("annualSavings").textContent.replace(/[^0-9.-]+/g,""));
        var numberOfPanels = parseFloat(document.getElementById("myRange2").value); // Get current number of panels from the slider

        // Calculate total savings over the expected lifetime
        var totalSavings = annualSavings * time;

        // Calculate ROI (%)
        var roi = (totalSavings  / investment) * 100;

        // Update displayed values
        document.getElementById("result").textContent = (investment / annualSavings).toFixed(1); // Payback Period
        document.getElementById("result2").textContent = roi.toFixed(1); // ROI
        document.getElementById("pricePerPanel").textContent = (investment / numberOfPanels).toFixed(2); // Price per Panel
    }

    // Update calculations when sliders value changes
    document.getElementById("myRange").addEventListener("input", function() {
        document.getElementById("investmentCostDisplay").textContent = this.value;
        updateCalculations();
    });

    document.getElementById("myRange2").addEventListener("input", function() {
        document.getElementById("selectedValue2").textContent = this.value;
        updateCalculations();
    });

    document.getElementById("myRange3").addEventListener("input", function() {
        document.getElementById("selectedValue3").textContent = this.value + " years";
        updateCalculations();
    });

    // Initial update of all calculations and display
    updateCalculations();
});
</script>
</body>
</html>
