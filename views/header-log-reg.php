<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Login & Register</title>
    <link rel="icon" type="image/x-icon" href="img/logo/logo-alt.png" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      rel="stylesheet"
    />
<!-- Di dalam <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

<!-- Pastikan jQuery dimuat sebelum iziToast jika menggunakan fitur tertentu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

      * {
        box-sizing: border-box;
      }
      html, body {
        height: 100%;
        margin: 0;
        box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.60); /* Pastikan bayangan mencakup seluruh area */
        overflow: visible; /* Mencegah halaman di-scroll */
        position: static; /* Tambahkan ini */
        width: 100%; /* Tambahkan ini untuk memastikan cakupan penuh */
    }
      body, .main-wrapper {
        background: url('img/background.jpg') no-repeat center center/cover;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: "Poppins", sans-serif;
        height: 100vh;
        margin: 0;
      }
          h1 {
        font-weight: bold;
        margin: 0;
      }
      h2 {
        text-align: center;
      }
      p {
        font-size: 14px;
        font-weight: 100;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
      }
      span {
        font-size: 12px;
      }
      a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
      }
      button {
        border-radius: 20px;
        border: 1px solid #cc5134;
        background-color: #cc5134;
        color: #ffffff;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
      }
      button:active {
        transform: scale(0.95);
      }
      button:focus {
        outline: none;
      }
      button.ghost {
        background-color: transparent;
        border-color: #ffffff;
      }
      form {
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
      }
      input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
      }
      .container {
        background-color: #fff;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
      }
      .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
      }
      .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
      }
      .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
      }
      .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
      }
      .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
      }
      
      .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
      }
      .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
      }
      .overlay {
        background: #a2624d;
        background: -webkit-linear-gradient(to right, #D4145A, #d6901e);
        background: linear-gradient(to right, #D4145A, #d6901e);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #ffffff;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
      }
      .container.right-panel-active .overlay {
        transform: translateX(50%);
      }
      .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
      }
      .overlay-left {
        transform: translateX(-20%);
      }
      .container.right-panel-active .overlay-left {
        transform: translateX(0);
      }
      .overlay-right {
        right: 0;
        transform: translateX(0);
      }
      .container.right-panel-active .overlay-right {
        transform: translateX(20%);
      }
      .social-container {
        margin: 20px 0;
      }
      .social-container a {
        border: 1px solid #dddddd;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        height: 40px;
        width: 40px;
      }
      .btn-gmail {
    border-radius: 20px;
    border: 1px solid #ff4b2b;
    background: linear-gradient(45deg, #ff4b2b, #ff416c);
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in, box-shadow 0.3s ease;
    text-align: center;
}
.btn-gmail:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 15px rgba(255, 75, 43, 0.3);
    background: linear-gradient(45deg, #ff416c, #ff4b2b);
}
.btn-gmail:active {
    transform: scale(0.95);
    box-shadow: none;
}
.password-container {
      position: relative;
      display: inline-block;
    }
    .password-container input {
      padding-right: 100px; /* Memberikan ruang untuk ikon */
    }
    .password-container .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #999;
    }
    .password-container .toggle-password:hover {
      color: #000;
    }
    .iziToast.iziToast-color-info {
    background: #2ecc71;
}
    </style>
  </head>
  <body>
    <div style="position: absolute; top: 20px; left: 30px;">
  <a href="index.php" style="
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: #333;">
    <i class="fas fa-arrow-left"></i>
  </a>
</div>

</div>