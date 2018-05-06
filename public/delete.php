<?php

require "../config/config.php";

session_start();

if (isset($_POST['excluir']) && isset($_POST['id_contato']) ) {
	
	try {
		$conn = new PDO($dsn, $username, $password, $options);
		
		$sql = "DELETE FROM tbl_contato WHERE id_contato = :john";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':john' => $_POST['id_contato']));
		
		$_SESSION['success'] = 'O contato foi excluído com sucesso.';
		
		header('Location: index.php');		
		
	} catch(PDOException $error) {
		echo $error->getMessage();
	}
}
	try {
		$conn = new PDO($dsn, $username, $password, $options);
		
		$stmt = $conn->prepare("SELECT fnome, lnome, id_contato FROM tbl_contato WHERE id_contato = :doe");
		$stmt->execute(array(":doe" => $_GET['id_contato']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC); 
		if ($row == false) {
			header('Location: index.php');
		}
	} catch(PDOException $error) {
		echo $error->getMessage();
	}
	
?>

<?php
require "templates/header.php";
?>

<center>
	<h2>Deseja excluir <?= htmlentities($row['fnome']) . " " . htmlentities($row['lnome']) ?> ?</h2>
		<form method="post">
			<input type="hidden" name="id_contato" value="<?= $row['id_contato'] ?>">
			<input type="submit" value="Excluir" name="excluir">
		</form>
</center>

<?php
require "templates/footer_add_voltar.php";
?>

