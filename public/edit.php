<?php

require "../config/config.php";

session_start();

if (!empty($_POST['submit'])) {
	
	try {
		$conn = new PDO($dsn, $username, $password, $options);
	
		$stmt_contato = $conn->prepare("update tbl_contato set fnome='" . $_POST['fnome'] . "', lnome='" . $_POST['lnome'] . "', email='" . $_POST['email'] . "', bday='" . $_POST['bday'] . "' where id_contato=" . $_GET['id_contato']);
		$result_contato = $stmt_contato->execute();
		
		$stmt_endereco = $conn->prepare("update tbl_endereco set cep='" . $_POST['cep'] . "', rua='" . $_POST['rua'] . "', numero_endereco='" . $_POST['numero_endereco'] .  "', bairro='" . $_POST['bairro'] .  "', cidade='" . $_POST['cidade'] .  "', estado='" . $_POST['estado'] . "' where id_endereco=" . $_GET['id_contato']);
		$result_endereco = $stmt_endereco->execute();
		
		$stmt_telefone = $conn->prepare("update tbl_telefone set numero_telefone='" . $_POST['numero_telefone'] . "' where id_telefone=" . $_GET['id_contato']);
		$result_estado = $stmt_telefone->execute();
		
		$_SESSION['update'] = 'Os dados do contato foram alterados.';

		header('location:index.php');

	} catch(PDOException $error) {
		echo $error->getMessage();
	}
}

	try {
		$conn = new PDO($dsn, $username, $password, $options);
		
		$stmt_contato = $conn->prepare("select * from tbl_contato where id_contato=" . $_GET['id_contato']);
		$stmt_contato->execute();
		$result_contato = $stmt_contato->fetchAll();

		$stmt_endereco = $conn->prepare("select * from tbl_endereco where id_endereco=" . $_GET['id_contato']);
		$stmt_endereco->execute();
		$result_endereco = $stmt_endereco->fetchAll();

		$stmt_telefone = $conn->prepare("select * from tbl_telefone where id_telefone=" . $_GET['id_contato']);
		$stmt_telefone->execute();
		$result_telefone = $stmt_telefone->fetchAll();
		
	} catch(PDOException $error) {
		echo $error->getMessage();
	}
	
?>

<?php
require "templates/header.php";
?>

<center>
<h2>Editar Contato</h2>
<form method="post">
    <label>Nome</label>
    <input type="text" name="fnome" value="<?php echo $result_contato[0]['fnome']; ?>">
    <label>Sobrenome</label>
    <input type="text" name="lnome" value="<?php echo $result_contato[0]['lnome']; ?>">
    <label>E-mail</label>
    <input type="email" name="email" value="<?php echo $result_contato[0]['email']; ?>">
    <label>Aniversário</label>
    <input type="date" name="bday" value="<?php echo $result_contato[0]['bday']; ?>">
    <label>CEP</label>
    <input type="text" name="cep" value="<?php echo $result_endereco[0]['cep']; ?>">
    <label>Rua</label>
    <input type="text" name="rua" value="<?php echo $result_endereco[0]['rua']; ?>">
    <label>Número</label>
    <input type="text" name="numero_endereco" value="<?php echo $result_endereco[0]['numero_endereco']; ?>">
    <label>Bairro</label>
    <input type="text" name="bairro" value="<?php echo $result_endereco[0]['bairro']; ?>">
    <label>Cidade</label>
    <input type="text" name="cidade" value="<?php echo $result_endereco[0]['cidade']; ?>">
    <label>Estado</label>
    <input type="text" name="estado" value="<?php echo $result_endereco[0]['estado']; ?>">
    <label>Telefone</label>
    <input type="text" name="numero_telefone" value="<?php echo $result_telefone[0]['numero_telefone']; ?>">
  </p><br>
<p><input type="submit"	name="submit" value="Salvar"/>
</form>
</center>

<?php
require "templates/footer_add_voltar.php";
?>



