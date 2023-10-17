var emailInput = document.getElementById("email");
var notification = document.getElementById("notification");

emailInput.addEventListener("input", function(event) {
  var email = emailInput.value.trim();
  if (isValidEmail(email)) {
    notification.textContent = "";
    emailInput.setCustomValidity("");
  } else {
    notification.textContent = "Please enter a valid email address.";
    emailInput.setCustomValidity("Invalid email address");
  }
});

function isValidEmail(email) {
  // Define a regular expression to validate email address format
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}
