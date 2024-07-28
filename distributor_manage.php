<?php
$page_title = 'Add to Cart';
require_once('includes/load.php');
page_require_level(3);
include_once('layouts/header.php');
// Fetch items and prices from Sales table
$items = array();
$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            s.item,
            s.price,
            s.qty,
            s.added_date,
            s.barcode,
            s.brand,
            c.name
        FROM 
            sale s
        JOIN 
            categories c ON s.category_id = c.id
        WHERE s.distributor_id = '{$user_id}'";

$result = $db->query($sql);
while ($row = $result->fetch_assoc()) {
  $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add to Cart</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 50px;
    }
    .panel {
      background-color: #ffffff;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .panel-heading {
      background-color: #343a40;
      color: #ffffff;
      padding: 10px 15px;
      border-bottom: 1px solid #dee2e6;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }
    .panel-body {
      padding: 30px;
    }
    .table {
      width: 100%;
      margin-bottom: 1rem;
      background-color: transparent;
    }
    .table th, .table td {
      padding: 1rem;
      vertical-align: middle;
      border-top: 1px solid #dee2e6;
    }
    .table thead th {
      background-color: #e9ecef;
      border-bottom: 2px solid #dee2e6;
    }
    .cart-summary {
      text-align: right;
    }
    .cart-summary h4 {
      margin-top: 20px;
    }
    .btn {
      background-color: #51aded;
      border-color: #007bff;
      color: #ffffff;
    }
    .btn:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
    .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
      color: #ffffff;
    }
    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
    }
    .delete-btn {
      background-color: #dc3545;
      color: #ffffff;
    }
    .delete-btn:hover {
      background-color: #c82333;
      color: #ffffff;
    }
    .delete-icon {
      color: #dc3545;
      cursor: pointer;
    }
    .delete-icon:hover {
      color: #c82333;
    }
  </style>
</head>
<body>
  <div class="container">
      <div class="row">
      <div class="col-md-6">
        <?php echo display_msg($msg); ?>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Current Stock</span>
        </strong>
      </div>
    <div class="panel-body">
        
        <table class="table table-bordered cart-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Product</th>
              <th>Brand</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Barcode</th>
              <th>Category</th>
            </tr>
          </thead>
          <tbody id="cart-body">
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo $item['added_date']; ?></td>
                        <td><?php echo $item['item']; ?></td>
                        <td><?php echo $item['brand']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                        <td><?php echo $item['qty']; ?></td>
                        <td><?php echo $item['barcode']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        
                        <form method="post" action="">
                            <td><button class="btn btn-primary" name="edit" value="edit">Edit</button></td>
                        </form>'
                        
                    </tr>
                <?php endforeach; ?>
            <!-- Append Cart Items dynamically -->
          </tbody>
        </table>

      </div>
    </div>
  </div>
  
</body>
</html>
<?php include_once('layouts/footer.php'); ?>
