const email = document.querySelector("#email");
const password = document.querySelector("#password");
const confirmPassword = document.querySelector("#confirmpassword");
const result = document.querySelector("p");
const submit = document.getElementById("submit");
const profileSubmit = document.getElementById("profile-btn");
const profile = document.getElementById("profilecard");
const fname = document.querySelector("#firstName");
const lname = document.querySelector("#lastName");
const dob = document.querySelector("#birthdayDate");
const phone = document.querySelector("#phoneNumber");
const place = document.querySelector("#place");

// Check if email exists in localStorage on page load
window.onload = function () {
  if (localStorage.getItem("email")) {
    window.location.assign("./profile.html");
  }
};

// Validate confirm password on input
confirmPassword.addEventListener("input", () => {
  if (password.value !== confirmPassword.value) {
    result.innerText = "Confirm password does not match";
    profile.classList.remove("d-none");
    profile.classList.add("d-block");
    submit.disabled = true;
  } else {
    result.innerText = "";
    submit.disabled = false;
  }
});

// Handle registration form submission
$("#register").submit(function (e) {
  e.preventDefault();
  const postData = {
    email: email.value,
    password: confirmPassword.value, // Note: Should be password.value, not confirmPassword.value
  };
  $.ajax({
    type: "POST",
    url: "./php/register.php",
    data: postData,
    encode: true,
  }).done(function (res) {
    if (res === "Registration Successful") {
      profile.classList.remove("d-none");
      profile.classList.add("d-block");
      $("#profileInfo").modal({ backdrop: "static", keyboard: false });
      $("#profileInfo").modal("show");
    } else {
      handleRegistrationError(res);
    }
  });
});

// Handle profile form submission
$("#profile").submit(function (e) {
  e.preventDefault();
  profileSubmit.disabled = true;
  const formData = {
    firstName: fname.value,
    lastName: lname.value,
    dob: dob.value,
    place: place.value,
    phoneNo: phone.value,
    email: email.value,
  };
  $.ajax({
    type: "POST",
    url: "./php/profile.php",
    data: formData,
    encode: true,
  }).done(function (res) {
    if (res === "success") {
      swal({
        title: "Success!",
        text: "Registered Successfully!",
        icon: "success",
        button: "OK",
      }).then(() => {
        window.location.assign("./login.html");
      });
    } else {
      handleProfileError(res);
    }
  });
});

// Function to handle registration errors
function handleRegistrationError(res) {
  let title, text, icon, buttonCallback;
  switch (res) {
    case "Registeration Failed":
      title = "Error";
      text = "Registration Failed!";
      icon = "info";
      buttonCallback = () => location.reload();
      break;
    case "email already exists":
      title = "Nope";
      text = "Email Already Exists!";
      icon = "warning";
      buttonCallback = () => window.location.assign("./login.html");
      break;
    case "oops error! try again":
      title = "Error";
      text = "Try Again!";
      icon = "error";
      buttonCallback = () => location.reload();
      break;
    default:
      return;
  }
  swal({
    title: title,
    text: text,
    icon: icon,
    button: "OK",
  }).then(buttonCallback);
}

// Function to handle profile submission errors
function handleProfileError(res) {
  swal({
    title: "Error",
    text: "Try Again!",
    icon: "error",
    button: "OK",
  }).then(() => {
    profileSubmit.disabled = false;
  });
}
