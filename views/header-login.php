<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin/Kasir Login</title>
    <link rel="icon" type="image/x-icon" href="../img/logo/logo-alt.png" />
    <!-- Link ke file CSS Bootstrap -->
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <!-- SweetAlert2 CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"
      rel="stylesheet"
    />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

      /* Background Image */
      body {
        font-family: "Poppins", sans-serif;
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
        margin-bottom: -120px;
      }

      .logo-container img {
        width: 190px;
        height: auto;
        padding: 10px;
      }

      /* Kontainer Login */
      .login-container {
        width: auto;
        height: fit-content;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(2px);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
      }

      /* Judul Form Login */
      .login-container h2 {
        text-align: center;
        color: #302c24;
        margin-bottom: 30px;
      }

      /* Gaya untuk Logo */
      .logo {
        display: block;
        margin: 0 auto 20px;
        width: 100px;
      }

      /* Tombol Login */
      .login-container .btn-primary {
        background-color: #4d3835;
        border-color: #4d3835;
      }

      /* Tombol Hover untuk Login */
      .login-container .btn-primary:hover {
        background-color: #302c24;
        border-color: #302c24;
      }

      /* Gaya untuk Input Field */
      .login-container .form-control {
        background-color: #dcd1d6;
        border: 1px solid #564a4b;
        color: #302c24;
      }

      .login-container .form-control:focus {
        border-color: #4d3835;
        box-shadow: 0 0 5px rgba(77, 56, 53, 0.5);
      }

      /* Remember Me dan Forgot Password */
      .remember-forgot {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
      }

      .remember-forgot a {
        color: #4d3835;
        text-decoration: none;
      }

      .remember-forgot a:hover {
        text-decoration: underline;
      }

      /* Register Link */
      .register-link {
        text-align: center;
        margin-top: 20px;
      }

      .register-link a {
        color: #4d3835;
        text-decoration: none;
      }

      .register-link a:hover {
        text-decoration: underline;
      }

      .login-container select.form-control {
            background-color: #dcd1d6;
            border: 1px solid #564a4b;
            color: #302c24;
            appearance: auto; /* Override appearance untuk browser tertentu */
        }

        .alert {
        animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
  </head>