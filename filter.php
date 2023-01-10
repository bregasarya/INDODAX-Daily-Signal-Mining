<?php

//$url = $_SERVER['REQUEST_URI'];  
//header("Refresh: 5; URL=$url");  
//echo "Halaman ini akan direfresh setiap 15 detik</br>";

// Create database connection using config file
include_once("koneksi.php");

if(isset($_GET['fDate'])){
    $dari_tgl = $_GET['dari_tgl'];
    $sampai_tgl = $_GET['sampai_tgl'];
    $jumlahDataPerHalaman = 3000;
    $total = mysqli_query($mysqli, "SELECT * FROM btc WHERE tanggal BETWEEN  '$dari_tgl' AND '$sampai_tgl'");
    $jumlahData = mysqli_num_rows($total);
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif)-$jumlahDataPerHalaman;

    $previous = $halamanAktif - 1;
    $next = $halamanAktif + 1;
    
    $result = mysqli_query($koneksi,"SELECT * from btc WHERE tanggal BETWEEN  '$dari_tgl' AND '$sampai_tgl' LIMIT $awalData, $jumlahDataPerHalaman");

}else if(isset($_GET['fLevel'])){
    $level = $_GET['level'];
    $jumlahDataPerHalaman = 3000;
    $total = mysqli_query($mysqli, "SELECT * FROM btc WHERE level='$level' ");
    $jumlahData = mysqli_num_rows($total);
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif)-$jumlahDataPerHalaman;

    $previous = $halamanAktif - 1;
    $next = $halamanAktif + 1;
    
    $result = mysqli_query($koneksi,"SELECT * from btc WHERE level='$level' LIMIT $awalData, $jumlahDataPerHalaman");

}else if(isset($_GET['fSinyal'])){
    $dari_sinyal = $_GET['dari_sinyal'];
    $sampai_sinyal = $_GET['sampai_sinyal'];
    $jumlahDataPerHalaman = 3000;
    $total = mysqli_query($mysqli, "SELECT * FROM btc WHERE sinyal BETWEEN  '$dari_sinyal' AND '$sampai_sinyal'");
    $jumlahData = mysqli_num_rows($total);
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif)-$jumlahDataPerHalaman;

    $previous = $halamanAktif - 1;
    $next = $halamanAktif + 1;
    
    $result = mysqli_query($koneksi,"SELECT * from btc WHERE sinyal BETWEEN  '$dari_sinyal' AND '$sampai_sinyal' order by sinyal LIMIT $awalData, $jumlahDataPerHalaman");

}else if(isset($_GET['fHarga'])){
    $dari_harga = $_GET['dari_harga'];
    $sampai_harga = $_GET['sampai_harga'];
    $jumlahDataPerHalaman = 3000;
    $total = mysqli_query($mysqli, "SELECT * FROM btc WHERE hargaidr BETWEEN  '$dari_harga' AND '$sampai_harga'");
    $jumlahData = mysqli_num_rows($total);
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif)-$jumlahDataPerHalaman;

    $previous = $halamanAktif - 1;
    $next = $halamanAktif + 1;
    
    $result = mysqli_query($koneksi,"SELECT * from btc WHERE hargaidr BETWEEN  '$dari_harga' AND '$sampai_harga' LIMIT $awalData, $jumlahDataPerHalaman");

}else{
    //Pagination
    //Konfigurasi
    $jumlahDataPerHalaman = 3000;
    $total = mysqli_query($mysqli, "SELECT * FROM btc");
    $jumlahData = mysqli_num_rows($total);
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $awalData = ($jumlahDataPerHalaman * $halamanAktif)-$jumlahDataPerHalaman;

    $previous = $halamanAktif - 1;
    $next = $halamanAktif + 1;

    $result = mysqli_query($mysqli, "SELECT * FROM btc order by id desc LIMIT $awalData, $jumlahDataPerHalaman");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/jquery.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
    <title>Penambangan Data BTC</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow p-3 mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BTC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link " aria-current="page" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="filter.php">Filter</a>
                </li>
                <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Chart
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="chart.php">Diagram 1</a></li>
            <li><a class="dropdown-item" href="chart2.php">Diagram 2</a></li>
            <li><a class="dropdown-item" href="chart3.php">Diagram 3</a></li>
          </ul>
        </li>
            </ul>
            </div>
        </div>
    </nav>

  <div class="container">
     <div class="row">
         <div class="col">
         <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penambangan Sinyal Harian INDODAX</h6>
                </div>
                <div class="card-body">

                        <?php
                    if(isset($_GET['fDate'])){
                ?>
                    <a href="filter.php" class="btn btn-primary">Bersih</a>
                    <a href="excel.php?dari_tgl=<?php echo $dari_tgl?>&sampai_tgl=<?php echo $sampai_tgl ?>" class="btn btn-primary">Salin Excel</a>
                       <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" <?php if($halamanAktif > 1){ echo "href='?dari_tgl=$dari_tgl&sampai_tgl=$sampai_tgl&halaman=$previous&fDate=#'"; } ?>>Previous</a>
                            </li>
                            <?php 
                            for($x=1;$x<=$jumlahHalaman;$x++){
                                ?> 
                                <li class="page-item"><a class="page-link" href="?dari_tgl=<?php echo $dari_tgl ?>&sampai_tgl=<?php echo $sampai_tgl ?>&halaman=<?php echo $x ?>&fDate=#"><?php echo $x; ?></a></li>
                                <?php
                            }
                            ?>				
                            <li class="page-item">
                                <a  class="page-link" <?php if($halamanAktif < $jumlahHalaman) { echo "href='?dari_tgl=$dari_tgl&sampai_tgl=$sampai_tgl&halaman=$next&fDate=#''"; } ?>>Next</a>
                            </li>
                        </ul>
                        </nav>
                <?php }else if(isset($_GET['fLevel'])){ ?>
                    <a href="filter.php" class="btn btn-primary">Bersih</a>
                    <a href="excel.php?level=<?php echo $level?>" class="btn btn-primary">Salin Excel</a>
                       <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" <?php if($halamanAktif > 1){ echo "href='?level=$level&halaman=$previous&fLevel=#'"; } ?>>Previous</a>
                            </li>
                            <?php 
                            for($x=1;$x<=$jumlahHalaman;$x++){
                                ?> 
                                <li class="page-item"><a class="page-link" href="?level=<?php echo $level ?>&halaman=<?php echo $x ?>&fLevel=#"><?php echo $x; ?></a></li>
                                <?php
                            }
                            ?>				
                            <li class="page-item">
                                <a  class="page-link" <?php if($halamanAktif < $jumlahHalaman) { echo "href='?level=$level&halaman=$next&fLevel=#'"; } ?>>Next</a>
                            </li>
                        </ul>
                        </nav>
                <?php }else if(isset($_GET['fSinyal'])){ ?>
                    <a href="filter.php" class="btn btn-primary">Bersih</a><a href="excel.php?dari_sinyal=<?php echo $dari_sinyal?>&sampai_sinyal=<?php echo $sampai_sinyal ?>" class="btn btn-primary">Salin Excel</a>
                       <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" <?php if($halamanAktif > 1){ echo "href='?dari_sinyal=$dari_sinyal&sampai_sinyal=$sampai_sinyal&halaman=$previous&fSinyal=#'"; } ?>>Previous</a>
                            </li>
                            <?php 
                            for($x=1;$x<=$jumlahHalaman;$x++){
                                ?> 
                                <li class="page-item"><a class="page-link" href="?dari_sinyal=<?php echo $dari_sinyal ?>&sampai_sinyal=<?php echo $sampai_sinyal ?>&halaman=<?php echo $x ?>&fSinyal=#"><?php echo $x; ?></a></li>
                                <?php
                            }
                            ?>				
                            <li class="page-item">
                                <a  class="page-link" <?php if($halamanAktif < $jumlahHalaman) { echo "href='?dari_sinyal=$dari_sinyal&sampai_sinyal=$sampai_sinyal&halaman=$next&fSinyal=#'"; } ?>>Next</a>
                            </li>
                        </ul>
                        </nav>                
                <?php }else if(isset($_GET['fHarga'])){ ?>
                    <a href="filter.php" class="btn btn-primary">Bersih</a><a href="excel.php?dari_harga=<?php echo $dari_harga?>&sampai_harga=<?php echo $sampai_harga ?>" class="btn btn-primary">Salin Excel</a>
                       <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" <?php if($halamanAktif > 1){ echo "href='?dari_harga=$dari_harga&sampai_harga=$sampai_harga&halaman=$previous&fHarga=#'"; } ?>>Previous</a>
                            </li>
                            <?php 
                            for($x=1;$x<=$jumlahHalaman;$x++){
                                ?> 
                                <li class="page-item"><a class="page-link" href="?dari_harga=<?php echo $dari_harga ?>&sampai_harga=<?php echo $sampai_harga ?>&halaman=<?php echo $x ?>&fHarga=#"><?php echo $x; ?></a></li>
                                <?php
                            }
                            ?>				
                            <li class="page-item">
                                <a  class="page-link" <?php if($halamanAktif < $jumlahHalaman) { echo "href='?dari_harga=$dari_harga&sampai_harga=$sampai_harga&halaman=$next&fHarga=#'"; } ?>>Next</a>
                            </li>
                        </ul>
                        </nav>
                        <?php }else{ ?>

            <div class="row mt-4 mb-5">
            <div class="col">
            <form action="#" method="GET">
            <div class="input-group mb-3">
            <input type="text" class="form-control" id="clevel" name="level" placeholder="Pencarian">
            <button class="btn btn-outline-primary" type="submit" name="fLevel" id="button-addon2">Cari</button>
            </div>
            </form>
            <h5>Filter</h5>
                <table>
                    <tr>
                        <form action="#" method="GET">
                        <td>Filter Date</td>
                        <td><input type="date" class="form-control" name="dari_tgl"></td>
                        <td>-</td>
                        <td><input type="date" class="form-control" name="sampai_tgl"></td>
                        <td><button type="submit" name="fDate" class="btn btn-primary">Terapkan</button></td>
                        </form>
                    </tr>
                    <tr>
                        <form action="#" method="GET">
                        <td>Filter Level</td>
                        <td colspan="3"><select name="level" id="level" class="form-select">
                            <option value="0">Level</option>
                            <?php $level = mysqli_query($mysqli, "SELECT level from btc GROUP BY level"); 
                            while ($row = mysqli_fetch_assoc($level)){
                            ?>
                            <option value="<?php echo $row['level']; ?>"><?php echo $row['level']; ?></option>
                            <?php } ?>
                        </select></td>
                        <td><button type="submit" class="btn btn-primary" name="fLevel">Terapkan</button></td>
                        </form>
                    </tr>
                    <tr>
                        <form action="#" method="GET">
                        <td>Filter Sinyal</td>
                        <td><input type="number" class="form-control" name="dari_sinyal"></td>
                        <td>-</td>
                        <td><input type="number" class="form-control" name="sampai_sinyal"></td>
                        <td><button type="submit" name="fSinyal" class="btn btn-primary">Terapkan</button></td>
                        </form>
                    </tr>
                    <tr>
                        <form action="#" method="GET">
                        <td>Filter Rentan Harga</td>
                        <td><input type="number" class="form-control" name="dari_harga"></td>
                        <td>-</td>
                        <td><input type="number" class="form-control" name="sampai_harga"></td>
                        <td><button type="submit" name="fHarga" class="btn btn-primary">Terapkan</button></td>
                        </form>
                    </tr>
                </table>
            </div>
        </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" <?php if($halamanAktif > 1){?> href="?halaman=<?php echo $previous ?>" <?php }?>>Previous</a></li>
                        <?php 
				            for($x=1;$x<=$jumlahHalaman;$x++){
					    ?> 
                        <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                        <?php } ?>
                        <li class="page-item"><a class="page-link" <?php if($halamanAktif < $jumlahHalaman) { ?> href="?halaman=<?php echo $next ?>" <?php }?>>Next</a></li>
                    </ul>
                </nav>
                <?php }?>
                <div class="table-responsive">
                <table width='100%' border="1" id="dtHorizontalExample">
                    <tr>
                        <th>ID</th>
                        <th>Sinyal</th> 
                        <th>Level</th> 
                        <th>Tanggal dan Waktu</th>
                        <th>Harga Rp.</th>
                        <th>Harga USDT</th> 
                        <th>Vol BTC</th> 
                        <th>Vol Rp.</th>
                        <th>Last Buy</th>
                        <th>Last Sell</th>
                        <th>Jenis</th>
                        
                    </tr>
                    <?php  
                    while($user_data = mysqli_fetch_array($result)) {  

                $konter=$user_data['sinyal'];      

                echo "<tr>";

                $hrgidr=number_format($user_data['hargaidr']);
                $hrgusdt=number_format($user_data['hargausdt']);
                $vidr=number_format($user_data['volidr'],8,",",".");
                $vusdt=number_format($user_data['volusdt']);
                $lbuy=number_format($user_data['lastbuy']);
                $lsell=number_format($user_data['lastsell']);

                if($konter>=120)
                {
                echo "<td bgcolor=#FF0000>".$user_data['id']."</td>";
                echo "<td bgcolor=#FF0000>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#FF0000>".$user_data['level']."</td>";
                echo "<td bgcolor=#FF0000>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#FF0000>".$hrgidr."</td>";
                echo "<td bgcolor=#FF0000>".$hrgusdt."</td>";
                echo "<td bgcolor=#FF0000>".$vidr."</td>";
                echo "<td bgcolor=#FF0000>".$vusdt."</td>";
                echo "<td bgcolor=#FF0000>".$lbuy."</td>";
                echo "<td bgcolor=#FF0000>".$lsell."</td>";
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=111)
                {
                echo "<td bgcolor=#FF4500>".$user_data['id']."</td>";
                echo "<td bgcolor=#FF4500>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#FF4500>".$user_data['level']."</td>";
                echo "<td bgcolor=#FF4500>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#FF4500>".$hrgidr."</td>";
                echo "<td bgcolor=#FF4500>".$hrgusdt."</td>";
                echo "<td bgcolor=#FF4500>".$vidr."</td>";
                echo "<td bgcolor=#FF4500>".$vusdt."</td>";
                echo "<td bgcolor=#FF4500>".$lbuy."</td>";
                echo "<td bgcolor=#FF4500>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=101)
                {
                echo "<td bgcolor=#FFA500>".$user_data['id']."</td>";
                echo "<td bgcolor=#FFA500>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#FFA500>".$user_data['level']."</td>";
                echo "<td bgcolor=#FFA500>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#FFA500>".$hrgidr."</td>";
                echo "<td bgcolor=#FFA500>".$hrgusdt."</td>";
                echo "<td bgcolor=#FFA500>".$vidr."</td>";
                echo "<td bgcolor=#FFA500>".$vusdt."</td>";
                echo "<td bgcolor=#FFA500>".$lbuy."</td>";
                echo "<td bgcolor=#FFA500>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }elseif($konter>=91) 
                {
                echo "<td bgcolor=#E52A2A>".$user_data['id']."</td>";
                echo "<td bgcolor=#E52A2A>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#E52A2A>".$user_data['level']."</td>";
                echo "<td bgcolor=#E52A2A>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#E52A2A>".$hrgidr."</td>";
                echo "<td bgcolor=#E52A2A>".$hrgusdt."</td>";
                echo "<td bgcolor=#E52A2A>".$vidr."</td>";
                echo "<td bgcolor=#E52A2A>".$vusdt."</td>";
                echo "<td bgcolor=#E52A2A>".$lbuy."</td>";
                echo "<td bgcolor=#E52A2A>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=81)
                {
                echo "<td bgcolor=#F20082>".$user_data['id']."</td>";
                echo "<td bgcolor=#F20082>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#F20082>".$user_data['level']."</td>";
                echo "<td bgcolor=#F20082>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#F20082>".$hrgidr."</td>";
                echo "<td bgcolor=#F20082>".$hrgusdt."</td>";
                echo "<td bgcolor=#F20082>".$vidr."</td>";
                echo "<td bgcolor=#F20082>".$vusdt."</td>";
                echo "<td bgcolor=#F20082>".$lbuy."</td>";
                echo "<td bgcolor=#F20082>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=71)
                {
                echo "<td bgcolor=#DC5C5C>".$user_data['id']."</td>";
                echo "<td bgcolor=#DC5C5C>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#DC5C5C>".$user_data['level']."</td>";
                echo "<td bgcolor=#DC5C5C>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#DC5C5C>".$hrgidr."</td>";
                echo "<td bgcolor=#DC5C5C>".$hrgusdt."</td>";
                echo "<td bgcolor=#DC5C5C>".$vidr."</td>";
                echo "<td bgcolor=#DC5C5C>".$vusdt."</td>";
                echo "<td bgcolor=#DC5C5C>".$lbuy."</td>";
                echo "<td bgcolor=#DC5C5C>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=61)
                {
                echo "<td bgcolor=#FF69B4>".$user_data['id']."</td>";
                echo "<td bgcolor=#FF69B4>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#FF69B4>".$user_data['level']."</td>";
                echo "<td bgcolor=#FF69B4>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#FF69B4>".$hrgidr."</td>";
                echo "<td bgcolor=#FF69B4>".$hrgusdt."</td>";
                echo "<td bgcolor=#FF69B4>".$vidr."</td>";
                echo "<td bgcolor=#FF69B4>".$vusdt."</td>";
                echo "<td bgcolor=#FF69B4>".$lbuy."</td>";
                echo "<td bgcolor=#FF69B4>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }elseif($konter>=51) 
                {
                echo "<td bgcolor=#F08080>".$user_data['id']."</td>";
                echo "<td bgcolor=#F08080>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#F08080>".$user_data['level']."</td>";
                echo "<td bgcolor=#F08080>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#F08080>".$hrgidr."</td>";
                echo "<td bgcolor=#F08080>".$hrgusdt."</td>";
                echo "<td bgcolor=#F08080>".$vidr."</td>";
                echo "<td bgcolor=#F08080>".$vusdt."</td>";
                echo "<td bgcolor=#F08080>".$lbuy."</td>";
                echo "<td bgcolor=#F08080>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=41)
                {
                echo "<td bgcolor=#FFA07A>".$user_data['id']."</td>";
                echo "<td bgcolor=#FFA07A>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#FFA07A>".$user_data['level']."</td>";
                echo "<td bgcolor=#FFA07A>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#FFA07A>".$hrgidr."</td>";
                echo "<td bgcolor=#FFA07A>".$hrgusdt."</td>";
                echo "<td bgcolor=#FFA07A>".$vidr."</td>";
                echo "<td bgcolor=#FFA07A>".$vusdt."</td>";
                echo "<td bgcolor=#FFA07A>".$lbuy."</td>";
                echo "<td bgcolor=#FFA07A>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=31)
                {
                echo "<td bgcolor=#9370D8>".$user_data['id']."</td>";
                echo "<td bgcolor=#9370D8>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#9370D8>".$user_data['level']."</td>";
                echo "<td bgcolor=#9370D8>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#9370D8>".$hrgidr."</td>";
                echo "<td bgcolor=#9370D8>".$hrgusdt."</td>";
                echo "<td bgcolor=#9370D8>".$vidr."</td>";
                echo "<td bgcolor=#9370D8>".$vusdt."</td>";
                echo "<td bgcolor=#9370D8>".$lbuy."</td>";
                echo "<td bgcolor=#9370D8>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=21) 
                {
                echo "<td bgcolor=#BA55D3>".$user_data['id']."</td>";
                echo "<td bgcolor=#BA55D3>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#BA55D3>".$user_data['level']."</td>";
                echo "<td bgcolor=#BA55D3>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#BA55D3>".$hrgidr."</td>";
                echo "<td bgcolor=#BA55D3>".$hrgusdt."</td>";
                echo "<td bgcolor=#BA55D3>".$vidr."</td>";
                echo "<td bgcolor=#BA55D3>".$vusdt."</td>";
                echo "<td bgcolor=#BA55D3>".$lbuy."</td>";
                echo "<td bgcolor=#BA55D3>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }elseif($konter>=11) 
                {
                echo "<td bgcolor=#66CDAA>".$user_data['id']."</td>";
                echo "<td bgcolor=#66CDAA>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#66CDAA>".$user_data['level']."</td>";
                echo "<td bgcolor=#66CDAA>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#66CDAA>".$hrgidr."</td>";
                echo "<td bgcolor=#66CDAA>".$hrgusdt."</td>";
                echo "<td bgcolor=#66CDAA>".$vidr."</td>";
                echo "<td bgcolor=#66CDAA>".$vusdt."</td>";
                echo "<td bgcolor=#66CDAA>".$lbuy."</td>";
                echo "<td bgcolor=#66CDAA>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                elseif($konter>=1)
                {
                echo "<td bgcolor=#32CD32>".$user_data['id']."</td>";
                echo "<td bgcolor=#32CD32>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#32CD32>".$user_data['level']."</td>";
                echo "<td bgcolor=#32CD32>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#32CD32>".$hrgidr."</td>";
                echo "<td bgcolor=#32CD32>".$hrgusdt."</td>";
                echo "<td bgcolor=#32CD32>".$vidr."</td>";
                echo "<td bgcolor=#32CD32>".$vusdt."</td>";
                echo "<td bgcolor=#32CD32>".$lbuy."</td>";
                echo "<td bgcolor=#32CD32>".$lsell."</td>";    
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  

                else
                {
                echo "<td bgcolor=#00FF00>".$user_data['id']."</td>";
                echo "<td bgcolor=#00FF00>".$user_data['sinyal']."</td>";
                echo "<td bgcolor=#00FF00>".$user_data['level']."</td>";
                echo "<td bgcolor=#00FF00>".$user_data['tanggal']."</td>";
                echo "<td bgcolor=#00FF00>".$hrgidr."</td>";
                echo "<td bgcolor=#00FF00>".$hrgusdt."</td>";
                echo "<td bgcolor=#00FF00>".$vidr."</td>";
                echo "<td bgcolor=#00FF00>".$vusdt."</td>";
                echo "<td bgcolor=#00FF00>".$lbuy."</td>";
                echo "<td bgcolor=#00FF00>".$lsell."</td>";
                if ($user_data['jenis']=='crash'){
                echo "<td bgcolor=red>".$user_data['jenis']."</td>";}
                elseif ($user_data['jenis']=='moon'){
                echo "<td bgcolor=green>".$user_data['jenis']."</td>";}
                }  
                        echo "</tr>";
                    }
                    ?>
                </table>
                </div>
                    </div>
                </div>
            </div>
         </div>
     </div>

 </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script>
            $(function() {
                $("#clevel").autocomplete({
                    source: 'search.php'
                });

            });
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>