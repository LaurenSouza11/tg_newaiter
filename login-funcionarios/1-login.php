<?

// ==========================================
//         			LOGIN
// ==========================================

if(!isset($_SESSION)) {
	session_start();
}
    
date_default_timezone_set('America/Sao_Paulo');
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

//unset ($_SESSION['LOGIN']);  
//unset ($_SESSION['NOME_USUARIO']);  
	
if(isset($_SESSION['VERICACOES'])){
	$verificacao = $_SESSION['VERICACOES'];
} else {
	$verificacao = '';
	unset ($_SESSION['VERICACOES']);  
}

?>
<!DOCTYPE html>
<html>
   
	<head>
		<meta charset='utf-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<title>NEWAITER</title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/admin/dist/css/adminlte.css'>
	</head>
	
	<style>
		body  {
		  //background-image: url("https://www.newaiter.com.br/newaiter/imagens/login/teste.gif");
		  background-color: #cccccc;
		}
	</style>
	
	<body class='hold-transition login-page'>
		<div class='login-box' style='margin-top:80px;'>
			<div class='card'>
				<div class='card-body login-card-body'>
					<center><img src='https://www.newaiter.com.br/newaiter/imagens/logo/newaiter.png'></center><br>
					<p class='login-box-msg' style='font-size:20px;'>LOGIN FUNCIONÁRIO</p>
					
					<div style='color:red;'>
						<center><b><u><? echo $verificacao; ?></u></b></center><br>
					</div>
			
					<form method='post' name='envia_login' id='envia_login' action='https://www.newaiter.com.br/newaiter/login-funcionarios/post.php'>
					
						<div class='row'>
							<div class='col-12'>
								<div class='form-group'>
									<label>
									<font style='vertical-align: inherit; font-size: 12px;'>Login</font></label>
									<input style='text-transform: uppercase;' type='text' id='login' name='login'  minlength='3' maxlength='10' class='form-control' maxlength='12' required>
								</div>
							</div>
						</div>
						 
						<div class='row'>
							<div class='col-12'>
								<div class='form-group'>
									<label>
									<font style='vertical-align: inherit; font-size:12px;'>Senha</font></label>
									<input style='text-transform: uppercase;' type='password' id='senha' name='senha' minlength='3' maxlength='10' class='form-control' maxlength='12' required>
								</div>
							</div>
						</div>
				
						<div class='row'>
							<div class='col-6'>
								<button type='submit' id='btn_enviar_login_funcionarios' name='btn_enviar_login_funcionarios' value='btn_enviar_login_funcionarios' class='btn btn-block btn-outline-danger btn-sm'>Entrar</button>
							</div>
						</div>
						
					</form>

				</div>
			</div>
		</div>
			 
	</body>
		
</html>
