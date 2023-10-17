var passwordInput = document.getElementById("pword");
var notification = document.getElementById("notification");

passwordInput.addEventListener("input", function() {
  var password = passwordInput.value;
  var passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+_!@#$%^&*.,?]).{8,}$/;
  
  if (passwordRegex.test(password)) {
    notification.textContent = "";
  } else {
    notification.textContent = "Your password must be at least 8 characters long.";
  }
});
