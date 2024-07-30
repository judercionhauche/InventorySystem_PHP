<?php
  $page_title = 'Pharmacist Dashboard';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>

<?php include_once('layouts/header.php'); ?>

<style>
  .flinch {
    animation: flinch 1s infinite;
  }

  @keyframes flinch {
    0% { transform: scale(1); }
    25% { transform: scale(1.1); }
    50% { transform: scale(1); }
    75% { transform: scale(1.1); }
    100% { transform: scale(1); }
  }
</style>

<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>
  <div class="row">
    <a href="patients.php" style="color:black;">
		<div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <p class="text-muted">Patients Registered</p>
          <p class="text-muted" style="font-size:24px;">45</p>
        </div>
       </div>
    </div>
	</a>
	
	<a href="prescriptions.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue2">
          <i class="glyphicon glyphicon-list-alt"></i>
        </div>
        <div class="panel-value pull-right">
          <p class="text-muted">Prescriptions Made</p>
          <p class="text-muted" style="font-size:24px;">120</p>
        </div>
       </div>
    </div>
	</a>
	
	<a href="javascript:void(0);" onclick="showStockoutAlert()" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix flinch">
         <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-warning-sign"></i>
        </div>
        <div class="panel-value pull-right">
          <p class="text-muted">Stockout Alerts</p>
          <p class="text-muted" style="font-size:24px; color:red;">3</p>
        </div>
       </div>
    </div>
	</a>
</div>
  
  <div class="row">
   <div class="col-md-8">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Prescribed Medicines Overview</span>
         </strong>
       </div>
       <div class="panel-body">
         <canvas id="medicine-graph"></canvas>
       </div>
     </div>
   </div>
 </div>
 
<?php include_once('layouts/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Static data for the graph
  var ctx = document.getElementById('medicine-graph').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Medicine A', 'Medicine B', 'Medicine C', 'Medicine D'],
          datasets: [{
              label: 'Prescriptions',
              data: [50, 30, 70, 20],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          }
      }
  });

  function showStockoutAlert() {
    alert('Stockout Alerts:\n\n1. Medicine A\n2. Medicine B\n3. Medicine C');
  }
</script>
