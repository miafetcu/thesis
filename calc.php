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
<link rel="stylesheet" href="style2.css">
</head>

<body><!-- About Section -->
<?php include "./base.html";


$cons = $capc = $levels = $region = "";
$cons_error = $capc_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["cons"])) {
        $cons_error = "Please enter your annual energy consumption.";
    } elseif (!is_numeric($_POST["cons"])) {
        $cons_error = "Please enter a valid number.";
    } else {
        $cons = test_input($_POST["cons"]);
    }

    if (empty($_POST["capc"])) {
        $capc_error = "Please enter your roof capacity.";
    } elseif (!is_numeric($_POST["capc"])) {
        $capc_error = "Please enter a valid number.";
    } else {
        $capc = test_input($_POST["capc"]);
    }

    if (empty($_POST["levels"])) {
        $levels = "";
    } else {
        $levels = test_input($_POST["levels"]);
    }
    if (empty($_POST["region"])) {
        $region = "";
    } else {
        $region = test_input($_POST["region"]);
    }

    if (empty($cons_error) && empty($capc_error)) {
        // Set session variables
        session_start();
        $_SESSION['cons'] = $cons;
        $_SESSION['capc'] = $capc;
        $_SESSION['levels'] = $levels;
        $_SESSION['region'] = $region;

        // Create the query string with the necessary parameters
        $query_string = http_build_query([
            'cons' => $cons,
            'capc' => $capc,
            'levels' => $levels,
            'region' => $region
        ]);

        // Use the header function to redirect to calc2.php with the query string
       

        // Determine which button was clicked
        if (isset($_POST['submit'])) {
             $redirect_url = "calc2.php?$query_string";
            echo "<script>window.location.href = '$redirect_url';</script>"; // Redirect to calc3.php
        } elseif (isset($_POST['simulate'])) {
            $redirect_url = "calc3.php?$query_string";
            echo "<script>window.location.href = '$redirect_url';</script>"; // Redirect to calc3.php
        }
        
        exit(); // Make sure to exit after redirection
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!-- multistep form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="msform">
  <h1 class="big-title">Your Power Calculator</h1>
  <!-- progressbar -->
  <ul id="progressbar">
      <li class="active">Your details</li>
      <li>Your preferences</li>
  </ul>
  <!-- fieldsets -->
  <fieldset>
      <h2 class="fs-title">Your details</h2>

      <label for="cons" class="fs-subtitle2">Your annual energy consumption:</label><br>
      <input required type="text" name="cons" placeholder="kWh" value="<?php echo $cons;?>" class="error-input"> 
      <span class="error"><?php echo $cons_error;?></span><br>

      <label for="capc" class="fs-subtitle2">Your roof capacity:</label><br>
      <input required type="text" name="capc" placeholder="m&sup2;" value="<?php echo $capc;?>" class="error-input" >
      <span class="error"><?php echo $capc_error;?></span><br>

      <input type="button" name="next" class="next action-button" value="Next" />
  </fieldset>
  <fieldset>
  <input type="button" name="previous" class="previous"  value="Previous" />
      <h2 class="fs-title">Your preferences</h2>
      
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
     
      <button type="submit" name="submit" class="next action-button" >Calculate</button>
      <button type="submit" name="simulate" class="next action-button" >Simulate</button>
  </fieldset>
</form>
</body>
</html>
