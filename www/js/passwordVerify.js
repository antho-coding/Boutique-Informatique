//Verification du mot de passe
function checkPassword() {
  let password = $("#password").val();
  let confirmPassword = $("#confirm-password").val();

  if (password != 0 && confirmPassword != 0) {
    if (password != confirmPassword) {
      $("#check-password").html("Merci de saisir le même mot de passe !").css("color", "red");
    } else {
      $("#check-password").html("Mot de de passe identique !").css("color", "green");
    }
  } else {
    $("#check-password").empty();
  }
}

//On stop la soumission du formulaire si un des 2 critéres n'est pas remplie
function stopEvent(e) {
  let password = $("#password").val();
  let confirmPassword = $("#confirm-password").val();
  // 8 caractére min, 1maj, 1caractére special, 1chiffre
  let masquePassword = /^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/;

  if (password != confirmPassword || masquePassword.test(password) == false) {
    e.preventDefault();
    confirm("Merci de verifier les champs du formulaire");
  }
}

//verifie l'égalité avec la regex
function checkRegex() {
  let password = $("#password").val();
  // 8 caractére min, 1maj, 1caractére special, 1chiffre
  let masquePassword = /^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$/;

  if (password != 0) {
    if (masquePassword.test(password)) {
      $("#security-password").html("Le mot de passe securisé !").css("color", "green");
    } else {
      $("#security-password").html("Le mot de passe doit respecté: 8 caractéres dont 1 chiffre, un caractére special et une majuscule").css("color", "red");
    }
  } else {
    $("#security-password").empty();
  }
}

//DOM content Load
document.addEventListener("DOMContentLoaded", function () {
  $("#btn-submit-form").on("click", stopEvent);
  $("#confirm-password").on("keyup", checkPassword);
  $("#password").on("keyup", checkRegex);
});
