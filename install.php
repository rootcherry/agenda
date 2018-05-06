<?php
require "config/config.php";

try {
	$conn = new PDO ("mysql:host=$host", $username, $password, $options);
	$sql = file_get_contents ("data/init.sql");
	$conn->exec($sql);
	
	echo "Banco de dados e tabelas foram criadas.";
} catch (PDOException $error) {
	echo $sql . "<br>" . $error->getMessage();
}
?>