<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "crudoperation";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nama        = "";
$email      = "";
$no_hp     = "";
$pemesanan   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from crud where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from crud where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama       = $r1['nama'];
    $email      = $r1['email'];
    $no_hp     = $r1['no_hp'];
    $pemesanan   = $r1['pemesanan'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nama        = $_POST['nama'];
    $email       = $_POST['email'];
    $no_hp     = $_POST['no_hp'];
    $pemesanan   = $_POST['pemesanan'];

    if ($nama && $email && $no_hp && $pemesanan) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update crud set nama = '$nama',email='$email',no_hp = '$no_hp',pemesanan='$pemesanan' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into crud(nama,email,no_hp,pemesanan) values ('$nama','$email','$no_hp','$pemesanan')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="stylephp.css">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
<header>
      <div class="header">
        <div class="satu"><h2>WEB WISATA</h2></div>
        <div class="dua">
          <ul>
            <a href="index.html"><li>HOME</li></a>
            <a href="wisata.html"><li>REKOMENDASI</li></a>
            <a href="tabel.html"><li>PERINCIAN</li></a>
            <a href="contact.html"><li>CONTACT</li></a>
            <a href="index.php"><li>PESAN</li></a>
          </ul>
        </div>
      </div>
    </header>   
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_hp" class="col-sm-2 col-form-label">No. HP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $no_hp ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="pemesanan" class="col-sm-2 col-form-label">Pemesanan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="pemesanan" id="pemesanan">
                                <option value="">- Pilih Tempat -</option>
                                <option value="Candi Borobudur" <?php if ($pemesanan == "Candi Borobudur") echo "selected" ?>>Candi Borobudur</option>
                                <option value="Candi Prambanan" <?php if ($pemesanan == "Candi Prambanan") echo "selected" ?>>Candi Prambanan</option>
                                <option value="Kota Lama" <?php if ($pemesanan == "Kota Lama") echo "selected" ?>>Kota Lama </option>
                                <option value="Lawang Sewu" <?php if ($pemesanan == "Lawang Sewu") echo "selected" ?>>Lawang Sewu</option>
                                <option value="Taman Mini Ancol" <?php if ($pemesanan == "Taman Mini Ancol") echo "selected" ?>>Taman Mini Ancol</option>
                                <option value="Pulau Komodo" <?php if ($pemesanan == "Pulau Komodo") echo "selected" ?>>Pulau Komodo</option>
                                <option value="Tangkuban Perahu" <?php if ($pemesanan == "Tangkuban Perahu") echo "selected" ?>>Tangkuban Perahu</option>
                                <option value="Pantai Parangtritis" <?php if ($pemesanan == "Pantai Parangtritis") echo "selected" ?>>Pantai Parangtritis</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Pemesanan
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">No. HP</th>
                            <th scope="col">Pemesanan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from crud order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id          = $r2['id'];
                            $nama        = $r2['nama'];
                            $email       = $r2['email'];
                            $no_hp       = $r2['no_hp'];
                            $pemesanan   = $r2['pemesanan'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $email ?></td>
                                <td scope="row"><?php echo $no_hp ?></td>
                                <td scope="row"><?php echo $pemesanan ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>
</html>