<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username','password');
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

if(empty($errors)){
  $user_id = authenticate($username, $password);
  if($user_id){
    // Check user status
    $query = "SELECT status, login_attempts FROM users WHERE id='{$user_id}'";
    $result = $db->query($query);
    $user = $db->fetch_assoc($result);
    
    if($user['status'] == '0'){
      $session->msg("d", "This account is no longer active.");
      redirect('index.php',false);
    } else {
      // Reset login attempts
      $query = "UPDATE users SET login_attempts = 0 WHERE id='{$user_id}'";
      $db->query($query);

      // Create session with id
      $session->login($user_id);
      $_SESSION['username'] = $username;
      // Update Sign in time
      updateLastLogIn($user_id);
      $session->msg("s", "Welcome to Meditrack Management System");
      redirect('home.php',false);
    }
  } else {
    // Fetch user by username to track login attempts
    $query = "SELECT id, login_attempts FROM users WHERE username='{$username}'";
    $result = $db->query($query);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $login_attempts = $user['login_attempts'] + 1;
      if($login_attempts >= 3){
        // Deactivate user after 3 failed attempts
        $query = "UPDATE users SET status = '0' WHERE id='{$user['id']}'";
        $db->query($query);
        $session->msg("d", "Your account has been deactivated due to multiple failed login attempts. Please contact the admin.");
      } else {
        // Increment login attempts
        $query = "UPDATE users SET login_attempts = '{$login_attempts}' WHERE id='{$user['id']}'";
        $db->query($query);
        $session->msg("d", "Sorry, Username/Password incorrect. Attempt {$login_attempts} of 3.");
      }
    } else {
      $session->msg("d", "Sorry, Username/Password incorrect.");
    }
    redirect('index.php',false);
  }
} else {
  $session->msg("d", $errors);
  redirect('index.php',false);
}
?>
