<?php

require "../config/config.php";

session_start();

if(!empty($_POST['submit'])) {
	
	try {
		$conn = new PDO($dsn, $username, $password, $options);
		
		if (isset($_POST['submit'])) {
	
			if (empty($_POST['fnome']) || empty($_POST['lnome']) || empty($_POST['email']) || empty($_POST['bday']) || empty($_POST['numero_telefone']) || empty($_POST['cep']) || empty($_POST['rua']) || empty($_POST['numero_endereco']) || empty($_POST['bairro']) || empty($_POST['cidade']) || empty($_POST['estado'])) {
				
				$_SESSION['add'] = 'Todos os campos são obrigatórios!';
				
			} else { 
			
				$sql_contato = "insert into tbl_contato (fnome, lnome, email, bday) values (:fnome, :lnome, :email, :bday)";
				$stmt_contato = $conn->prepare($sql_contato);
				$result_contato = $stmt_contato->execute(array( ':fnome' => $_POST['fnome'], ':lnome' => $_POST['lnome'], ':email' => $_POST['email'], ':bday' => $_POST['bday']));
				
				$sql_telefone = "insert into tbl_telefone (numero_telefone) values (:numero_telefone)";
				$stmt_telefone = $conn->prepare($sql_telefone);
				$result_telefone = $stmt_telefone->execute(array( ':numero_telefone' => $_POST['numero_telefone']));
							
				$sql_endereco = "insert into tbl_endereco (cep, rua, numero_endereco, bairro, cidade, estado) values (:cep, :rua, :numero_endereco, :bairro, :cidade, :estado)";
				$stmt_endereco = $conn->prepare($sql_endereco);
				$result_endereco = $stmt_endereco->execute(array( ':cep' => $_POST['cep'], ':rua' => $_POST['rua'], ':numero_endereco' => $_POST['numero_endereco'], ':bairro' => $_POST['bairro'], ':cidade' => $_POST['cidade'], ':estado' => $_POST['estado']));
				
				$_SESSION['success'] = 'Contato adicionado com sucesso.';
				
				header('location:index.php');
			}
		}
	} catch(PDOException $error) {
		echo $error->getMessage();
	}
	
}/*header('Location: index.php');*/

?>

<?php
require "templates/header_add.php";
?>

<?php
    if ( isset($_SESSION['add']) ) {
    echo '<p align="center" style="color:red">'.$_SESSION['add']."</p>\n";
    unset($_SESSION['add']);
	}
?>

<center>
	<h2>Adicionar Novo Contato</h2>
		<form method="post">
			<label>Nome</label>
			<input type="text" name="fnome">
			<label>Sobrenome</label>
			<input type="text" name="lnome">
			<label>E-mail</label>
			<input type="email" name="email">
			<label>Aniversário</label>
			<input type="date" name="bday">
			<label>CEP</label>
			<input type="text" name="cep" id="cep" onblur="pesquisacep(this.value);" >
			<label>Rua</label>
			<input type="text" name="rua" id="rua">
			<label>Número</label>
			<input type="text" name="numero_endereco">
			<label>Bairro</label>
			<input type="text" name="bairro" id="bairro">
			<label>Cidade</label>
			<input type="text" name="cidade" id="cidade">
			<label>Estado</label>
			<input type="text" name="estado" id="uf">
			<label>Telefone</label>
			<input type="text" name="numero_telefone">
		  </p><br>
		<p><input type="submit"	name="submit" value="Adicionar"/>
	</form>
</center>

<?php
require "templates/footer_add_voltar.php";
?>

