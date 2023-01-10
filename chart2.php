<?php
//koneksi

include_once("koneksi.php"); 

if(isset($_POST['fLevel'])){
$level = $_POST['level'];
$jenis = $_POST['jenis'];
$crash1="select level, COUNT(level) total, DATE(tanggal) as tgl from btc where level='$level' AND jenis='$jenis' GROUP BY tgl ";
$query_crash1=mysqli_query($koneksi,$crash1);
$ambil="SELECT level FROM btc WHERE level='$level' GROUP BY level";
$ambil2=mysqli_query($koneksi,$ambil);
}else{
$crash1="select level, COUNT(level) total, DATE(tanggal) as tgl from btc where level='Crash1' GROUP BY tgl ";
$query_crash1=mysqli_query($koneksi,$crash1);
$ambil="SELECT level FROM btc WHERE level='Crash1' GROUP BY level";
  $ambil2=mysqli_query($koneksi,$ambil);
}
$sql_tanggal="select DATE(tanggal) as tgl from btc Group by tgl";
$tanggal=mysqli_query($koneksi,$sql_tanggal);
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
                <a class="nav-link" aria-current="page" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="filter.php">Filter</a>
                </li> <li class="nav-item dropdown">
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
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Diagram Line Level</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <table>
                  <form action="#" method="POST">
                    <tr>
                        <td>Pilih Level</td>
                        <td colspan="3"><select name="level" id="level" class="form-select">
                            <?php $level = mysqli_query($mysqli, "SELECT level from btc GROUP BY level"); 
                            while ($row = mysqli_fetch_assoc($level)){
                            ?>
                            <option value="<?php echo $row['level']; ?>"><?php echo $row['level']; ?></option>
                            <?php } ?>
                        </select></td>
                        </tr>

                        <tr>
                        <td>Pilih Jenis</td>
                        <td colspan="3"><select name="jenis" id="level" class="form-select">
                            <?php $jenis = mysqli_query($mysqli, "SELECT jenis from btc GROUP BY jenis"); 
                            while ($row = mysqli_fetch_assoc($jenis)){
                            ?>
                            <option value="<?php echo $row['jenis']; ?>"><?php echo $row['jenis']; ?></option>
                            <?php } ?>
                        </select></td>
                        <td><button type="submit" class="btn btn-primary" name="fLevel">Terapkan</button></td>
                        </tr>
                        </form>
                        </table>
                    <div class="chart-area mt-5">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
     </div>

     

 </div>
    <script>
        var kotaCanvas = document.getElementById("myAreaChart");
  
 var dataFirst = {
     label: [<?php foreach($ambil2 as $key){  echo  '"'.$key['level'].'",';}?> ],
     data: [<?php foreach($query_crash1 as $key){  echo  '"'.$key['total'].'",';}?> ],
     lineTension: 0.3,
     fill: false,
     borderColor: 'blue',
     backgroundColor: 'transparent',
     pointBorderColor: 'blue',
     pointBackgroundColor: 'blue',
     pointRadius: 5,
     pointHoverRadius: 7,
     pointHitRadius: 7,
     pointBorderWidth: 2,
     pointStyle: 'rect'
   };
  
 var data = {
   labels:  [<?php foreach($tanggal as $key){  echo  '"'.$key['tgl'].'",';}?> ] ,
   datasets: [dataFirst]
 };
  
 var chartOptions = {
   legend: {
     display: true,
     position: 'top',
     labels: {
       boxWidth: 80,
       fontColor: 'black'
     }
   }
  
 };
  
 var lineChart = new Chart(kotaCanvas, {
   type: 'line',
   data: data,
   options: chartOptions
 });
    </script>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>