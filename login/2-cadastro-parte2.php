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
	
	body {
		overflow-x: hidden;
		overflow-y: hidden;
	}

	<body class='hold-transition register-page'>

		<div class='register-box'>
			<div class='register-logo col-12'>
				<br><br><br><center><b>NEWAITER</b></center>
			</div>
			<div class='card'>
			<div class='card-body'>
			
				<p class='login-box-msg' style='font-size:20px;' ><b>CADASTRE-SE</b></p>
				<p class='login-box-msg' style='font-size:14px;' >Login/Senha</p>
				
				<div style='color:blue;'>
					<center><b><u><? echo $verificacao; ?></u></b></center><br>
				</div>
 
				<form name='envia_cadastro' id='envia_cadastro' method='post' action='https://www.newaiter.com.br/newaiter/login/post.php'>
				
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
					
					<button type='submit' id='btn_enviar_cadastro_parte2' name='btn_enviar_cadastro_parte2' value='btn_enviar_cadastro_parte2' class='btn btn-block btn-outline-primary btn-sm'>Continuar</button>
				</form>

			</div>
		  </div>
		</div>
	
	</body>
	
</html>