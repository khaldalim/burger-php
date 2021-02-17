<?php 

class Database{

	private static $dbhost = "localhost";
	private static $dbname = "burger-leo";
	private static $dbuser = "root";
	private static $dbpassword = "";

	private static $connection = null;

	public static function connect(){

		try{
			self::$connection = new PDO("mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname. ";charset=UTF8", self::$dbuser , self::$dbpassword);

			self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// var_dump(self::$connection);

			// echo("<script>alert('Connection BDD success !!!')</script>");
		}

		catch(PDOException $e){
			die("Erreur de la connexion à la BDD" . '<br>Erreur : ' . $e->getMessage());
		}
		return self::$connection;

	}

	public static function disconnect(){
		self::$connection = null;
	}
	
}


Database::connect();


?>