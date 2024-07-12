<?php
include_once("koneksi.php");

// Mendapatkan data periksa berdasarkan ID
$id_periksa = $_GET['id'];
$query_periksa = "
  SELECT pr.*, p.nama as nama_pasien, p.alamat as alamat_pasien, p.no_hp as hp_pasien, 
         d.nama as nama_dokter, d.alamat as alamat_dokter, d.no_hp as hp_dokter
  FROM periksa pr 
  LEFT JOIN pasien p ON pr.id_pasien = p.id 
  LEFT JOIN dokter d ON pr.id_dokter = d.id 
  WHERE pr.id = '$id_periksa'";
$result_periksa = mysqli_query($mysqli, $query_periksa);
$data_periksa = mysqli_fetch_array($result_periksa);

// Mendapatkan data obat berdasarkan ID periksa
$query_obat = "
  SELECT o.nama_obat, o.harga 
  FROM detail_periksa dp 
  JOIN obat o ON dp.id_obat = o.id 
  WHERE dp.id_periksa = '$id_periksa'";
$result_obat = mysqli_query($mysqli, $query_obat);
$obat_list = [];
$total_obat = 0;
while ($data_obat = mysqli_fetch_array($result_obat)) {
  $obat_list[] = $data_obat;
  $total_obat += $data_obat['harga'];
}

// Harga jasa dokter (contoh, sesuaikan dengan kebutuhan)
$jasa_dokter = 150000;
$total = $jasa_dokter + $total_obat;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">   
    <title>Invoice</title><!--Judul Halaman-->
  <style>
    body{
      background: #F8F4E1;
    }
    .navbar{
      position: fixed;
      width: 100%;
      padding: 10px 30px;
    }
    .row{
      .col{
        .btn{
          margin-top: 10px;
        }
      }
    }
    .invoice-box {
      max-width: 800px;
      background: #fff;
      margin: auto;
      padding: 30px;
      border-radius: 5px;
      box-shadow: 2px 2px 5px rgba(84, 51, 16, 0.25);
      font-size: 16px;
      line-height: 24px;
      color: #555;
      table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        tr {
          td {
            padding: 5px;
            vertical-align: top;
          }
          td:nth-child(2){
            text-align: right;
          }
        }
        tr.top {
          border-bottom: 5px solid #AF8F6F;
          td {
            table {
              tr {
                td {
                  padding-bottom: 20px;
                  p {
                    span {
                      font-weight: 700;
                    }
                  }
                }
                td.title {
                  font-size: 45px;
                  line-height: 45px;
                  color: #333;
                }
              }
            }
          }
        }
        tr.information {
          border-bottom: 5px solid #AF8F6F;
          td {
            table{
              tr {
                td {
                  padding-bottom: 40px;
                  span:nth-child(2) {
                    font-weight: 700;
                  }
                  span:nth-child(6) {
                    color: #AF8F6F;
                  }
                }
              }
            }
          }
        }
        tr.heading {
          td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
          }
        }
        tr.details {
          td {
            padding-bottom: 20px;
          }
        }
        tr.item {
          td{
            border-bottom: 1px solid #eee;
          }
        }
        tr.item.last {
          td {
            border-bottom: none;
          }
        }
        tr.total {
          td {
            font-weight: 500;
            span {
              font-weight: 400;
            }
          }
        }
        tr.buy-total {
          td {
            font-size: 24px;
            font-weight: 700;
            color: #74512D;
            span {
              font-weight: 500;
              color: #000;
            }
          }
        }
      }
    }
  </style>
</head>
<body>
  <div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
      <tr class="top">
        <td colspan="2">
          <table>
            <tr>
              <td class="title">
                <h2>Nota Pembayaran</h2>
              </td>
            </tr>
            <tr>
              <td>
                <p>
                  No. Periksa: <br>
                  <span>
                    #<?php echo $data_periksa['id']; ?>
                  </span>
                </p>
              </td>
              <td>
                <p>
                  Tanggal Periksa: <br>
                  <span>
                    <?php echo $data_periksa['tgl_periksa']; ?>
                  </span>
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr class="information">
        <td colspan="2">
          <table>
            <tr>
              <td>
                <p>Pasien</p>
                <span><?php echo $data_periksa['nama_pasien']; ?></span><br>
                <span><?php echo $data_periksa['alamat_pasien']; ?></span><br>
                <span><?php echo $data_periksa['hp_pasien']; ?></span>
              </td>
              <td>
                <p>Dokter</p>
                <span><?php echo $data_periksa['nama_dokter']; ?></span><br>
                <span><?php echo $data_periksa['alamat_dokter']; ?></span><br>
                <span><?php echo $data_periksa['hp_dokter']; ?></span>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr class="heading">
        <td>Deskripsi</td>
        <td>Harga</td>
      </tr>

      <tr class="item">
        <td>Jasa Dokter</td>
        <td>Rp <?php echo number_format($jasa_dokter, 0, ',', '.'); ?></td>
      </tr>

      <?php foreach ($obat_list as $obat) { ?>
      <tr class="item">
        <td><?php echo $obat['nama_obat']; ?></td>
        <td>Rp <?php echo number_format($obat['harga'], 0, ',', '.'); ?></td>
      </tr>
      <?php } ?>

      <tr class="total">
        <td></td>
        <td><span>Jasa Dokter:</span> Rp <?php echo number_format($jasa_dokter, 0, ',', '.'); ?></td>
      </tr>
      
      <tr class="total">
        <td></td>
        <td><span>Subtotal Obat:</span> Rp <?php echo number_format($total_obat, 0, ',', '.'); ?></td>
      </tr>

      <tr class="buy-total">
        <td></td>
        <td><span>Total:</span> Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
      </tr>
    </table>
  </div>
</body>
</html>
