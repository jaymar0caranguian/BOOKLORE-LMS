var textbox = document.getElementById("isbn");
  
// Get the notification element
var notification = document.getElementById("notification");
  
// Listen for keypress events on the textbox
textbox.addEventListener("keypress", function(event) {
  // Get the character code of the pressed key
  var charCode = event.charCode || event.keyCode;
    
  // Allow numbers, spaces, slash, number and enter
  if ((charCode >= 48 && charCode <= 57) || charCode == 13 || charCode == 45) {
    notification.textContent = "";
  } else {
    // Prevent other characters and show notification
    event.preventDefault();
    notification.textContent = "Symbols and letters are not allowed except for hypen.";
  }
});