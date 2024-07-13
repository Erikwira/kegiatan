<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <style>
      body{
        background: #5800FF;
      }
      .container{
        height: 100vh;
      }
      .row{
        width: 650px;
        box-shadow: 7px 7px 15px rgba(0,0,0,0.3);
      }
      form{
        padding: 15px 35px;
        h2{
          margin: 10px 0 0;
          font-size: 3.0rem;
          font-weight: 700;
        }
        p{
          font-size: 1.2rem;
          font-weight: 500;
          opacity: 0.8;
        }
        .form-group{
          padding: 5px 0;
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
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 offset-md-4 form">
        <form action="forgot-password.php" method="POST" autocomplete="">
          <h2 class="text-center">Forgot Password</h2>
          <p class="text-center">Masukkan alamat email Anda</p>
          <?php
            /* if (count($errors) > 0) { 
          ?>
            <div class="alert alert-danger text-center" style="font-weight: 600;">
                <?php
                  foreach ($errors as $error) {
                    echo $error;
                  }
                ?>
              </div>
          <?php 
            } */
            $email = '';
          ?>
          <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Your email address" required value="<?php echo $email ?>">
          </div>
          <div class="form-group">
            <input class="form-control button" type="submit" name="check-email" value="Continue">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>