var textbox = document.getElementById("search-issued");

// Get the notification element
var notification = document.getElementById("notification");

// Listen for keypress events on the textbox
textbox.addEventListener("keypress", function(event) {
  // Get the character code of the pressed key
  var charCode = event.charCode || event.keyCode;
    
  // Allow letters, numbers, spaces, backspace and enter
  if (charCode == 32 || charCode == 8 || charCode == 13 || (charCode >= 48 && charCode <= 57)) {
    notification.textContent = "";
  } else {
    // Prevent other characters and show notification
    event.preventDefault();
    notification.textContent = "Letters, and symbol are not allowed.";
  }
});
