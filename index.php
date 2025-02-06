<?php 
error_reporting(0); 
$salt ="Tv3mLPeWRhL9PBTWgnUxLRlOmA41ExgO"; # pass your salt value in this variable
$amount = $_POST["amount"]; # amount need to be picked up from your database 

$reverseHash = generateReverseHash(); 

if ($_POST["hash"] == $reverseHash) 
{ 
  # transaction is successful 
  # do the required javascript task 
  echo("Transaction Success & Verified"); 
  AndroidSuccess($_POST["amount"]); 
} 
else
{ 
  # transaction is tampered 
  # handle it as required 
  echo("<br>"); 
  echo "\nInvalid transaction"; 
} 

# For Android Success 
function AndroidSuccess($input) 
{ 
  echo '<script type="text/javascript">'; 
  echo 'PayU.onSuccess("Amount =" +'.$_POST["amount"].')'; 
  echo "</script>"; 
} 

# Function to generate a reverse hash 
function generateReverseHash() 
{ 
  global $salt; 
  global $amount; 

  if ($_POST["additional_charges"] != null) 
  { 
    $reversehash_string = $_POST["additional_charges"] . "|" . $salt . 
    "|" . $_POST["status"] . "||||||" . $_POST["udf5"] . "|" . $_POST["udf4"] . "|" . $_POST["udf3"] . "|" . $_POST["udf2"] . "|" . $_POST["udf1"] . "|" . $_POST["email"] . "|" . $_POST["firstname"] . "|" . $_POST["productinfo"] . "|" . $amount . "|" . $_POST["txnid"] . "|" . $_POST["key"] ; 
  } 
  else
  { 
    $reversehash_string = $salt . "|" . $_POST["status"] . "||||||" . $_POST["udf5"] . "|" . $_POST["udf4"] . "|" . $_POST["udf3"] . "|" . $_POST["udf2"] . "|" . $_POST["udf1"] . "|" . $_POST["email"] . "|" . $_POST["firstname"] . "|" . $_POST["productinfo"] . "|" . $amount . "|" . $_POST["txnid"] . "|" . $_POST["key"] ; 
  } 

  // echo($reversehash_string); 

  $reverseHash = strtolower(hash("sha512", $reversehash_string)); 
  return $reverseHash; 
} 
?>

