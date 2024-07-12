<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">
    <!-- Bootstrap offline -->
    <link rel="stylesheet" href="assets/css/bootstrap.css"> 
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Poliklinik Sekawan</title>   <!--Judul Halaman-->
    <style>
      .navbar{
        position: fixed;
        width: 100%;
        padding: 10px 30px;
      }
      .navbar, .container-fluid{
        background-color: #543310;
      }
      .container-fluid{
        .navbar-brand{
          color: #fff;
          font-size: 22px;
          font-weight: 500;
        }
        .collapse{
          .navbar-nav{
            .nav-item{
              margin-right: 5px;
              a{
                color: #fff;
                font-size: 16px;
                font-weight: 500;
                border-radius: 10px;
              }
              a:hover{
                background-color: #fff;
                color: #543310;
              }
              .dropdown-menu{
                border: 1px solid #543310;
                top: 55px;
                padding: 5px;
                li{
                  .dropdown-item{
                    color: #543310;
                    font-size: 16px;
                    font-weight: 500;
                    border-radius: 4px;
                  }
                  .dropdown-item:hover{
                    background-color: #543310;
                    color: #fff;
                  }
                }
              }
              .dropdown-menu.show{
                padding: 10px;
              }
            }
          }
        }
        .navbar-toggler{
          background-color: #543310;
          border: 4px solid #fff;
          border-radius: 5px;
        }
        .navbar-toggler:focus{
          box-shadow: 0 0 0 .25rem #fff;
        }
        .show{
          padding: 10px 0;
          .navbar-nav{
            .nav-item{
              a{
                padding: 5px 10px;
                margin: 2px;
              }
            }
          }
        }
      }
      body{
        background: #F8F4E1;
        .container{
          width: 100%;
          height: 100vh;
        }
        .konten{
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          .isi{
            font-size: 32px;
            font-weight: 500;
          }
          .isi-konten{
            font-size: 20px;
            font-weight: 400;
          }
        }
        .container-page {
          height: 100%;
        }

        .konten-page {
          display: block;
          padding-top: 70px;
          .isi{
            padding: 0 0 0 110px;
            font-size: 48px;
            font-weight: 700;
          }
        }
      }
    </style>
</head>
<body>
  <?php
    session_start();
    include_once("koneksi.php");
  ?>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        Poliklinik Sekawan
      </a>
      <button class="navbar-toggler"
        type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false"
        aria-label="Toggle navigation">
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">
              Home
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button"
              id="navbarDropdownMenuLink"
              data-bs-toggle="dropdown" aria-expanded="false">
              Data Master
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li>
                <a class="dropdown-item" href="index.php?page=dokter">
                  Dokter
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php?page=pasien">
                  Pasien
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="index.php?page=obat">
                  Obat
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" 
              href="index.php?page=periksa">
              Periksa
            </a>
          </li>
        </ul>
        <ul class="navbar-nav justify-content-end">
          <?php if (isset($_SESSION['id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
          <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=registrasiUser">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=loginUser">Login</a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <main role="main" class="<?php echo isset($_GET['page']) ? 'container-page' : 'container'; ?> <?php echo isset($_GET['page']) ? 'konten-page' : 'konten'; ?>">
    <?php
      if (isset($_GET['page'])) {
    ?>
        <h2 class="isi"><?php echo ucwords($_GET['page']) ?></h2>
    <?php
        include($_GET['page'] . ".php");
      } else {
        ?>
        <h2 class="isi">Selamat Datang di Poliklinik Sekawan</h2>
        <p class="isi-konten">Website Sistem Informasi Poliklinik</p>
        <p class="isi-konten">Melayani Dengan Nyaman, Aman Dan Sopan</p>
        <?php
      }
    ?>
  </main>
</body>
</html>