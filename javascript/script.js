$(document).ready(function() {
  $(".next").click(function(){
      var current_fs = $(this).parent();
      var next_fs = $(this).parent().next();

      // Activate next step on progressbar using the index of next_fs
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      // Trigger validation for the current fieldset
      var isValid = validateFields(current_fs);

      // If the fields are valid, proceed to the next fieldset
      if (isValid) {
          // Show the next fieldset
          next_fs.show(); 
          // Hide the current fieldset
          current_fs.hide();
      }
  });

  $(".previous").click(function(){
      var current_fs = $(this).parent();
      var previous_fs = $(this).parent().prev();

      // De-activate current step on progressbar using the index of current_fs
      $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

      // Show the previous fieldset
      previous_fs.show(); 
      // Hide the current fieldset
      current_fs.hide();
  });


 // Function to validate fields
function validateFields(fieldset) {
  var isValid = true;

  // Find all input fields within the fieldset
  var inputs = fieldset.find("input[type='text']");
  
  // Loop through each input field and check if it's empty or not a number
  inputs.each(function() {
      if ($(this).val() === "") {
          isValid = false;
          $(this).addClass("error-input");
          $(this).attr("placeholder", "This field is required.");
      } else if (!$.isNumeric($(this).val())) {
          isValid = false;
          $(this).addClass("error-input");
          $(this).val("");
          $(this).attr("placeholder", "Please enter a valid number.");
      } else {
          $(this).removeClass("error-input");
          $(this).attr("placeholder", ""); // Clear placeholder if no error
      }
  });

  return isValid;
}

});

    // Update panels value and energy generated based on slider input
    $(document).ready(function() {
        $('#investmentRange').on('input', function() {
            var investmentValue = $(this).val();
            const pricepanel =400;
            $('#investmentValue').text(investmentValue * pricepanel); // Each panel costs $400
        });

        $('#panelsValue').text($('#investmentRange').val()); // Initial panels value

        $('#investmentRange').on('input', function() {
            $('#panelsValue').text($(this).val()); // Update panels value
        });

        $('#investmentRange').on('input', function() {
            var panels = $(this).val();
            var energyGenerated = panels * 0.5; // Each panel generates 0.5 kWh/year
            $('#energyValue').text(energyGenerated);
            $('#savingsValue').text(energyGenerated * 2.5 * 1000); // Estimated savings calculation
        });
    });

//info icon 
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}

  function togglePopup(popupId) {
    var popup = document.getElementById(popupId);
    if (popup.style.visibility === "visible") {
      popup.style.visibility = "hidden";
    } else {
      popup.style.visibility = "visible";
    }
  } 
