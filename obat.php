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
    <title>Para Pasien</title><!--Judul Halaman-->
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
      .form{
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
        }
        .col{
          .btn{
            background: #543310;
            border: none;
            font-size: 18px;
            font-weight: 400;
          }
          .btn:hover{
            background: #fff;
            color: #543310;
            box-shadow: 2px 2px 5px rgba(84, 51, 16, 0.4);
          }
        }
      }
      .table{
        margin: 10px 0;
      }
    </style>
</head>
<body>
  <?php
    include_once("koneksi.php");
  ?>

  <div class="container">
    <h3>
      Obat
      <br>
      <small class="text-muted">
        Data Obat Tercatat Disini.
      </small>
    </h3>
    <hr class="garis">

    <!--Form Input Data Dokter-->
    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
      <!-- Kode php untuk menghubungkan form dengan database -->
      <?php
        $nama_obat = '';
        $kemasan = '';
        $harga = '';
        if (isset($_GET['id'])) {
          $ambil = mysqli_query(
            $mysqli, 
            "SELECT * FROM obat 
            WHERE id='" . $_GET['id'] . "'"
          );
          while ($row = mysqli_fetch_array($ambil)) {
            $nama_obat = $row['nama_obat'];
            $kemasan = $row['kemasan'];
            $harga = $row['harga'];
          }
      ?>
        <input type="hidden" name="id" value="<?php echo
        $_GET['id'] ?>">
      <?php
        }
      ?>
      <div class="col-12">
        <label for="inputNamaObat" class="form-label">
          Nama Obat
        </label>
        <input type="text" class="form-control" name="nama_obat" id="inputNamaObat" placeholder="Masukkan Nama Obat" value="<?php echo $nama_obat ?>">
      </div>
      <div class="col-12">
        <label for="inputKemasan" class="form-label">
          Kemasan
        </label>
        <input type="text" class="form-control" name="kemasan" id="inputKemasan" placeholder="Masukkan Nama Kemasan" value="<?php echo $kemasan ?>">
      </div>
      <div class="col-12">
        <label for="inputHarga" class="form-label">
          Harga
        </label>
        <input type="number" class="form-control" name="harga" id="inputHarga" placeholder="Masukkan Harga Obat" value="<?php echo $harga ?>">
      </div>
      <div class="col">
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
      </div>
    </form>

    <!--Tabel Data Obat-->
    <table class="table table-hover">
      <!--thead atau baris judul-->
      <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Obat</th>
            <th scope="col">Kemasan</th>
            <th scope="col">Harga</th>
            <th scope="col">Aksi</th>
        </tr>
      </thead>
    <?php
      $result = mysqli_query($mysqli, "SELECT * FROM obat");
      $no = 1;
      while ($data = mysqli_fetch_array($result)) {
    ?>
      <tr>
        <td><?php echo $no++ ?></td>
        <td><?php echo $data['nama_obat'] ?></td>
        <td><?php echo $data['kemasan'] ?></td>
        <td><?php echo $data['harga'] ?></td>
        <td>
          <a class="btn btn-success rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>">Ubah</a>
          <a class="btn btn-danger rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
        </td>
      </tr>
      <?php
      }
      ?>
    <?php
    if (isset($_POST['simpan'])) {
      if (isset($_POST['id'])) {
        $ubah = mysqli_query(
          $mysqli, 
          "UPDATE obat SET 
          nama_obat = '" . $_POST['nama_obat'] . "',
          kemasan = '" . $_POST['kemasan'] . "',
          harga = '" . $_POST['harga'] . "'
          WHERE
          id = '" . $_POST['id'] . "'"
        );
      } else {
        $tambah = mysqli_query(
          $mysqli, 
          "INSERT INTO obat(nama_obat,kemasan,harga) 
          VALUES ( 
            '" . $_POST['nama_obat'] . "',
            '" . $_POST['kemasan'] . "',
            '" . $_POST['harga'] . "'
          )"
        );
      }

      echo "<script> 
              document.location='index.php?page=obat';
            </script>";
    }

    if (isset($_GET['aksi'])) {
      if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query(
          $mysqli, 
          "DELETE FROM obat WHERE id = '" . $_GET['id'] . "'"
        );
      } else if ($_GET['aksi'] == 'ubah_data') {
        $ubah_data = mysqli_query(
          $mysqli, "UPDATE obat SET 
          nama_obat = '" . $_GET['nama_obat'] . "', 
          kemasan = '" . $_GET['kemasan'] . "', 
          harga = '" . $_GET['harga'] . "' 
          WHERE
          id = '" . $_GET['id'] . "'"
        );
      }

      echo "<script> 
              document.location='index.php?page=obat';
            </script>";
    }
    ?>
    </table>
  </div>
</body>
</html>