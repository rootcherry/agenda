<?php
require "templates/header.php";
?>

<?php	

	require "../config/config.php";
	
	session_start();
	
	try {
		$conn = new PDO($dsn, $username, $password, $options);
		
		$search_keyword = '';
		if(!empty($_POST['search']['keyword'])) {
			$search_keyword = $_POST['search']['keyword'];
		}
		
		$sql = "select 
					tbl_contato.id_contato,
					tbl_contato.fnome,
					tbl_contato.lnome,
					tbl_contato.email,
					tbl_contato.bday,
					tbl_endereco.cep,
					tbl_endereco.rua,
					tbl_endereco.numero_endereco,
					tbl_endereco.bairro,
					tbl_endereco.cidade,
					tbl_endereco.estado,
					tbl_telefone.numero_telefone
				from	
					tbl_contato
				left join 
					tbl_endereco on tbl_contato.id_contato = tbl_endereco.id_endereco
				left join 
					tbl_telefone on tbl_contato.id_contato = tbl_telefone.id_telefone WHERE fnome LIKE :keyword OR lnome like :keyword";	
	
		$stmt = $conn->prepare($sql);
		$stmt->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
	} catch(PDOException $error) {
		echo $error->getMessage();
	}
	
?>

<br>
			
<form method="post" action="">
	Pesquisar por nome/sobrenome: <input type="text" name="search[keyword]" value="<?php echo $search_keyword; ?>" id='keyword' maxlength='25'>
	<input type="submit" name="submit" value="Enviar">
</form>

<br><br>
<center>
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Nome</th>
			<th>E-mail</th>				
			<th>Aniversário</th>
			<th>Endereco</th>
			<th>Telefone</th>
			<th>Ações</th>
		 </tr>
	</thead>
<tbody>

<?php

if ( isset($_SESSION['success']) ) {
    echo '<p align="center" style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

if ( isset($_SESSION['update']) ) {
    echo '<p align="center" style="color:green">'.$_SESSION['update']."</p>\n";
    unset($_SESSION['update']);
}

if ( isset($_SESSION['delete']) ) {
    echo '<p align="center" style="color:green">'.$_SESSION['delete']."</p>\n";
    unset($_SESSION['delete']);
}

if(!empty($result)) { 
	foreach($result as $row) {
?>
	<tr align="center">
		<td><?php echo $row['id_contato']; ?></td>
		<td><?php echo $row['fnome'] . " " . $row['lnome']; ?></td>
		<td><?php echo $row['email']; ?></td>
		<td><?php echo $row['bday']; ?></td>
		<td><?php echo $row['rua'] . ", " . $row['numero_endereco'] . " - " . $row['bairro'] . "<br>" . $row['cidade'] . " - " . $row['estado'] . ", " . $row['cep']; ?></td>
		<td><?php echo $row['numero_telefone']; ?></td>
		<td><a href="edit.php?id_contato=<?php echo $row['id_contato']; ?>"><img src="../img/edit.png" title="Editar"/></a> <a href="delete.php?id_contato=<?php echo $row['id_contato']; ?>"><img src="../img/delete.png" title="Excluir"/></a></td>
	</tr>
<?php
	}
}

?>
</table>
</center>
<br>
<p align="center">
<a href="add.php">Adicionar Novo Contato</a></p>

<?php
require "templates/footer.php";
?>
