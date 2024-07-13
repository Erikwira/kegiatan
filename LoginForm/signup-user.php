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
        <!-- Kode php untuk menghubungkan form dengan database -->
        <?php
          $name = '';
          $email = '';
          $password = '';
        ?>

        <!--Data SignUp-->
        <?php
        if (isset($_POST['signup'])) {
          $name = $_POST['name'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $cpassword = $_POST['cpassword'];

          if ($name == "" && $email == "" && $password == "" && $cpassword == ""){
            $errors = "Semua Data Belum Diisi";
            ?>
            <div class="col-12 alert alert-danger text-center">
            <?php
              echo $errors;  
            ?>
            </div>
          <?php
          } else if ($name == ""){
            $errors = "Nama Belum Diisi";
            ?>
            <div class="col-12 alert alert-danger text-center">
            <?php
              echo $errors;  
            ?>
            </div>
        <?php
          } else if($email == "") {
            $errors = "Email Belum Diisi";
            ?>
            <div class="col-12 alert alert-danger text-center">
            <?php
              echo $errors;  
            ?>
            </div>
            <?php
          } else if ($password == ""){
            $errors = "Password Belum Diisi";
            ?>
            <div class="col-12 alert alert-danger text-center">
            <?php
              echo $errors;  
            ?>
            </div>
          <?php
          } else if ($cpassword == ""){
            $errors = "Konfimasi Password Belum Diisi";
            ?>
            <div class="col-12 alert alert-danger text-center">
            <?php
              echo $errors;  
            ?>
            </div>
          <?php
          } else {
            $query_check = mysqli_query($mysqli, "SELECT * FROM usertable WHERE name = '$name' OR email = '$email'");
            $mysqli_result = mysqli_num_rows($query_check); 
            if ($mysqli_result > 0) {
              $errors = "Nama dan Email sudah Digunakan";
              ?>
              <div class="col-12 alert alert-danger text-center">
              <?php
                echo $errors;  
              ?>
              </div>
          <?php
            } else {
              if($password == $cpassword){
                /* if(isset($_POST['id'])) { */
                $tambah = mysqli_query(
                  $mysqli, "INSERT INTO usertable (name,email,password) 
                  VALUES ( 
                    '" . $_POST['name'] . "',
                    '" . $_POST['email'] . "',
                    '" . $_POST['password'] . "'
                  )"    
                );
                if ($tambah) {
                  echo "<script>
                  alert('Signup berhasil!');
                  </script>";
                } else {
                  echo "<script>
                  alert('Signup gagal! Mohon coba lagi.');
                  </script>";
                }
              }
              /* } */ else {
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
        }
        ?>

        <div class="col-12">
          <label for="inputName" class="form-label fw-bold">
            Nama Lengkap
          </label>
          <input type="text" class="form-control" name="name" id="inputName" placeholder="Masukkan Nama Lengkap" value="">
        </div>
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
        <div class="col-12">
          <label for="inputCPassword" class="form-label fw-bold">
            Konfirmasi Password
          </label>
          <input type="password" class="form-control" name="cpassword" id="inputCPassword" placeholder="Masukkan Ulang Password Anda" value="">
        </div>
        <div class="col-12 tombol">
          <button type="submit" class="btn" name="signup">Sign Up</button>
        </div>
        <p class="text-center">Anda Sudah Daftar Silahkan Klik <span>Login</span></p>
      </form>
    </div>
  </div>
</body>
</html>