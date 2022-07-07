// global functions
function request(url, data, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  var loader = document.createElement("div");
  loader.className = "loader";
  document.body.appendChild(loader);
  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === 4) {
      if (callback) {
        callback(xhr.response);
      }
      loader.remove();
    }
  });

  var formdata = data
    ? data instanceof FormData
      ? data
      : new FormData(document.querySelector(data))
    : new FormData();

  var csrfMetaTag = document.querySelector('meta[name="csrf_token"]');
  if (csrfMetaTag) {
    formdata.append("csrf_token", csrfMetaTag.getAttribute("content"));
  }

  xhr.send(formdata);
}

// index.php
function logout() {
  request("php/logout.php", false, function (data) {
    if (data === "0") {
      window.location = "login.php";
    }
  });
}

function deleteAccount() {
  request("php/deleteAccount.php", false, function (data) {
    document.getElementById("errs").innerHTML = "";
    var transition = document.getElementById("errs").style.transition;
    document.getElementById("errs").style.transition = "none";
    document.getElementById("errs").style.opacity = 0;
    switch (data) {
      case "0":
        window.location = "register";
        break;
      case "1":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Error en borrar cuenta. Favor de intentar de nuevo.</div>';
        break;
      case "2":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Error en conexión con Base de Datos. Favor intenta de nuevo.</div>';
        break;
      case "3":
        document.getElementById("errs").innerHTML +=
          '<div class="err">No estas autentificado.</div>';
        break;
      case "4":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Invalid CSRF Token... Nice try</div>';
        break;
      default:
        document.getElementById("errs").innerHTML +=
          '<div class="err">Un erro ocurrió. Favor de intentar de nuevo.</div>';
    }
    setTimeout(function () {
      document.getElementById("errs").style.transition = transition;
      document.getElementById("errs").style.opacity = 1;
    }, 10);
  });
}

// login.php
function login() {
  request("php/login.php", "#loginForm", function (data) {
    document.getElementById("errs").innerHTML = "";
    var transition = document.getElementById("errs").style.transition;
    document.getElementById("errs").style.transition = "none";
    document.getElementById("errs").style.opacity = 0;
    switch (data) {
      case "0":
        window.location = "./";
        break;
      case "1":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Usuario / Password incorrecto</div>';
        break;
      case "2":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Error en conectarse a la base de datos. Favor de intentar de nuevo.</div>';
        break;
      case "3":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Ha exedido el número de intentos. Favor de intentar en una hora.</div>';
        break;
      case "4":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Tu cuenta aún no ha sido validada. Estámos corroborando tu identidad.</div>';
        break;
      default:
        document.getElementById("errs").innerHTML +=
          '<div class="err">Un error desconocido ha sucedido. Favor de intentar de nuevo.</div>';
    }
    setTimeout(function () {
      document.getElementById("errs").style.transition = transition;
      document.getElementById("errs").style.opacity = 1;
    }, 10);
  });
}

