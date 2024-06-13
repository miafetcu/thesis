<?php
        include 'conn.php';
        $conn = OpenCon();

        $name = $email = $subject = $message = $file = "";
        $name_error = $email_error = $subject_error = $message_error = ""; 
        $form_success = false; // Initialize form_success

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (empty($_POST["Name"])) {
            $name_error = '*Name is required';
          } else {
            $name = test_input($_POST["Name"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
              $name_error = "*Only letters and white space allowed";
            }
          }

          if (empty($_POST["Email"])) {
            $email_error = '*Email is required';
          } else {
            $email = test_input($_POST["Email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $email_error = "*Invalid email format";
            }
          }

          if (empty($_POST["Subject"])) {
            $subject_error = '*Subject is required';
          } else {
            $subject = test_input($_POST["Subject"]);
          }

          if (empty($_POST["Message"])) {
            $message_error = '*Message is required';
          } else {
            $message = test_input($_POST["Message"]);
          }

          if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
            $file = basename($_FILES["pdf_file"]["name"]);
            $target_dir = "uploads/";
            $target_file = $target_dir . $file;
            move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file);
          }

          if ($name_error == "" && $email_error == "" && $subject_error == "" && $message_error == "") {
            $sql = "INSERT INTO contact (name, email, subject, message, file) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $email, $subject, $message, $file);

            if ($stmt->execute()) {
              $form_success = true;
            } else {
              echo "Error: " . $stmt->error;
            }
            $stmt->close();
          }
        }

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
        }

        CloseCon($conn);
    ?>

<!DOCTYPE html>
<html>
<head>
<title>Solar Calculator</title>
<script src="javascript/nav_bar.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style/style.css">
</head>
<body>

<!-- Navbar (sit on top) -->
<div id="content">Nav-Bar</div>
<!-- Contact Section -->
<div class="w3-container w3-light-grey" style="padding:100px 16px" id="contact">
    <h3 class="w3-center">CONTACT</h3>

    <?php if ($form_success): ?>
        <p class="w3-center w3-large" style="color: green;">Thank you for your message! <br>We appreciate your help!</p>
    <?php endif; ?>

    <p class="w3-center w3-large">Let's get in touch!<br> Send us a message</p>
    <div style="margin-top:48px">
      <form action="" method="post" enctype="multipart/form-data">
        <p><input class="w3-input w3-border" type="text" placeholder="Name" required name="Name"></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Email" required name="Email"></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Subject" required name="Subject"></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Message" required name="Message"></p>
        <p class="w3-large">Additionally, sent us bills for improvement.<br> </p><input type="file" name="pdf_file" accept=".pdf">
        <p>
          <button class="w3-button w3-black" type="submit" style="display: block; margin-left: auto; margin-right: auto; width: 20%;">
            <i class="fa fa-paper-plane"></i> SEND MESSAGE
          </button>
        </p>
      </form>
      <!-- Image of location/map -->
      <img src="assets/logor.png" class="w3-image-logo">
    </div>
</div>

</body>
</html>
