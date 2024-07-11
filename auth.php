<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

if(empty($errors)){
  $user_id = authenticate($username, $password);
  if($user_id){
    //create session with id
     $session->login($user_id);
     $_SESSION['username']= $username;
    //Update Sign in time
     updateLastLogIn($user_id);
     $session->msg("s", "Welcome to Meditrack Management System");
     redirect('home.php',false);

  } else {
    $session->msg("d", "Sorry Username/Password incorrect.");
    redirect('index.php',false);
  }

} else {
   $session->msg("d", $errors);
   redirect('index.php',false);
}


// function to authenticate user
//function to update last login of user
//function to display message
//function to redirect user
?>
