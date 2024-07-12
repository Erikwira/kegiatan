<?php
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
      .navbar{
        position: fixed;
        width: 100%;
        padding: 10px 30px;
      }
      .row{
        margin: 0;
        .col{
          .btn{
            margin-top: 10px;
          }
        }
      }
      body{
        background: #F8F4E1;
      }
      .garis{
        border: 5px solid #AF8F6F;
        border-radius: 5px;
        opacity: 1;
      }
      
      .table{
        margin: 10px 0;
      }
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
          padding: 0 !important;
          margin: 5px 0 !important;
          .form-label{
            font-size: 20px;
            font-weight: 400;
          }
          .form-control{
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            font-weight: 400;
            box-shadow: 2px 2px 5px rgba(84, 51, 16, 0.25);
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
            background-color: #543310;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            padding: 7px 0;
            width: 100%;
          }
          .btn:hover{
            background-color: #F8F4E1;
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
            color: #543310;
            text-decoration: none;
          }
        }
      }
    </style>
    <title>Sign UP</title>   <!--Judul Halaman-->
</head>
<body>

  <div class="container d-flex justify-content-center align-items-center">
    <div class="card">
      <h3 class="text-center">
        Sign Up Form
        <br>
        <small>
          Mudah, Cepat, Dan Praktis.
        </small>
      </h3>

      <!--Form Input Sign Up-->
      <form class="form row signup" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <?php
        if(!empty($_SESSION['id'])){
          echo "<script>window.location.href='index.php';</script>";
          exit();
        }

        if(isset($_POST['signup'])){
          $username = $_POST['username'];
          $password = $_POST['password'];
          $cpassword = $_POST['cpassword'];

          $duplicate = mysqli_query($mysqli, "SELECT * FROM user WHERE username = '$username'");

          if(mysqli_num_rows($duplicate) > 0){
            $errors = "Username sudah Digunakan";
            ?>
            <div class="col-12 alert alert-danger text-center">
            <?php
              echo $errors;  
            ?>
            </div>
            <?php
          } else{
            if ($username == "" && $password == "" && $cpassword == ""){
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
            } else if($password == $cpassword){
              $hashed_password = password_hash($password, PASSWORD_DEFAULT);
              $query = "INSERT INTO user VALUES('','$username', '$hashed_password')";
              if(mysqli_query($mysqli, $query)){
                echo "<script>
                  alert('Signup berhasil! Silakan login.');
                  window.location.href='index.php';
                </script>";
              } else {
                echo "<script>
                  alert('Signup gagal! Mohon coba lagi.');
                </script>";
              }
            } else{
              $errors = "Password Tidak Sama";
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
        <div class="col-12">
          <label for="inputCPassword" class="form-label fw-bold">
            Konfirmasi Password
          </label>
          <input type="password" class="form-control" name="cpassword" id="inputCPassword" placeholder="Masukkan Ulang Password Anda" value="">
        </div>
        <div class="col-12 tombol">
          <button type="submit" class="btn" name="signup">Sign Up</button>
        </div>
        <p class="text-center">Anda Sudah Daftar Silahkan Klik <a href="index.php?page=loginUser">Login</a></p>
      </form>
    </div>
  </div>
</body>
</html>