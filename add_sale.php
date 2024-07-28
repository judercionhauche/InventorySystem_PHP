<?php
  $page_title = 'Add Sale';
  require_once('includes/load.php');
  page_require_level(3);
  
  // Fetch categories from the database
  $categories = array();
  $sql = "SELECT id, `name` FROM categories";
  $result = $db->query($sql);
  while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
  }
  
  include_once('layouts/header.php');
  
  
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  // Checkin What level user has permission to view this page
  $all_categories = find_all('categories');
  
  $product_title = '';
  $brand_name = '';
  $size = '';
  
  $barcode = '';
  
  if (isset($_POST['get_product'])) {
      $barcode = $_POST['barcode'];
      $product_details = get_product_by_barcode($barcode);
  
      if ($product_details) {
          $product_title = $product_details['name'] ?? '';
          $brand_name = $product_details['brand_name'] ?? '';
          $size = $product_details['size'] ?? '';
      } else {
          $session->msg('d', 'Product not found.');
      }
  }
?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add Sale</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Search by Barcode</th>
              </tr>
            </thead>
            <tbody id="">
              <tr>
                <td><input type="number" class="form-control item" name="barcode" placeholder="Barcode" value="<?php echo htmlspecialchars($barcode); ?>" required></td>
                <!-- <td><button type="submit" class="btn btn-primary">Search</button></td> -->
                <td><button type="submit" name="get_product" class="btn btn-danger">Get product</button></td>
              </tr>
            </tbody>
          </table>
        </form>
        <form method="post" action="actions/add_sale_actions.php">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Item</th>
                <th>Brand</th>
                <th>Price ($)</th>
                <th>Qty</th>
                <th>Total ($)</th>
                <th>Category</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="product_info">
              <tr>
                <td><input type="text" class="form-control item" name="item" placeholder="Item name" value="<?php echo htmlspecialchars($product_title); ?>" required></td>
                <input type="hidden" class="form-control item" name="barcode" placeholder="Item name" value="<?php echo htmlspecialchars($barcode); ?>" required>
                <td><input type="text" class="form-control" name="brand_name" placeholder="Brand Name" value="<?php echo htmlspecialchars($brand_name); ?>" required></td>
                <td><input type="number" step="0.01" class="form-control price" name="price" placeholder="Price" required></td>
                <td><input type="number" class="form-control qty" name="qty" placeholder="Quantity" value="<?php echo htmlspecialchars($size); ?>" required></td>
                <td><input type="number" class="form-control total" name="total" placeholder="Total" readonly></td>
                <td>
                  <select class="form-control category" name="category">
                    <?php foreach ($categories as $category): ?>
                      <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td><button type="submit" class="btn btn-danger">Submit Sale</button></td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const productRow = document.querySelector('#product_info tr');
    const priceInput = productRow.querySelector('.price');
    const qtyInput = productRow.querySelector('.qty');
    const totalInput = productRow.querySelector('.total');
  
    // Event listeners to calculate total when price or qty changes
    priceInput.addEventListener('input', updateTotal);
    qtyInput.addEventListener('input', updateTotal);
    priceInput.addEventListener('change', updateTotal);
    qtyInput.addEventListener('change', updateTotal);
  
    // Initial calculation
    updateTotal();
    
    function updateTotal() {
      const price = parseFloat(priceInput.value) || 0;
      const qty = parseInt(qtyInput.value) || 0;
      const total = price * qty;
      totalInput.value = total.toFixed(2); // Display total with 2 decimal places
    }
  
    //Calculating the total price before form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
      
      updateTotal();
    });
  });
</script>
