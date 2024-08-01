<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  
  // Check user level
  page_require_level(3);

  // Fetch data for dashboard
  $total_users = find_total_users();
  $total_categories = find_total_categories();
  $total_products = find_total_products();
  $total_sales = find_total_sales();
  $highest_selling_items = find_highest_selling_items();
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>

<div class="row">
    
    <a href="categorie.php" style="color:black;">
        <div class="col-md-3">
           <div class="panel panel-box clearfix">
             <div class="panel-icon pull-left bg-red">
              <i class="glyphicon glyphicon-th-large"></i>
            </div>
            <div class="panel-value pull-right">
              <p class="text-muted">Categories</p>
              <p class="text-muted"><?php echo $total_categories; ?></p>
            </div>
           </div>
        </div>
    </a>

    <a href="product.php" style="color:black;">
        <div class="col-md-3">
           <div class="panel panel-box clearfix">
             <div class="panel-icon pull-left bg-blue2">
              <i class="glyphicon glyphicon-shopping-cart"></i>
            </div>
            <div class="panel-value pull-right">
              <p class="text-muted">Products</p>
              <p class="text-muted"><?php echo $total_products; ?></p>
            </div>
           </div>
        </div>
    </a>

    <a href="sales.php" style="color:black;">
        <div class="col-md-3">
           <div class="panel panel-box clearfix">
             <div class="panel-icon pull-left bg-green">
              <i class="glyphicon glyphicon-usd"></i>
            </div>
            <div class="panel-value pull-right">
              <p class="text-muted">Sales</p>
              <p class="text-muted"><?php echo $total_sales; ?></p>
            </div>
           </div>
        </div>
    </a>
</div>

<div class="row">
   <div class="col-md-4">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Product by Quantity</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
          <thead>
           <tr>
             <th>Title</th>
             <th>Total Quantity</th>
           </tr>
          </thead>
          <tbody>
           <?php foreach ($highest_selling_items as $item): ?>
           <tr>
             <td><?php echo htmlspecialchars($item['title']); ?></td>
             <td><?php echo htmlspecialchars($item['total_quantity']); ?></td>
           </tr>
           <?php endforeach; ?>
          </tbody>
         </table>
       </div>
     </div>
   </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<?php
// Functions to fetch data from the database
function find_total_users() {
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM users";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

function find_total_categories() {
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM categories";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

function find_total_products() {
    global $db;
    $sql = "SELECT COUNT(*) AS total FROM sale";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

function find_total_sales() {
    global $db;
    $sql = "SELECT SUM(total) AS total FROM sale";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return number_format($row['total'], 2);
}

function find_highest_selling_items() {
  global $db;
  $sql = "SELECT item AS title, SUM(qty) AS total_quantity
          FROM sale
          GROUP BY item
          HAVING total_quantity > 0
          ORDER BY total_quantity DESC
          LIMIT 10";
  $result = $db->query($sql);
  return $result->fetch_all(MYSQLI_ASSOC);
}

?>
