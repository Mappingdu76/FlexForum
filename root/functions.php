<?php
function lang()
{
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	return $lang;
}
Function bdd()
{
	try
	{
		$bdd=new PDO('mysql:host='.CONFIG_SQL_HOST.';dbname='.CONFIG_SQL_DBNAME.';'.CONFIG_SQL_CONFIG.'', CONFIG_SQL_USERNAME, CONFIG_SQL_PASSWORD);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}
	return $bdd;
}
if(isset($_SESSION['id']))
{
	function rang()
	{
		$user_id= $_SESSION['id'];
		$req_user_rang=bdd()->prepare('SELECT rang FROM users WHERE id=?');
		$req_user_rang->execute(array($user_id));
		$user_rang=$req_user_rang->fetch();
		$rang=$user_rang['rang'];
		return $rang;
	}
}
?>
