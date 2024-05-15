<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('includes/load.php');

// Retrieving all user groups from the database
$groups = find_all('user_groups');
?>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('includes/load.php');

// Retrieving all user groups from the database
$groups = find_all('user_groups');

// Function to check if username already exists


// Checking if form is submitted to add a new user
if (isset($_POST['add_user'])) {
    // Required fields for adding a user
    $req_fields = array('first-name', 'last-name', 'username', 'password', 'level');
    // Validating required fields
    validate_fields($req_fields);

    // Validating first name
    if (isset($_POST['first-name']) && ctype_digit($_POST['first-name'])) {
        $errors[] = "First name cannot consist solely of digits.";
    }

    // Validating last name
    if (isset($_POST['last-name']) && ctype_digit($_POST['last-name'])) {
        $errors[] = "Last name cannot consist solely of digits.";
    }

    // Validating username
    if (!preg_match('/^\D.*$/', $_POST['username'])) {
        $errors[] = "Username cannot be only digits.";
    }

    // Validating password using regex
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['password'])) {
        $errors[] = "Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, and one digit.";
    }

    // Checking if username already exists
    $username = remove_junk($db->escape($_POST['username']));
    $existing_user = find_by_username($username);
    if ($existing_user) {
        $errors[] = "Username already exists.";
    }

    // If there are no validation errors
    if (empty($errors)) {
        // Escaping and sanitizing input data
        $first_name = remove_junk($db->escape($_POST['first-name']));
        $last_name = remove_junk($db->escape($_POST['last-name']));
        $username = remove_junk($username); // Already sanitized
        $password = remove_junk($db->escape($_POST['password']));
        $user_level = (int)$db->escape($_POST['level']);
        // Hashing the password
        $password = sha1($password);
        // Constructing SQL query to add user
        $query = "INSERT INTO users (";
        $query .= "first_name,last_name,username,password,user_level,status";
        $query .= ") VALUES (";
        $query .= " '{$first_name}','{$last_name}', '{$username}', '{$password}', '{$user_level}','1'";
        $query .= ")";
        // Executing the query
        if ($db->query($query)) {
            // Success message
            $session->msg('s', "User account has been created! ");
            // Redirecting to login page
            redirect('login_v2.php', false);
        } else {
            // Failure message
            $session->msg('d', ' Sorry failed to create account!');
            // Redirecting back to add user page
            redirect('add_user.php', false);
        }
    } else {
        // If there are validation errors, display error message
        $session->msg("d", $errors);
        // Redirecting back to add user page
        redirect('add_user.php', false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Add New User</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-6">
        <form method="post" action="add_user.php">
          <div class="form-group">
            <label for="name">First Name</label>
            <input type="text" class="form-control" name="first-name" placeholder="First Name" value="<?php echo isset($_POST['full-name']) ? htmlspecialchars($_POST['full-name']) : ''; ?>">
          </div>
          <div class="form-group">
            <label for="name">Last Name</label>
            <input type="text" class="form-control" name="last-name" placeholder="Last Name" value="<?php echo isset($_POST['last-name']) ? htmlspecialchars($_POST['last-name']) : ''; ?>">
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="level">User Role</label>
            <select class="form-control" name="level">
              <?php foreach ($groups as $group) : ?>
                <option value="<?php echo $group['group_level']; ?>"><?php echo ucwords($group['group_name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
          </div>
        </form>
      </div>

    </div>

  </div>
</div>

<!-- <?php include_once('layouts/footer.php'); ?> -->