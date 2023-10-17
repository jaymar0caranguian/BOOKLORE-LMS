var textbox = document.getElementById("search-info");

// Get the notification element
var notification = document.getElementById("notification");

// Listen for keypress events on the textbox
textbox.addEventListener("keypress", function(event) {
  // Get the character code of the pressed key
  var charCode = event.charCode || event.keyCode;
    
  // Allow letters, numbers, spaces, backspace and enter
  if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32 || charCode == 8 || charCode == 13 || (charCode >= 48 && charCode <= 57)) {
    notification.textContent = "";
  } else {
    // Prevent other characters and show notification
    event.preventDefault();
    notification.textContent = "Symbols are not allowed.";
  }
});
