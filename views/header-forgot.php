<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password</title>
    <link rel="icon" type="image/x-icon" href="../img/logo/logo-alt.png" />
    <!-- Link ke file CSS Bootstrap -->
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
      body {
        background-image: url("../img/hero-section.jpg");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh;
        margin: 0;
        box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.45);
      }

      .logo-container {
        text-align: center;
        margin-top: -20px;
        margin-bottom: -180px;
      }

      .logo-container img {
        width: 190px;
        height: auto;
        padding: 10px;
      }

      .forgot-password-container {
        width: auto;
        margin: 150px auto 30px;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(2px);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      }

      .forgot-password-container h2 {
        text-align: center;
        color: #302c24;
        margin-bottom: 30px;
      }

      .forgot-password-container .btn-primary {
        background-color: #4d3835;
        border-color: #4d3835;
      }

      .forgot-password-container .btn-primary:hover {
        background-color: #302c24;
        border-color: #302c24;
      }

      .forgot-password-container .form-control {
        background-color: #dcd1d6;
        border: 1px solid #564a4b;
        color: #302c24;
      }

      .forgot-password-container .form-control:focus {
        border-color: #4d3835;
        box-shadow: 0 0 5px rgba(77, 56, 53, 0.5);
      }

      .back-to-login {
        text-align: center;
        margin-top: 20px;
      }

      .back-to-login a {
        color: #4d3835;
        text-decoration: none;
      }

      .back-to-login a:hover {
        text-decoration: underline;
      }

      .alert { margin-bottom: 20px; }

      .alert ul {
    margin-bottom: 0;
    padding-left: 20px;
}

    .password-criteria {
    background: rgba(255,255,255,0.8);
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
    border-left: 4px solid #4d3835;
}

.password-criteria ul {
    margin-bottom: 0;
    padding-left: 20px;
}

.password-criteria li {
    font-size: 0.9em;
    color: #4d3835;
    list-style-type: circle;
    margin-bottom: 5px;
}

.bi-eye-slash, .bi-eye {
    transition: all 0.3s ease;
}
.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 2;
}
.input-group {
    position: relative;
}
    </style>
  </head>
