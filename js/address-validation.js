var textbox = document.getElementById("addresss");
  
// Get the notification element
var notification = document.getElementById("notification");
  
// Listen for keypress events on the textbox
textbox.addEventListener("keypress", function(event) {
  // Get the character code of the pressed key
  var charCode = event.charCode || event.keyCode;
    
  // Allow letters, spaces and enter
  if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || (charCode >= 48 && charCode <= 57) || charCode == 32 || charCode == 13 || charCode == 44 || charCode == 47 || charCode == 45 || charCode == 46) {
    notification.textContent = "";
  } else {
    // Prevent other characters and show notification
    event.preventDefault();
    notification.textContent = "Comma, hypen, and slash are only allowed symbols.";
  }
});


