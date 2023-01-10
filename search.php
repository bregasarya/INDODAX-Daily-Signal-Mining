<?php
include "koneksi.php"; //Include file koneksi
$searchTerm = $_GET['term']; // Menerima kiriman data dari inputan pengguna

$sql="SELECT * FROM btc WHERE level LIKE '%".$searchTerm."%' GROUP BY level ORDER BY level ASC LIMIT 4"; // query sql untuk menampilkan data mahasiswa dengan operator LIKE

$hasil=mysqli_query($mysqli,$sql); //Query dieksekusi

//Disajikan dengan menggunakan perulangan
while ($row = mysqli_fetch_array($hasil)) {
    $data[] = $row['level'];
}
//Nilainya disimpan dalam bentuk json
echo json_encode($data);
?>