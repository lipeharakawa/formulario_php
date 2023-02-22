<?php 
	include 'header.php';
	$pagina_atual = 'valida-formularios';
?>

<?php
	function clean_input($data) {
		$cleandata = trim($data);
		$cleandata = stripslashes($cleandata);
		$cleandata = htmlspecialchars($cleandata);

		return $cleandata;
	}
?>

	<body>
		<h2>Cadastro de dados</h2><hr>

		<h3>Envie seus dados</h3>

			<?php
				$nome = '';
				$email = '';
				$cpf = '';
				$endereco = '';
				$data_nasc = '';
				$erro_nome = '';
				$erro_email = '';
				$erro_cpf = '';
				$erro_endereco = '';
				$erro_data_nasc  = '';
				$msg_envio  = '';

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$nome = $_POST['nome'];
					$email = $_POST['email'];
					$cpf = $_POST['cpf'];
					$endereco = $_POST['endereco'];
					$data_nasc = $_POST['data_nasc'];
					
					if ($nome == "") {
						$erro_nome = '* O nome é obrigatório';
					} elseif ($email == "") {
						$erro_email = '* O e-mail é obrigatório';
					} elseif ( filter_var($email,FILTER_VALIDATE_EMAIL) == false) {
						$erro_email = '* O e-mail informado é inválido';
					} elseif ($cpf == "") {
						$erro_cpf = '* O CPF é obrigatório';
					} elseif ($endereco == "") {
						$erro_endereco = '* O endereço é obrigatório';
					} elseif ($data_nasc == "") {
						$erro_data_nasc = '* A data de nascimento é obrigatório';
					} else {
						$nome = clean_input($nome);
						$email = clean_input($email);
						$cpf = clean_input($cpf);
						$endereco = clean_input($endereco);
						$data_nasc = clean_input($data_nasc);

						$server = 'localhost';
						$user = 'root';
						$password = '';
						$dbname = 'cadastro_php';
						$port = '3306';

						$db_connect = new mysqli($server, $user, $password, $dbname, $port);

						if ($db_connect->connect_error == true) {
								$msg_envio =  'Não foi possível enviar o formulário.';
						} else {
								
							$sql = "INSERT INTO dados_pessoas(nome, email, cpf, endereco, data_nasc) VALUES ('$nome', '$email', '$cpf', '$endereco', '$data_nasc')";

							if ($db_connect->query($sql) == true) {
								$msg_envio =  'Formulário enviado com sucesso.';
							} else {
								$msg_envio =  'Não foi possível enviar o formulário.';
							}
						}
					}
				}
			?>
		
			<form action="valida-formularios.php" method="post">
				Nome: *
				<br>
				<input type="text" class="field" name="nome" value="<?php echo $nome; ?>">
				<br>
				<div class="erro-form"><?php echo $erro_nome; ?></div>
				<br>
				
				E-mail: *
				<br>
				<input type="text" class="field" name="email" value="<?php echo $email; ?>">
				<div class="erro-form"><?php echo $erro_email; ?></div>
				<br>

				CPF: *
				<br>
				<input type="text" class="field" name="cpf" value="<?php echo $cpf; ?>">
				<div class="erro-form"><?php echo $erro_cpf; ?></div>
				<br>

				Endereço: *
				<br>
				<input type="text" class="field" name="endereco" value="<?php echo $endereco; ?>">
				<div class="erro-form"><?php echo $erro_endereco; ?></div>
				<br>

				Data de nascimento: *
				<br>
				<input type="text" class="field" name="data_nasc" value="<?php echo $data_nasc; ?>">
				<div class="erro-form"><?php echo $erro_data_nasc; ?></div>
				<br><br>

				<input type="submit" name="submit" class="submit"><br>
				<div class="sucesso-form"><?php echo $msg_envio; ?></div>
			</form>
			<br><br>

		<h2>Dados cadastrados</h2><hr>

		<h3>Dados dos clientes</h3>

			<?php 
				$server = 'localhost';
				$user = 'root';
				$password = '';
				$dbname = 'cadastro_php';
				$port = '3306';

				$db_connect = new mysqli($server, $user, $password, $dbname, $port);

				if ($db_connect->connect_error == true) {
						echo 'falha na conexão: ' . $db_connect->connect_error;
				} else {
						//echo 'conexão feita com sucesso' . '<br>';

					$sql = "SELECT * FROM dados_pessoas";

					$result = $db_connect->query($sql); ?>

					<table>
						<tr>
							<th>Nome</th>
							<th>E-mail</th>
							<th>CPF</th>
							<th>Endereço</th>
							<th>Data de nascimento</th>
						</tr>
						<?php while ($row = $result->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $row['nome']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><?php echo $row['cpf']; ?></td>
							<td><?php echo $row['endereco']; ?></td>
							<td><?php echo $row['data_nasc']; ?></td>
						</tr>
						<?php } ?>
					</table>
			<?php } ?>

		<?php include 'functions/bottom_index.php'; ?>
	</body>
</html>