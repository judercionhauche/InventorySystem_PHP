<?php
  $page_title = 'Pharmacist Dashboard';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   
   
   
   $sql = "SELECT COUNT(*) AS number_of_patients FROM patients";
   $result = $db->query($sql);

    $row = $result->fetch_assoc();
    $patients = $row['number_of_patients'];
    
   
   
   $sql1 = "SELECT COUNT(*) AS number_of_prescriptions FROM prescriptions";
   $result1 = $db->query($sql1);
   
   $row1 = $result1->fetch_assoc();
   $presc = $row1['number_of_prescriptions'];
   
   
   
   $sql2 = "SELECT * FROM products WHERE qty < 5 GROUP BY item";
   $result2 = $db->query($sql2);
   $countt = 0;
   $items11 = array();
   while ($row11 = $result2->fetch_assoc()) {
      // Fetch the result
      $items11[] = $row11;
      $countt += 1;
    }
    
    // Encode the PHP array into a JSON format
    $items2_json = json_encode($items11);
   
   $row2 = $result2->fetch_assoc();
   
   $items1 = array();
   $sql3 = "SELECT pro.item AS medicine_name, COUNT(pre.medicine_id) AS prescription_count
            FROM products pro
            JOIN prescriptions pre ON pro.id = pre.medicine_id
            GROUP BY pro.item;
            ";
   $result3 = $db->query($sql3);
   while ($row3 = $result3->fetch_assoc()) {
    $items1[] = $row3;
  }
  
  // Encode the PHP array into a JSON format
  $items1_json = json_encode($items1);
   
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
    <a href="patient-registration.php" style="color:black;">
		<div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <p class="text-muted">Patients Registered</p>
          <p class="text-muted" style="font-size:24px;"><?php echo $patients  ?></p>
        </div>
       </div>
    </div>
	</a>
	
	<a href="patient-registration.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue2">
          <i class="glyphicon glyphicon-list-alt"></i>
        </div>
        <div class="panel-value pull-right">
          <p class="text-muted">Prescriptions Made</p>
          <p class="text-muted" style="font-size:24px;"><?php echo $presc ?></p>
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
          <p class="text-muted" style="font-size:24px; color:red;"><?php echo $countt  ?></p>
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
         <canvas id="medicine-graph">   </canvas>
       </div>
     </div>
   </div>
 </div>
 
<?php include_once('layouts/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

  // Get the PHP data as a JavaScript variable
  var items1 = <?php echo $items1_json; ?>;

  // Extract labels (medicine names) and data (prescription counts) from the items1 array
  var labels = items1.map(function(item) {
      return item.medicine_name;
  });
  
  
  var data = items1.map(function(item) {
      return item.prescription_count;
  });
  
  // Define colors (as many as needed)
        var backgroundColors = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ];

        var borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ];
        
        
        // Ensure the number of colors matches the number of data points
        var backgroundColorsForData = [];
        var borderColorsForData = [];
        
        for (var i = 0; i < data.length; i++) {
            backgroundColorsForData.push(backgroundColors[i % backgroundColors.length]);
            borderColorsForData.push(borderColors[i % borderColors.length]);
        }

  // Static data for the graph
  var ctx = document.getElementById('medicine-graph').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: labels,
          datasets: [{
              label: 'Prescriptions',
              data: data,
              backgroundColor: backgroundColorsForData,
              borderColor: borderColorsForData,
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
    // Get the PHP data as a JavaScript variable
    var items2 = <?php echo $items2_json; ?>;

    
    // Construct the alert message
    var alertMessage = 'Stockout Alerts:\n\n';
        for (var i = 0; i < items2.length; i++) {
            alertMessage += (i + 1) + '. ' + items2[i].item + " (" + items2[i].qty + ")" + '\n';
        }

        // Alert the message
        alert(alertMessage);
  }
</script>
