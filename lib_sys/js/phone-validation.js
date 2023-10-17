var textbox = document.getElementById("phone");

// Get the notification element
var notification = document.getElementById("notification");

// Listen for keypress events on the textbox
textbox.addEventListener("keypress", function(event) {
  // Get the character code of the pressed key
  var charCode = event.charCode || event.keyCode;

  // Allow numbers, spaces, slash, number and enter
  if ((charCode >= 48 && charCode <= 57) || charCode == 13) {
    // Check if the phone number has reached 11 digits
    if (textbox.value.length === 11 && charCode >= 48 && charCode <= 57) {
      event.preventDefault();
      notification.textContent = "Only 11 digits are allowed.";
    } else {
      notification.textContent = "";
    }
  } else {
    // Prevent other characters and show notification
    event.preventDefault();
    notification.textContent = "Symbols, letters are not allowed.";
  }
});
