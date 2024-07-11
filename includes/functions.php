<?php
 $errors = array();

 /*--------------------------------------------------------------*/
 /* Function for Remove escapes special
 /* characters in a string for use in an SQL statement
 /*--------------------------------------------------------------*/
function real_escape($str){
  global $con;
  $escape = mysqli_real_escape_string($con,$str);
  return $escape;
}
/*--------------------------------------------------------------*/
/* Function for Remove html characters
/*--------------------------------------------------------------*/
// In includes/functions.php

// Function to remove junk characters from a string or an array of strings
function remove_junk($string) {
  if(is_array($string)) {
      $cleaned_strings = array();
      foreach($string as $str) {
          $cleaned_strings[] = trim($str); 
      }
      return $cleaned_strings;
  } else {
      return trim($string); 
  }
}

/*--------------------------------------------------------------*/
/* Function for Uppercase first character
/*--------------------------------------------------------------*/
function first_character($string) {
  if(is_array($string)) {
      $first_chars = array();
      foreach($string as $str) {
          $first_chars[] = ucfirst($str);
      }
      return $first_chars;
  } else {
      return ucfirst($string);
  }
}
/*--------------------------------------------------------------*/
/* Function for Checking input fields not empty
/*--------------------------------------------------------------*/
function validate_fields($var){
  global $errors;
  foreach ($var as $field) {
    $val = remove_junk($_POST[$field]);
    if(empty($val)){
      $errors[] = ucfirst(str_replace('-', ' ', $field)) . " can't be blank.";
    }
  }
}
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}
/*--------------------------------------------------------------*/
/* Function for Display Session Message
   Ex echo displayt_msg($message);
/*--------------------------------------------------------------*/
/**

 * Display Messages
 * @param array $msg
 */
function display_msg($msg = array()) {
  $output = ''; // Initialize $output as a string
  if(!empty($msg)) {
     foreach ($msg as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $val) {
                $output .= "<div class=\"alert alert-{$key}\">"; // Concatenate the string with ".="
                $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
                $output .= remove_junk(first_character($val));
                $output .= "</div>";
            }
        } else {
            $output .= "<div class=\"alert alert-{$key}\">"; // Concatenate the string with ".="
            $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
            $output .= remove_junk(first_character($value));
            $output .= "</div>";
        }
     }
     return $output;
  } else {
    return ""; // Return an empty string if $msg is empty
  }
}
//Function  to authenticate user
function authenticate($username='', $password='') {
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if($db->num_rows($result)){
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if($password_request === $user['password'] ){
      return $user['id'];
    }
  }
 return false;
}


/*--------------------------------------------------------------*/
/* Function for redirect
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*--------------------------------------------------------------*/
/* Function for find out total saleing price, buying price and profit
/*--------------------------------------------------------------*/
function total_price($totals){
   $sum = 0;
   $sub = 0;
   foreach($totals as $total ){
     $sum += $total['total_saleing_price'];
     $sub += $total['total_buying_price'];
     $profit = $sum - $sub;
   }
   return array($sum,$profit);
}
/*--------------------------------------------------------------*/
/* Function for Readable date time
/*--------------------------------------------------------------*/
function read_date($str){
     if($str)
      return date('F j, Y, g:i:s a', strtotime($str));
     else
      return null;
  }
/*--------------------------------------------------------------*/
/* Function for  Readable Make date time
/*--------------------------------------------------------------*/
function make_date() {
  return date("Y-m-d H:i:s");
}

/*--------------------------------------------------------------*/
/* Function for  Readable date time
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}
/*--------------------------------------------------------------*/
/* Function for Creating random string
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str='';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x=0; $x<$length; $x++)
   $str .= $cha[mt_rand(0,strlen($cha))];
  return $str;
}

function find_by_username($username) {
  global $db;
  $sql = "SELECT * FROM users WHERE username = '{$username}' LIMIT 1";
  $result = $db->query($sql);
  return $db->fetch_assoc($result);
}

// functions.php

// Your existing functions

function get_product_by_barcode($barcode) {
  $url = "https://www.brocade.io/api/items/" . $barcode;
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  curl_close($ch);

  if ($response === false) {
      return null;
  }

  return json_decode($response, true);
}



?>


