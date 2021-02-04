<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tcsproject";
$conn = mysqli_connect($servername,$username,$password,$dbname);
if(mysqli_connect_errno()){
	printf("Connect failed: %s\n",mysqli_connect_error());
	exit();
}
$sql = "SELECT COUNT(Sentiment) as cnt FROM custfeedback where Sentiment='positive'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$pos = $row[0];
$sql = "SELECT COUNT(Sentiment) as cnt FROM custfeedback where Sentiment='negative'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$neg = $row[0];
$sql = "SELECT COUNT(Rating) as cnt FROM custfeedback where Rating<7 AND Time<='2021-02-01 00:00:00'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$detj = $row[0];
$sql = "SELECT COUNT(Rating) as cnt FROM custfeedback where Rating>8 AND Time<='2021-02-01 00:00:00'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$proj = $row[0];
$sql = "SELECT COUNT(Rating) as cnt FROM custfeedback where Rating=7 OR Rating=8 AND Time<='2021-02-01 00:00:00'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$pasj = $row[0];

$sql = "SELECT COUNT(Rating) as cnt FROM custfeedback where Rating<7 AND Time>='2021-02-01 00:00:00'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$detf = $row[0];
$sql = "SELECT COUNT(Rating) as cnt FROM custfeedback where Rating>8 AND Time>='2021-02-01 00:00:00'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$prof = $row[0];
$sql = "SELECT COUNT(Rating) as cnt FROM custfeedback where Rating=7 OR Rating=8 AND Time>='2021-02-01 00:00:00'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$pasf = $row[0];
$sql = "SELECT COUNT(Emoji) as cnt FROM custfeedback where Emoji=0";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$zero = $row[0];
$sql = "SELECT COUNT(Emoji) as cnt FROM custfeedback where Emoji=1";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$one = $row[0];
$sql = "SELECT COUNT(Emoji) as cnt FROM custfeedback where Emoji=2";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$two = $row[0];
$sql = "SELECT COUNT(Emoji) as cnt FROM custfeedback where Emoji=3";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$three = $row[0];
$sql = "SELECT COUNT(Emoji) as cnt FROM custfeedback where Emoji=4";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$four = $row[0];
$sql = "select Image,Count(Image) as imgCnt from custfeedback group by Image order by imgCnt desc limit 1";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$dress = $row[0];
$sql = "select ImgDesc from custfeedback where Image='$dress'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_row($result);
$desc = $row[0];
mysqli_close($conn);
$totsenti = $pos+$neg;
$totclicks = $zero+$one+$two+$three+$four;
$totnpsj = $proj+$detj+$pasj;
$totnpsf = $prof+$detf+$pasf;
$pos = 100*($pos/$totsenti);
$neg = 100*($neg/$totsenti);
$detj = 100*($detj/$totnpsj);
$pasj = 100*($pasj/$totnpsj);
$proj = 100*($proj/$totnpsj);
$npsj = $proj-$detj;
$detf = 100*($detf/$totnpsf);
$pasf = 100*($pasf/$totnpsf);
$prof = 100*($prof/$totnpsf);
$npsf = $prof-$detf;

?>
<!DOCTYPE html>
<html>
<head>
<link rel ="stylesheet" href="outcomecss.css">
<title>Feedback Analysis</title>
<head>
<body>
  <div class = "whole">
  <h3> Customer Feedback Analysis </h3>
  <div class = "header">
  <div id="nps">
    <canvas id="canvas" width='80px' height='65px'></canvas>
  </div>
<div id="senti">  
  <canvas id="Chart" width='80px' height='60px'></canvas>
</div>
<div id="sw">
<p>Word Cloud</p>
<img src="jan1.png" width="260px">
</div>
<div id="se">
  <p>Most Bought Dress of this Month!</p>
  <img src="<?php echo $dress; ?>" width='100px' height='100px'>
  <p><?php echo $desc; ?> </p>
</div>
  </div>
  <div class = "footer">
    
      <div class = "card">
        <div class = "one">
          <p>&#x1F620</p>
          <h3><?php echo $zero; ?> Clicks</h3>
        </div>
        <div class = "one">
          <p>&#x1F626</p>
          <h3><?php echo $one; ?> Clicks </h3>
        </div>
        <div class = "one">
          <p>&#x1F611</p>
          <h3><?php echo $two; ?> Clicks </h3>
        </div>
        <div class = "one">
          <p>&#x1F600</p>
          <h3><?php echo $three; ?> Clicks</h3>
        </div>
        <div class = "one">
          <p>&#x1F60D</p>
          <h3><?php echo $four; ?> Clicks</h3>
        </div>
	<div class = "onet">
          <img src = "emoji.jpg" width="50px">
          <h3>Total - <?php echo $totclicks; ?> Clicks</h3>
        </div>
      </div>
    </div>
    </div>
  </div>
  </body>
    </html>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
   <script>
var ctx = document.getElementById('Chart').getContext('2d');
var chart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Positive", "Negative",],
    datasets: [{
      backgroundColor: [
        "#a8e063",                     
        "crimson"      
      ],
      data: [<?php echo"$pos"?>,<?php echo"$neg"?>]
    }]
  },
  options: {title: {
            display: true,
            text: 'Sentiment Analysis'
        	},
            
            },
});

var ctx = document.getElementById("canvas").getContext("2d");
var canvas = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["January","February"],
    datasets: [{
      type: 'line',
      label: 'NPS Score',
      borderColor: 'black',
      borderWidth: 2,
      fill: false,
      backgroundColor: 'black',
      data: [<?php echo"$npsj"?>,<?php echo"$npsf"?>]
    },  {
      type: 'bar',
      label: 'Detractors',
      backgroundColor: '#dd5e89',
      stack: 'Stack 0',
      data: [<?php echo"$detj"?>,<?php echo"$detf"?>],     
    }, {
      type: 'bar',
      label: 'Passives',
      backgroundColor: '#f7bb97',
      stack: 'Stack 0',
      data: [<?php echo"$pasj"?>,<?php echo"$pasf"?>]
    }, {
      type: 'bar',
      label: 'Promoters',
      backgroundColor: '#06beb6',
      stack: 'Stack 0',
      data: [<?php echo"$proj"?>,<?php echo"$prof"?>]
    }, ]
  },
  options: {
    
    title: {
      display: true,
      text: 'NPS Score'
    },
    tooltips: {
      mode: 'index',
      intersect: true
    },
    scales: {
      xAxes: [{
        stacked: true,
      }]
    }
  }
});
   </script>
      

        