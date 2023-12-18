<?php
error_reporting(E_ALL);

include_once 'koneksi.php';

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $harga_jual = floatval($_POST['harga_jual']);
    $harga_beli = floatval($_POST['harga_beli']);
    $stok = intval($_POST['stok']);
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;

    if ($file_gambar['error'] == 0) {
        $filename = str_replace(' ', '_', $file_gambar['name']);
        $destination = 'gambar/' . $filename;

        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = 'gambar/' . $filename;
        } else {
            echo "Gagal mengunggah file gambar.";
            exit;
        }
    }

    $sql = 'INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) ';
    $sql .= 'VALUES (?, ?, ?, ?, ?, ?)';

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssddis', $nama, $kategori, $harga_jual, $harga_beli, $stok, $gambar);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "Data berhasil ditambahkan.";
        } else {
            echo "Gagal mengeksekusi pernyataan SQL: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal membuat prepared statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Tambah Barang</title>
    <style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    text-align: center;
    color: #007bff;
}

.main {
    margin-top: 20px;
}

.input {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"],
select,
input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

select {
    height: 40px;
}

.submit {
    text-align: center;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

    footer {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #007bff;
    height: 50px;
    font-size: 16px;
    font-weight: bold;
    margin-top: 50px;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Barang</h1>
        <div class="main">
            <form method="post" action="plus.php" enctype="multipart/form-data">
                <div class="input">
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" required>
                </div>
                <div class="input">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" required>
                        <option value="Komputer">Komputer</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Hand Phone">Hand Phone</option>
                    </select>
                </div>
                <div class="input">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="text" name="harga_jual" id="harga_jual" required>
                </div>
                <div class="input">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="text" name="harga_beli" id="harga_beli" required>
                </div>
                <div class="input">
                    <label for="stok">Stok</label>
                    <input type="text" name="stok" id="stok" required>
                </div>
                <div class="input">
                    <label for="file_gambar">File Gambar</label>
                    <input type="file" name="file_gambar" id="file_gambar" accept="image/*" required>
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Simpan">
                </div>
            </form>
            <?php
            require("link.php");
            ?>
        </div>
    </div>
    <?php
        require("footer.php");
    ?>
</body>
</html>