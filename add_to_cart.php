<?php
  $page_title = 'Add to Cart';
  require_once('includes/load.php');
  page_require_level(3);
;

  // Fetch items and prices from Sales table
  $items = array();
  $sql = "SELECT id, item, price, qty FROM Sale";
  $result = $db->query($sql);
  while ($row = $result->fetch_assoc()) {
    $items[] = $row;
  }

  include_once('layouts/header.php');
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
  <?php echo display_msg($msg); ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add to Cart</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="actions/add_to_cart_actions.php">
          <div class="form-row">
          <div class="form-group col-md-6">
            <label for="item">Item</label>
            <select class="form-control" id="item" name="item">
                <?php foreach ($items as $item): ?>
                <option value="<?php echo $item['id']; ?>" data-price="<?php echo $item['price']; ?>">
                    <?php echo htmlspecialchars($item['item']) . ' - $' . number_format($item['price'], 2); ?>
                </option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="form-group col-md-2">
              <label for="qty">Qty</label>
              <input type="number" class="form-control" id="qty" name="qty" placeholder="Quantity">
            </div>
            <div class="form-group col-md-2 align-self-end">
              <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
            </div>
          </div>
        </form>
        <h3 class="text-center">Cart</h3>
        <table class="table table-bordered cart-table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Example row, this should be generated dynamically -->
            <tr>
              <td>Example Item 1</td>
              <td>$10.00</td>
              <td>2</td>
              <td>$20.00</td>
              <td><i class="fas fa-trash delete-icon"></i></td>
            </tr>
            <!-- End of example row -->
          </tbody>
        </table>
        <div class="cart-summary">
          <h4>Subtotal: $20.00</h4>
          <button class="btn btn-primary">Proceed To Checkout</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const itemSelect = document.getElementById('item');
      const qtyInput = document.getElementById('qty');

      itemSelect.addEventListener('change', updatePrice);
      qtyInput.addEventListener('input', updatePrice);

      function updatePrice() {
        const selectedItem = itemSelect.options[itemSelect.selectedIndex];
        const price = parseFloat(selectedItem.dataset.price) || 0;
        const qty = parseInt(qtyInput.value) || 0;
        const total = price * qty;
        document.getElementById('total').innerText = '$' + total.toFixed(2);
      }
    });
  </script>
</body>
</html>

<?php include_once('layouts/footer.php'); ?>
