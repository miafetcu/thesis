<!DOCTYPE html>
<html>
<head>
<title>Solar Calculator</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/script.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="/style2.css">
<link rel="stylesheet" href="/style.css">


</head>
<body><!-- About Section -->

<div class="w3-top" >
    <div class="w3-bar w3-white w3-card" id="myNavbar">
      <a href="index.php">
        <img src="/logo.jpeg" style="width: 8%; height: 50px; padding-left: 0.5%;">
      </a>
      <!-- Right-sided navbar links -->
      <div class="w3-right w3-hide-small">
        <a href="/purpose.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i>Who are we</a>
        <a href="/suis.php" class="w3-bar-item w3-button"><i class="fa fa-tasks"></i>What we do</a>
        <a href="/insight.php" class="w3-bar-item w3-button"><i class="fa fa-bar-chart"></i>Insights</a>
        <a href="/calc.php" class="w3-bar-item w3-button"><i class="fa fa-database"></i>Calculator</a>
        <a href="/contact.php" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i>Contact</a>
        <a href="./templates/templates/upload_form.php" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i>Upload</a>
      </div>
      <!-- Hide right-floated links on small screens and replace them with a menu icon -->
  
      <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
</div>

<!-- multistep form -->
<form action="/" method="post" enctype="multipart/form-data" id="msform">
  <h1 class="big-title">Your Automated Calculator</h1>
  <!-- progressbar -->
 
  <!-- fieldsets -->
  <fieldset>
      <h2 class="fs-title">Your details</h2>

      <input type="file" name="pdf_file" id="triggerButton" accept=".pdf"> <br>
       

      <label for="capc" class="fs-subtitle2">Your roof capacity:</label><br>
      <input required type="text" name="capc" placeholder="m&sup2;" value="<?php echo $capc;?>" class="error-input" >
      <span class="error"><?php echo $capc_error;?></span><br>

      <div class="popup" onclick="togglePopup('energyBehaviorPopup')">
            <div class="info-icon"><i class="fas fa-info"></i></div> 
        <label for="levels" class="fs-subtitle2">Your energy behavior:</label><br>
        <div class="popuptext" id="energyBehaviorPopup">
            <p class="fs-subtitle2">Energy behavior refers to your actions affecting household energy usage.
            High involves conscious conservation, medium includes some efforts, while low indicates minimal attention.</p>
        </div>
        </div><br>

        <select id="levels" name="levels" class="fs-subtitle">
        <option <?php if (isset($levels) && $levels=="high") echo "selected";?> value="high">High</option>
        <option <?php if (isset($levels) && $levels=="medium") echo "selected";?> value="medium">Medium</option>
        <option <?php if (isset($levels) && $levels=="low") echo "selected";?> value="low">Low</option>
        </select> <br>

        <div class="popup" onclick="togglePopup('regionPopup')">
        <div class="info-icon"><i class="fas fa-info"></i></div> 
        <label for="region" class="fs-subtitle2">Your region:</label><br>
        <div class="popuptext" id="regionPopup">
            <p class="fs-subtitle2">Your region refers to the geographical location of your household in Moldova.
            This info will be used for peak sunlight hours.</p>
        </div>
        </div><br>

        <select id="region" name="region" class="fs-subtitle">
        <option <?php if (isset($region) && $region=="north") echo "selected";?> value="north">North</option>
        <option <?php if (isset($region) && $region=="center") echo "selected";?> value="center">Center</option>
        <option <?php if (isset($region) && $region=="south") echo "selected";?> value="south">South</option>
        </select><br>
  <button  id="triggerButton2" type="submit">Upload</button> 
  <button  id="triggerButton3" type="submit">Upload</button> 
  </fieldset>
  <script>
    document.getElementById('triggerButton2').addEventListener('click', function() {
      // event.preventDefault();
        console.log("hey");
    });
    document.getElementById('triggerButton3').addEventListener('click', function() {
        console.log("hey");
    });
    </script>
</form>
</body>
</html>