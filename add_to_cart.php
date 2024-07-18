<?php
$page_title = 'Add to Cart';
require_once('includes/load.php');
page_require_level(3);
include_once('layouts/header.php');

// Fetch items and prices from Sales table
$items = array();
$sql = "SELECT id, item, price, qty FROM Sale";
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
    <?php echo display_msg($msg); ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add to Cart</span>
        </strong>
      </div>
      <div class="panel-body">
        <form id="cart-form">
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
              <button type="button" class="btn btn-primary btn-block" id="add-to-cart-btn">Add to Cart</button>
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
          <tbody id="cart-body">
            <!-- Append Cart Items dynamically -->
          </tbody>
        </table>
        <div class="cart-summary">
          <h4>Subtotal: $<span id="subtotal">0.00</span></h4>
          <button onclick="payWithPaystack()" class="btn btn-primary">Proceed To Checkout</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
  const cart = [];
  const itemSelect = document.getElementById('item');
  const qtyInput = document.getElementById('qty');
  const addToCartBtn = document.getElementById('add-to-cart-btn');
  const cartBody = document.getElementById('cart-body');
  const subtotalEl = document.getElementById('subtotal');
  const messageEl = document.getElementById('message');

  addToCartBtn.addEventListener('click', function() {
    const selectedItem = itemSelect.options[itemSelect.selectedIndex];
    const itemId = selectedItem.value;
    const itemName = selectedItem.text.split(' - ')[0];
    const price = parseFloat(selectedItem.dataset.price) || 0;
    const qty = parseInt(qtyInput.value) || 0;

    if (qty > 0) {
      // AJAX request to add/update item in cart in database
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'actions/add_to_cart_actions.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            const existingItemIndex = cart.findIndex(item => item.id === itemId);
            if (existingItemIndex > -1) {
              cart[existingItemIndex].qty += qty;
            } else {
              cart.push({ id: itemId, name: itemName, price: price, qty: qty });
            }
            updateCartTable();
            messageEl.innerHTML = '<div class="alert alert-success">Item added to cart successfully.</div>';
          } else {
            messageEl.innerHTML = '<div class="alert alert-danger">' + response.message + '</div>';
          }
        }
      };
      xhr.send(`item=${itemId}&qty=${qty}`);
    }
  });

  window.removeFromCart = function(itemId) {
    // AJAX request to remove item from cart in database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'actions/delete_cart_actions.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          const itemIndex = cart.findIndex(item => item.id === itemId);
          if (itemIndex > -1) {
            cart.splice(itemIndex, 1);
            updateCartTable();
          }
        } else {
          messageEl.innerHTML = '<div class="alert alert-danger">' + response.message + '</div>';
        }
      }
    };
    xhr.send(`item=${itemId}`);
  }

  function updateCartTable() {
    cartBody.innerHTML = '';
    let subtotal = 0;

    cart.forEach(item => {
      const total = item.price * item.qty;
      subtotal += total;
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${item.name}</td>
        <td>$${item.price.toFixed(2)}</td>
        <td>${item.qty}</td>
        <td>$${total.toFixed(2)}</td>
        <td><i class="fas fa-trash delete-icon" onclick="removeFromCart('${item.id}')"></i></td>
      `;
      cartBody.appendChild(row);
    });

    subtotalEl.innerText = subtotal.toFixed(2);
  }
});
  </script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
  <script>
  <!--::footer_part end::-->
  function payWithPaystack() {
  const subtotal = parseFloat(document.getElementById('subtotal').innerText) * 100; // Convert to the lowest currency unit
  var handler = PaystackPop.setup({
    key: 'pk_test_ab49a5d290b88ba99712d41d80b66b14ae01a751', 
    email:'judercionhauche@gmail.com', // the amount value is multiplied by 100 to convert to the lowest currency unit
    amount: subtotal, // the amount value is multiplied by 100 to convert to the lowest currency unit
    currency: 'GHS', 
    ref: '' + Math.floor(Math.random() * 1000000 + 1),
    callback: function(response) {
      //this happens after the payment is completed successfully
      var reference = response.reference;
      // window.location.href = "confirmation.php?ref=" + reference;
      window.location.href = "actions/success.php?ref=" + reference;

      // alert('Payment complete! Reference: ' + reference);
    },
    onClose: function() {
      alert('Transaction was not completed, window closed.');
    },
  });
  handler.openIframe();
}
</script>
</body>
</html>
<?php include_once('layouts/footer.php'); ?>
