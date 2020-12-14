<?
	
	session_start();
	ob_start();
	
	if(isset($_SESSION['VERICACOES'])){
		$verificacao =  $_SESSION['VERICACOES'];
	} else {
		$verificacao = '';
	}

?>

</style>
<!DOCTYPE html>

<html>

	<head>
		<meta charset='utf-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<title>NEWAITER</title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/admin/dist/css/adminlte.css'>
		
	</head>
	
	<body class='hold-transition register-page'>
 
		<div class='container-fluid'>
			<div class='row justify-content-center'>
				<div class='col-12 col-md-8 col-lg-4'>
					<div class='card'>
						<div class='card-body'>
						<center><img src='https://www.newaiter.com.br/newaiter/imagens/logo/newaiter.png'></center><br>
							<p class='login-box-msg' style='font-size:20px;'>CADASTRE-SE</p>
							
							<div style='color:blue;'>
								<center><b><u><? echo $verificacao; ?></u></b></center><br>
							</div>
			 
							<form name='envia_cadastro' id='envia_cadastro' method='post' action='https://www.newaiter.com.br/newaiter/login/post.php'>
							
								<div class='row'>
									<div class='col-12'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Nome Completo</font></label>
											<input style='text-transform: uppercase;' type='text' id='nome' name='nome' class='form-control' maxlength='200' required>
										</div>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-6'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>CPF</font></label>
											<input style='text-transform: uppercase;' type='text' id='cpf' name='cpf' class='form-control' maxlength='14' required>
										</div>
									</div>
         
									<div class='col-6'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>RG</font></label>
											<input style='text-transform: uppercase;' type='text' id='rg' name='rg' class='form-control' maxlength='12' required>
										</div>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-3'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>DDD</font></label>
											<input style='text-transform: uppercase;' type='text' id='ddd_telefone' name='ddd_telefone' class='form-control' minlength='2' maxlength='2' required>
										</div>
									</div>
									<div class='col-9'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Telefone</font></label>
											<input style='text-transform: uppercase;' type='text' id='telefone' name='telefone' class='form-control' maxlength='9' required>
										</div>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-3'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>DDD</font></label>
											<input style='text-transform: uppercase;' type='text' id='ddd_celular' name='ddd_celular' class='form-control' minlength='2' maxlength='2' required>
										</div>
									</div>
									<div class='col-9'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Celular</font></label>
											<input style='text-transform: uppercase;' type='text' id='celular' name='celular' class='form-control' maxlength='11' required>
										</div>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-9'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Rua</font></label>
											<input style='text-transform: uppercase;' type='text' id='rua' name='rua' class='form-control' maxlength='200' required>
										</div>
									</div>
								
									<div class='col-3'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Número</font></label>
											<input style='text-transform: uppercase;' type='text' id='numero' name='numero' class='form-control' maxlength='8' required>
										</div>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-12'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Bairro</font></label>
											<input style='text-transform: uppercase;' type='text' id='bairro' name='bairro' class='form-control' maxlength='200'required>
										</div>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-9'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Cidade</font></label>
											<input style='text-transform: uppercase;' type='text' id='cidade' name='cidade' class='form-control' maxlength='200' required>
										</div>
									</div>
									<div class='col-3'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Estado</font></label>
											<input style='text-transform: uppercase;' type='text' id='estado' name='estado' class='form-control' minlength='2' maxlength='2' required>
										</div>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-12'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Email</font></label>
											<input style='text-transform: uppercase;' type='email' id='login' name='login' class='form-control' placeholder='Esse será o seu login' minlength='6' maxlength='50' required>
										</div>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-12'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Senha</font></label>
											<input style='text-transform: uppercase;' type='text' id='senha' name='senha' class='form-control' minlength='6' maxlength='16' required>
										</div>
									</div>
								</div>

								<div class='row'>
									<div class='col-12'>
										<div class='form-group'>
											<label>
											<font style='vertical-align: inherit; font-size:12px;'>Confirmação da Senha</font></label>
											<input style='text-transform: uppercase;' type='text' id='confirmacao_senha' name='confirmacao_senha' class='form-control' minlength='6' maxlength='16' required>
										</div>
									</div>
								</div>
								
								<button type='submit' id='btn_enviar_cadastro' name='btn_enviar_cadastro' value='btn_enviar_cadastro' class='btn btn-block btn-outline-danger btn-sm'>Continuar</button>
								   
							</form>
							
							<button type='submit' id='btn_voltar' name='btn_voltar' value='btn_voltar' class='btn btn-block btn-outline-danger btn-sm' onclick="location.href='https://www.newaiter.com.br/newaiter/login/1-login.php'">Voltar</button>
							
						</div>
					</div>
				</div>

			</div>
		</div>
		
	</body>
	
</html>