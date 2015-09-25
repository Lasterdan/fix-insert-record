<?php require_once('Connections/usuarios.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  	mysql_select_db($database_usuarios, $usuarios);
/* Start */
	$result = mysql_query("SELECT username FROM users WHERE username = '".$_POST['username']."'", $usuarios);
	if($result == true)
	{
		$data = mysql_fetch_array($result);
	}
	if($data['username'] == $_POST['username'])
	{ 
		header ("Location: Error.php"); 
	} else {
		$insertSQL = sprintf("INSERT INTO users (username) VALUES (%s)",
                       GetSQLValueString($_POST['username'], "text"));
		$Result1 = mysql_query($insertSQL, $usuarios) or die(mysql_error());		
		$insertGoTo = "Registered.php";
		if (isset($_SERVER['QUERY_STRING'])) 
		{
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
		header(sprintf("Location: %s", $insertGoTo));
	}
/* End */	
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Prueba</title>
</head>
    
<body>
<form method="POST" action="<?php echo $editFormAction; ?>" name="form">
     <input type="text" name="username"/>
     <input type="hidden" name="MM_insert" value="form">
     <input type="submit">
</form>
</body>
</html>
