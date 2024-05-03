<?php
  session_start();
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
      body{
        background: #5800FF;
      }
      .container{
        height: 100vh;
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
          span{
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            color: #5800FF;
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
        Login Form
        <br>
        <small>
          Silahkan Masukkan Email dan Password Anda.
        </small>
      </h3>

      <!--Form Input Sign Up-->
      <form class="form row signup" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
          $email = '';
          $password = '';
        ?>

        <!--Data Login-->
        <?php
        if (isset($_POST['login'])) {
          $email = $_POST['email'];
          $password = $_POST['password'];
          $query_check = mysqli_query($mysqli, "SELECT * FROM usertable WHERE email = '$email'");
          $row = mysqli_fetch_assoc($query_check);
          
          if (mysqli_num_rows($query_check) > 0) {
            if($password == $row['password']){
              $_SESSION['login'] = true;
              $_SESSION['id'] = $row['id'];
              header('Location: index.php');
            } else{
            $errors = "Password Salah";
            ?>
            <div class="col-12 alert alert-danger text-center">
            <?php
              echo $errors;  
            ?>
            </div>
        <?php
            }
          } else if ($email == "" && $password == ""){
            $errors = "Email Dan Password Belum Diisi";
            ?>
            <div class="col-12 alert alert-danger text-center">
            <?php
              echo $errors;  
            ?>
            </div>
          <?php
          }
        }
        ?>

        <div class="col-12">
          <label for="inputEmail" class="form-label fw-bold">
            Email
          </label>
          <input type="text" class="form-control" name="email" id="inputEmail" placeholder="Masukkan Alamat Email" value="">
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
        <p class="text-center">Anda Belum Daftar Silahkan Klik <span>Sign Up</span></p>
      </form>
    </div>
  </div>
</body>
</html>