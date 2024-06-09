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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css"> <!-- Add the second CSS file -->
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
            var consomption = parseFloat(getUrlParameter('cons'));
            var capacity = parseFloat(getUrlParameter('capc'));
            var levels = getUrlParameter('levels');
            var region = getUrlParameter('region');

            var areaPanel = 2.1;
            var maxpanels = Math.ceil(capacity / areaPanel);

            var solarCapacityFactor = 0.2;
            
        
            var energyPanel = 500;
            var nr;
            if (levels === 'high') {
                nr = consomption * 1.2 / energyPanel;
            } else if (levels === 'medium') {
                nr = consomption * 1.1 / energyPanel;
            } else if (levels === 'low') {
                nr = consomption / energyPanel;
            }
            nr = Math.ceil(nr);
            
            var energy;
            if (region === 'north') {
                energy = nr*areaPanel * solarCapacityFactor * 4 *365;
            } else if (region === 'center') {
                energy = nr*areaPanel * solarCapacityFactor * 4.5*365 ;
            } else if (region === 'south') {
                energy = nr*areaPanel * solarCapacityFactor * 5 *365;
            }
            energy = Math.ceil(energy);
           

            var convertEUR = 19;
            var priceKwh = 2.5;
            var savings = energy * priceKwh / convertEUR;
            savings = Math.ceil(savings);
            var price1panel = 400;
            var investment = nr * price1panel;

            // Update HTML content
            document.getElementById('annualEnergy').innerText = energy;
            document.getElementById('numberOfPanels').innerText = nr;
            document.getElementById('maxNumberOfPanels').innerText = maxpanels;
            document.getElementById('annualSavings').innerText = savings.toLocaleString();
            document.getElementById('investmentCost').innerText = investment.toLocaleString();
    
    // Function to construct new URL with parameters
    function constructNewUrl(params) {
        const baseUrl = 'calc3.php';
        const queryParams = new URLSearchParams(params).toString();
        return `${baseUrl}?${queryParams}`;
    }
    
    document.getElementById('simulateForm').addEventListener('click', () => {
        event.preventDefault();
    const params1 = {
        energy: energy,
        min_panels:nr,
        max_panels:maxpanels,
        savings:savings,
        investment:investment
       
    };
        const newUrl = constructNewUrl(params1);
        window.location.href = newUrl;
    });

        });
    </script>
</head>

<body>
    <!-- About Section -->
    <div id="content">Nav-Bar</div>
    
    <div>
        <!-- Multistep form -->
        <form id="msform">
            <fieldset>
                <h1 class="big-title">Your Power Calculator</h1>

                <p>Actionable Insights</p>
                <div class="result-container">
                    <div class="result-box">
                        <p>Annual Energy Generation:<br><span style="font-size: 40px;" id="annualEnergy"></span> kWh/year</p>
                    </div>
                    <div class="result-box">
                        <p>Number of Solar Panels Needed:<br><span style="font-size: 40px;" id="numberOfPanels"></span></p>
                        <p>Maximum Number of Solar Panels:<br><span style="font-size: 40px;" id="maxNumberOfPanels"></span></p>
                    </div>
                </div>
                
                <div class="popup" onclick="myFunction()">
        <div class="info-icon"><i class="fas fa-info"></i></div>  
        Financial Insights
        <div class="popuptext" id="myPopup">
            <p>Financial Insights for the base case of the needed solar panels to cover the consumption</p>
        </div>
    </div>
                <div class="result-container">    
                    <div class="result-box">
                        <p>Total Annual Savings:<br><span style="font-size: 40px;" id="annualSavings"></span> <br>EUR</p>
                    </div>
                    <div class="result-box">
                        <p>Investment Cost:<br><span style="font-size: 40px;" id="investmentCost"></span> <br> EUR</p>
                    </div>
                </div>
                <button type="submit" class="next action-button" id="simulateForm">Simulate</button>
            </fieldset>
        </form>
    </div>

</body>
</html>
