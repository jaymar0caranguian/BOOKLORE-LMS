var textbox = document.getElementById("authorname");
  
// Get the notification element
var notification = document.getElementById("notification");
  
// Listen for keypress events on the textbox
textbox.addEventListener("keypress", function(event) {
  // Get the character code of the pressed key
  var charCode = event.charCode || event.keyCode;
    
  // Allow letters, spaces and enter
  if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32 || charCode == 13) {
    notification.textContent = "";
  } else {
    // Prevent other characters and show notification
    event.preventDefault();
    notification.textContent = "Numbers and symbols are not allowed.";
  }
});


