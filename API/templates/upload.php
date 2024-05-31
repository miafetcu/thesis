<!DOCTYPE html>
<html>
<head>
<title>Solar Calculator</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/script.js"></script>
<script src="/nav_bar.js"></script>
<script src="/return_form.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="/style.css">
<link rel="stylesheet" href="/style2.css">
</head>
<body><!-- About Section -->
<div id="content">Nav-Bar</div>
<!-- multistep form -->
<form action="http://localhost:8887/api/mia" method="post" enctype="multipart/form-data" id="msform">
  <h1 class="big-title">Your Automated Calculator</h1>
 
  <!-- fieldsets -->
  <fieldset>
      <h2 class="fs-title">Your details</h2>
      <input type="file" name="pdf_file" id="triggerButton" accept=".pdf"> <br>
      <label for="capc" class="fs-subtitle2">Your roof capacity:</label><br>
      <input required type="text" id="capc" name="capc" placeholder="m&sup2;" value="<?php echo $capc;?>" class="error-input" >
      <span class="error"><?php echo $capc_error;?></span><br>

      


        
  <button  id="triggerButton2" type="submit">Upload</button> 
  
  </fieldset>
 
</form>
</body>
</html>