// register.php
function register() {
  request("php/register.php", "#registerForm", function (data) {
    document.getElementById("errs").innerHTML = "";
    var transition = document.getElementById("errs").style.transition;
    document.getElementById("errs").style.transition = "none";
    document.getElementById("errs").style.opacity = 0;
    try {
      data = JSON.parse(data);
      if (!(data instanceof Array)) {
        throw Exception("bad data");
      }

      //Show errors to user
      for (var i = 0; i < data.length; ++i) {
        switch (data[i]) {
          case 0:
            document.getElementById("errs").innerHTML +=
              "<div>¡Tu cuenta ha sido creada!</div><div>Favor de validarla a través del correo electrónico que te hemos enviado.</div>";
            document.getElementById("registerForm").reset();
            break;
          case 1:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Nombre inválido. (solo usa letras, espacios y guiones)</div>';
            break;
          case 2:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Correo electrónico inválido.</div>';
            break;
          case 3:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Correo electónico no existe. (O el dominio no tiene servidor de correos)</div>';
            break;
          case 4:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Password debe contener: <ul><li>Al menos 8 caracteres</li><li>Al menos un caracter minúscula</li><li>Al menos un caracter mayúscula</li><li>Al menos un número/li><li>Al menos un caracter especial(~?!@#$%^&*)</li></ul></div>';
            break;
          case 5:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Passwords no son iguales.</div>';
            break;
          case 6:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Error en almacenar en la base de datos.</div>';
            break;
          case 7:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Este correo electrónico ya existe</div>';
            break;
          case 8:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Error en conexión con la Base de Datos.</div>';
            break;
          case 9:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Invalid CSRF Token. Please try again later.</div>';
            break;
          case 10:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Hemos recibido tu solicitud de usuario, verificaremos tu identidad y enviaremos un correo de confirmación, gracias.</div>';
            break;
          case 11:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Error en solicitar información en la BD.</div>';
            break;
          case 12:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Ha exedido el número de consultas</div>';
            break;
          case 13:
            document.getElementById("errs").innerHTML +=
              '<div class="err">El usuario ya ha sido validado.</div>';
            break;
          case 14:
            document.getElementById("errs").innerHTML +=
              '<div class="err">El usuario con este correo no existe.</div>';
            break;
          case 15:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Error en conectarse en la BD.</div>';
            break;
          default:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Un error un desconocido ha sucedido.</div>';
        }
      }
    } catch (e) {
      document.getElementById("errs").innerHTML =
        '<div class="err">Un error un desconocido ha sucedido.</div>';
    }
    setTimeout(function () {
      document.getElementById("errs").style.transition = transition;
      document.getElementById("errs").style.opacity = 1;
    }, 10);
  });
}

// validateEmail.php
function sendValidateEmailRequest() {
  request("php/sendValidationEmail.php", "#validateEmailForm", function (data) {
    document.getElementById("errs").innerHTML = "";
    var transition = document.getElementById("errs").style.transition;
    document.getElementById("errs").style.transition = "none";
    document.getElementById("errs").style.opacity = 0;

    switch (data) {
      case "0":
        document.getElementById("errs").innerHTML +=
          "<div>Email enviado... verifica tu correo para validar usuario.</div>";
        document.getElementById("validateEmailForm").reset();
        break;
      case "1":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Error en enviar el mail.</div>';
        break;
      case "2":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Error en insertar en la base de datos.</div>';
        break;
      case "3":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Ha excedido el número de intentos.</div>';
        break;
      case "4":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Este correo ya esta validado</div>';
        break;
      case "5":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Este correo ya existe</div>';
        break;
      case "6":
        document.getElementById("errs").innerHTML +=
          '<div class="err">Error en concectarse con la BD.</div>';
        break;
      default:
        document.getElementById("errs").innerHTML +=
          '<div class="err">Error desconcido.</div>';
    }
    setTimeout(function () {
      document.getElementById("errs").style.transition = transition;
      document.getElementById("errs").style.opacity = 1;
    }, 10);
  });
}

// resetPassword.php
function passwordResetRequest() {
  request(
    "php/passwordResetRequest.php",
    "#resetPasswordForm",
    function (data) {
      document.getElementById("errs").innerHTML = "";
      var transition = document.getElementById("errs").style.transition;
      document.getElementById("errs").style.transition = "none";
      document.getElementById("errs").style.opacity = 0;

      switch (data) {
        case "0":
          document.getElementById("errs").innerHTML +=
            "<div>Enviamos un correo si la cuenta existe</div>";
          document.getElementById("resetPasswordForm").reset();
          break;
        case "1":
          document.getElementById("errs").innerHTML +=
            '<div class="err">Error enviar el mail.</div>';
          break;
        case "2":
          document.getElementById("errs").innerHTML +=
            '<div class="err">Error al ingresar en la BD</div>';
          break;
        case "3":
          document.getElementById("errs").innerHTML +=
            '<div class="err">Ha excedido el número de intentos el día de hoy.</div>';
          break;
        case "4":
          document.getElementById("errs").innerHTML +=
            '<div class="err">Failed to connect to database. Please try again later.</div>';
          break;
        case "5":
          document.getElementById("errs").innerHTML +=
            '<div class="err">Invalid CSRF token</div>';
          break;
        case "6":
          document.getElementById("errs").innerHTML +=
            '<div class="err">You must enter an email</div>';
          break;
        default:
          document.getElementById("errs").innerHTML +=
            '<div class="err">An unknown error occurred. Please try again later.</div>';
      }
      setTimeout(function () {
        document.getElementById("errs").style.transition = transition;
        document.getElementById("errs").style.opacity = 1;
      }, 10);
    }
  );
}
function changePassword() {
  request("php/changePassword.php", "#changePasswordForm", function (data) {
    document.getElementById("errs").innerHTML = "";
    var transition = document.getElementById("errs").style.transition;
    document.getElementById("errs").style.transition = "none";
    document.getElementById("errs").style.opacity = 0;
    try {
      data = JSON.parse(data);
      if (!(data instanceof Array)) {
        throw Exception("bad data");
      }

      //Show errors to user
      for (var i = 0; i < data.length; ++i) {
        switch (data[i]) {
          case 0:
            document.getElementById("errs").innerHTML +=
              '<div>Tú contraseña ha sido reiniciada! Puedes <a href="./login">acceder</a></div>';
            document.getElementById("changePasswordForm").reset();
            break;
          case 1:
          case 2:
          case 7:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Invalidado. If this is a mistake send a new request and click the link in the email.</div>';
            break;
          case 3:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Password must contain: <ul><li>At least 8 characters</li><li>At least one lower case letter</li><li>At least one upper case letter</li><li>At least one number</li><li>At least one special character (~?!@#$%^&*)</li></ul></div>';
            break;
          case 4:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Passwords do not match. Please re-enter your confirmed password.</div>';
            break;
          case 5:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Failed to update password in the database. Please try again later.</div>';
            break;
          case 6:
            document.getElementById("errs").innerHTML +=
              '<div class="err">This password reset request has expired. Please send another email.</div>';
            break;
          case 8:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Failed to connect to the database. Please try again later.</div>';
            break;
          case 9:
            document.getElementById("errs").innerHTML +=
              '<div class="err">Invalid CSRF Token. Please try again later.</div>';
            break;
          default:
            document.getElementById("errs").innerHTML +=
              '<div class="err">An unknown error occurred. Please try again later.</div>';
        }
      }
    } catch (e) {
      document.getElementById("errs").innerHTML =
        '<div class="err">An unknown error occurred. Please try again later.</div>';
    }
    setTimeout(function () {
      document.getElementById("errs").style.transition = transition;
      document.getElementById("errs").style.opacity = 1;
    }, 10);
  });
}
