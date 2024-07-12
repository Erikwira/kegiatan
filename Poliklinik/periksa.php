<?php
    include_once("koneksi.php");

    // Proses form saat submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_periksa = $_POST['id'] ?? '';
        $id_pasien = $_POST['id_pasien'];
        $id_dokter = $_POST['id_dokter'];
        $tgl_periksa = $_POST['tgl_periksa'];
        $catatan = $_POST['catatan'];
        $obat = $_POST['obat'];

        // Simpan atau update data periksa
        if (!empty($id_periksa)) {
            // Update data periksa yang sudah ada
            mysqli_query($mysqli, "UPDATE periksa SET id_pasien='$id_pasien', id_dokter='$id_dokter', tgl_periksa='$tgl_periksa', catatan='$catatan' WHERE id='$id_periksa'");
            // Hapus semua obat lama yang terkait dengan periksa ini
            mysqli_query($mysqli, "DELETE FROM detail_periksa WHERE id_periksa='$id_periksa'");
        } else {
            // Simpan data periksa baru
            mysqli_query($mysqli, "INSERT INTO periksa (id_pasien, id_dokter, tgl_periksa, catatan) VALUES ('$id_pasien', '$id_dokter', '$tgl_periksa', '$catatan')");
            $id_periksa = mysqli_insert_id($mysqli); // Ambil id periksa yang baru saja disimpan
        }

        // Simpan obat-obatan yang dipilih
        if (!empty($obat)) {
            foreach ($obat as $id_obat) {
                mysqli_query($mysqli, "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')");
            }
        }
    }

    // Hapus data periksa jika aksi=hapus
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
        $id_periksa = $_GET['id'];
        mysqli_query($mysqli, "DELETE FROM periksa WHERE id='$id_periksa'");
        mysqli_query($mysqli, "DELETE FROM detail_periksa WHERE id_periksa='$id_periksa'");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap offline -->
    <link rel="stylesheet" href="assets/css/bootstrap.css"> 
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">   
    <title>Para Jadwal Periksa</title><!--Judul Halaman-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        .form-group{
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
          .select2{
            .selection{
              .select2-selection{
                width: 100%;
                border: none;
                border-radius: 5px;
                padding: 10px;
                font-size: 16px;
                font-weight: 400;
                box-shadow: 2px 2px 5px rgba(84, 51, 16, 0.25);
                .select2-search{
                  .select2-search__field{
                    margin: 0;
                  }
                }
              }
            }
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
      .select2-selection--multiple .select2-selection__choice {
        background-color: #543310;
        color: white;
        border: none;
      }
      .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
      }
      .select2-container{
        .select2-dropdown{
          border: none;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 2px 2px 5px rgba(84, 51, 16, 0.25);
          .select2-results{
            .select2-results__options{
              .select2-results__option{
                color: #543310;
                font-size: 18px;
                font-weight: 400;
                border-radius: 5px;
              }
              .select2-results__option:hover{
                background: #543310;
                color: #fff;
              }
            }
          }
        }
      }
    </style>
</head>
<body>
  <div class="container">
    <h3>
      Jadwal Pasien Dokter
      <br>
      <small class="text-muted">
        Data Pasien Dokter Tercatat Disini.
      </small>
    </h3>
    <hr class="garis">

    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
      <!-- Kode php untuk menghubungkan form dengan database -->
      <?php
        $id_pasien = '';
        $id_dokter = '';
        $tgl_periksa = '';
        $catatan = '';
        $obat_selected = []; // array untuk menyimpan obat yang dipilih
        if (isset($_GET['id'])) {
          $id_periksa = $_GET['id'];
          $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='$id_periksa'");
          while ($row = mysqli_fetch_array($ambil)) {
            $id_pasien = $row['id_pasien'];
            $id_dokter = $row['id_dokter'];
            $tgl_periksa = $row['tgl_periksa'];
            $catatan = $row['catatan'];
          }
          // Ambil obat-obatan yang sudah terpilih
          $ambil_obat = mysqli_query($mysqli, "SELECT id_obat FROM detail_periksa WHERE id_periksa='$id_periksa'");
          while ($obat_data = mysqli_fetch_array($ambil_obat)) {
            $obat_selected[] = $obat_data['id_obat'];
          }
        }
      ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? '' ?>">
      <!--Form Periksa Pasien-->
      <div class="form-group mx-sm-3 mb-2">
        <label for="inputPasien" class="sr-only form-label">Pasien</label>
        <select class="form-control" name="id_pasien">
        <?php
          $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
          while ($data = mysqli_fetch_array($pasien)) {
            $selected = ($data['id'] == $id_pasien) ? 'selected="selected"' : '';
        ?>
            <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <!--Form Periksa Dokter-->
      <div class="form-group mx-sm-3 mb-2">
        <label for="inputDokter" class="sr-only form-label">Dokter</label>
        <select class="form-control" name="id_dokter">
        <?php
          $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");
          while ($data = mysqli_fetch_array($dokter)) {
            $selected = ($data['id'] == $id_dokter) ? 'selected="selected"' : '';
        ?>
            <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
          <?php
          }
          ?>
        </select>
      </div>

      <!--Form Tanggal Periksa-->
      <div class="form-group col-2 mx-sm-3 mb-2">
        <label for="inputTglPeriksa" class="sr-only form-label">Tanggal Periksa</label>
        <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputTglPeriksa" value="<?php echo $tgl_periksa ?>">
      </div>

      <!--Form Catatan Periksa-->
      <div class="form-group mx-sm-3 mb-2">
        <label for="inputCatatan" class="sr-only form-label">Catatan</label>
        <input type="text" class="form-control" name="catatan" id="inputCatatan" placeholder="Masukkan Catatan" value="<?php echo $catatan ?>">
      </div>

      <!--Form Obat Periksa-->
      <div class="form-group mx-sm-3 mb-2">
        <label for="inputObat" class="sr-only form-label">Obat</label>
        <select class="form-control" name="obat[]" id="inputObat" multiple>
          <?php
            $obat_list = mysqli_query($mysqli, "SELECT * FROM obat");
            while ($data = mysqli_fetch_array($obat_list)) {
              $selected = (in_array($data['id'], $obat_selected)) ? 'selected' : '';
          ?>
            <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama_obat'] ?></option>
          <?php
            }
          ?>
        </select>
      </div>

      <div class="col">
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
      </div>
    </form>

    <!--Tabel Data Pasien-->
    <table class="table table-hover">
      <!--thead atau baris judul-->
      <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Nama Dokter</th>
            <th scope="col">Tanggal Periksa</th>
            <th scope="col">Catatan</th>
            <th scope="col">Obat</th>
            <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $result = mysqli_query($mysqli, "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
          $id_periksa = $data['id'];
      ?>
          <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $data['nama_pasien'] ?></td>
            <td><?php echo $data['nama_dokter'] ?></td>
            <td><?php echo $data['tgl_periksa'] ?></td>
            <td><?php echo $data['catatan'] ?></td>
            <td>
            <?php
              $result_obat = mysqli_query($mysqli, "SELECT o.nama_obat FROM detail_periksa dp JOIN obat o ON dp.id_obat = o.id WHERE dp.id_periksa = '$id_periksa'");
              $obat_list = [];
              while ($obat_data = mysqli_fetch_array($result_obat)) {
                $obat_list[] = $obat_data['nama_obat'];
              }
              echo implode(', ', $obat_list);
            ?>
            </td>
            <td>
              <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>">Ubah</a>
              <a class="btn btn-danger rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
              <a class="btn btn-warning rounded-pill px-3" href="index.php?page=invoice&id=<?php echo $data['id'] ?>">Nota</a>
            </td>
          </tr>
      <?php
        }
      ?>
      </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#inputObat').select2({
        placeholder: "Pilih Obat",
        allowClear: true,
        tags: true
      });
    });

    function validate() {
      let obat = $('#inputObat').val();
      if (obat.length === 0) {
        alert('Harap pilih setidaknya satu obat.');
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
