<?php
  //session_start();
  include_once("koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">
    <!-- Bootstrap offline -->
    <link rel="stylesheet" href="assets/css/bootstrap.css"> 
    <!-- Bootstrap Online -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">  --> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
      .container{
        height: 600px;
      }
      .card{
        width: 650px;
        box-shadow: 7px 7px 15px rgba(0,0,0,0.3);
      }
      h3{
        margin: 10px 0 0;
        font-size: 3.0rem;
        font-weight: 700;
        small{
          font-size: 1.2rem;
          font-weight: 500;
          opacity: 0.8;
        }
      }
      .form{
        padding: 15px 35px;
        .col-12{
          padding: 5px 0;
          .form-label{
            font-size: 16px;
            font-weight: 500;
          }
          .form-control{
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            font-weight: 500;
          }
          .form-control:hover{
            border: 1px solid rgba(0, 0, 0, 0.8);
          }
          .form-control:focus{
            box-shadow: 1px 2px 2px rgba(0, 150, 255, 0.4);
          }
        }
        .tombol{
          margin: 10px 0;
          .btn{
            background-color: #0096FF;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            padding: 7px 0;
            width: 100%;
          }
          .btn:hover{
            background-color: #72FFFF;
            color: #000;
          }
        }
        p{
          font-size: 16px;
          font-weight: 400;
          a{
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            color: #5800FF;
            text-decoration: none;
          }
        }
      }
    </style>
    <title>Log In</title>   <!--Judul Halaman-->
</head>
<body>

  <div class="container d-flex justify-content-center align-items-center">
    <div class="card">
      <h3 class="text-center">
        Log In Form
        <br>
        <small>
          Silahkan Masukkan Username Dan Password.
        </small>
      </h3>

      <!--Form Input Log In-->
      <form class="form row signup" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <?php
        if(!empty($_SESSION['id'])){
          echo "<script>window.location.href='index.php';</script>";
          exit();
        }

        if(isset($_POST['login'])){
          $username = $_POST['username'];
          $password = $_POST['password'];

          $result = mysqli_query($mysqli, "SELECT * FROM user WHERE username = '$username'");
          $row = mysqli_fetch_assoc($result);

          if(mysqli_num_rows($result) > 0){
            if(password_verify($password, $row['password'])){
              $_SESSION['login'] = true;
              $_SESSION['id'] = $row['id'];
              $_SESSION['reload_page'] = true;
              echo "<script>window.location.href='index.php';</script>";
              exit();
            } else {
              $errors = "Password Salah";
              ?>
              <div class="col-12 alert alert-danger text-center">
              <?php
                echo $errors;  
              ?>
              </div>
            <?php
            }
          } else{
            if ($username == "" && $password == ""){
              $errors = "Semua Data Belum Diisi";
              ?>
              <div class="col-12 alert alert-danger text-center">
              <?php
                echo $errors;  
              ?>
              </div>
            <?php
            } else if ($username == ""){
              $errors = "Username Belum Diisi";
              ?>
              <div class="col-12 alert alert-danger text-center">
              <?php
                echo $errors;  
              ?>
              </div>
              <?php
            } else{
              $errors = "Sepertinya Anda Belum Registrasi";
              ?>
              <div class="col-12 alert alert-danger text-center">
              <?php
                echo $errors;
              ?>
              </div>
              <?php
            }
          }
        }
        ?>

        <div class="col-12">
          <label for="inputUsername" class="form-label fw-bold">
            Username
          </label>
          <input type="text" class="form-control" name="username" id="inputUsername" placeholder="Masukkan Username" value="">
        </div>
        <div class="col-12">
          <label for="inputpass" class="form-label fw-bold">
            Password
          </label>
          <input type="password" class="form-control" name="password" id="inputPass" placeholder="Masukkan Password" value="">
        </div>
        <div class="col-12 tombol">
          <button type="submit" class="btn" name="login">Log In</button>
        </div>
        <p class="text-center">Anda Belum Daftar Silahkan Klik <a href="index.php?page=registrasiUser">Sign Up</a></p>
      </form>
    </div>
  </div>
</body>
</html>