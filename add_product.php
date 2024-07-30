<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('includes/load.php');

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

if (isset($_POST['add_product'])) {
    $date = make_date();
    $product_quantity = remove_junk($db->escape($_POST['product-quantity']));
    $cat = remove_junk($db->escape($_POST['product-category']));
    $price = remove_junk($db->escape($_POST['price']));
    $product_title = remove_junk($db->escape($_POST['product-title']));
    $brand_name = remove_junk($db->escape($_POST['brand_name']));
    $product_quantity = remove_junk($db->escape($_POST['product-quantity']));
    $barcode = remove_junk($db->escape($_POST['barcode']));
    $query  = "INSERT INTO products (";
    $query .= "item,brand_name,barcode,qty,price,category_id,date";
    $query .= ") VALUES (";
    $query .= " '{$product_title}','{$brand_name}','{$barcode}','{$product_quantity}','{$price}','{$cat}', '{$date}'";
    $query .= ")";
    $query .= " ON DUPLICATE KEY UPDATE item='{$product_title}'";
    if ($db->query($query)) {
        $session->msg('s', "Product added ");
        redirect('add_product.php', false);
    } else {
        $session->msg('d', ' Sorry failed to add product!');
        redirect('product.php', false);
    }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add New Mecine to Stock</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="add_product.php" class="clearfix">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <input type="text" class="form-control" name="product-title" placeholder="Product Title" value="<?php echo htmlspecialchars($product_title); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="brand_name" placeholder="Brand Name" value="<?php echo htmlspecialchars($brand_name); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-shopping-cart"></i>
                                        </span>
                                        <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity" value="<?php echo htmlspecialchars($product_quantity); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-usd"></i>
                                        </span>
                                        <input type="number" class="form-control" name="price" placeholder="Price" step="0.01" value="<?php echo htmlspecialchars($price); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <input type="text" class="form-control" name="barcode" placeholder="Barcode" value="<?php echo htmlspecialchars($barcode); ?>">
                                        <span class="input-group-addon"></span>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" name="product-category">
                                        <option value="">Select Product Category</option>
                                        <?php foreach ($all_categories as $cat) : ?>
                                            <option value="<?php echo $cat['id'] ?>">
                                                <?php echo $cat['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" name="get_product" class="btn btn-danger">Get product</button>
                                <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>