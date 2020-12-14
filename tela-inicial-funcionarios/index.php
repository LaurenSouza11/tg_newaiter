<?
 
// ==========================================
//             		INDEX
// ==========================================

if(!isset($_SESSION)) {
	session_start();
}
  
date_default_timezone_set('America/Sao_Paulo');
ob_start();
   
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['LOGIN'])) {
	
	if(isset($_SESSION['NOME_USUARIO'])){
		$userName = $_SESSION['NOME_USUARIO'];
	} else {
		$userName = '';
	}
	 
	// ***** ARQUIVOS E FUNÇÕES

	require($_SERVER['DOCUMENT_ROOT'].'newaiter/estrutura/cabecalho-rodape.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	// ***** VARIÁVEIS
	
	$DB = connect_pdo_mysql();
	$cabecalho = cabecalho('NEWAITER', 'NEWAITER', $userName , '');
	$rodape = rodape();
				 			
	echo $cabecalho;		
							 
	?>
   
	<div class='container-fluid'>
		<div class='row justify-content-center' align='center'>
		
			<div class='col-12'>
				<br><h3 style='color:red'><b>ESCOLHA UMA OPÇÃO</b></h3><br>
			</div>
			
			<div class='col-12 col-md-6 col-lg-6 col-xl-4' onclick="location.href='https://www.newaiter.com.br/newaiter/tela-inicial/escolha-do-local.php'">
			  <div class='thumbnail' >					 
				<img src='https://www.newaiter.com.br/newaiter/imagens/tela-inicial-index/comer-no-local.jpg' alt='Comer no local' style='width:auto'>		
					<p style='color:black;'><u>COMER NO LOCAL</u></p>
				</div>
			</div>
			 
			<div class='col-12 col-md-6 col-lg-6 col-xl-4'>
			  <div class='thumbnail'>
				  <img src='https://www.newaiter.com.br/newaiter/imagens/tela-inicial-index/em-breve.png' alt='Delivery' style='width:auto'>
				  <div class='caption'>
					<p>DELIVERY/RETIRADA</p>
				  </div>
			  </div>
			</div>
			
		</div>
	</div>
 
	<?

		echo $rodape;
	
} else {
	$_SESSION['VERICACOES'] = 'POR FAVOR, REALIZE O LOGIN PARA CONTINUAR';
	header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
}
	
?>