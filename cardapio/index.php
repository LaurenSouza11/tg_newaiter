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
	/*
	if(isset($_SESSION['CHAMAR_VENDEDOR'])){

		$modal = "
		
		<div class='alert alert-success' role='alert'>
		  <h4 class='alert-heading'>Well done!</h4>
		  <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
		  <hr>
		  <p class='mb-0'>Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
		</div>
		
		<script>
			$('.alert').alert()
		</script>
		";
		
		echo $modal;
	}
	*/
	$local = $_SESSION['IMAGEM_LOGO'];
	
	// ***** ARQUIVOS E FUNÇÕES

	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/cabecalho-rodape.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	// ***** VARIÁVEIS
	   
	$DB = connect_pdo_mysql();
	$cabecalho = cabecalho('CARDÁPIO', $_SESSION['LOCAL_SELECIONADO'], $userName , '');
	$rodape = rodape();
	error_log($local);			 			
	echo $cabecalho;	
?>	
  
	<div class='container-fluid'>
		<div class='row'>
			<div>
				<br><h5 style='margin-left: 10px; color:#502F15;'>Caro Bruxo(a)!</h5>
				<h5 style='margin: 0px 10px 0px 15px; color:#502F15;'>Venho convidar você a experimentar nossas poções mágicas com resultados imbativéis, nossos mostruosos burgues capaz de desafiar seu limite, e claro, não podemos esquecer das nossas deliciosas cervejas amanteigadas para lhe dar mais ânimo.</h5>
				<br><h5 style='margin-left: 10px; color:#502F15;'><u>Esse convite é único, você é o ELEITO(A)!</u></h5>
			</div>
		</div>
	</div><br>         
	<div class='container-fluid'>
		<div class='row'>
			<div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>
				<ol class='carousel-indicators'>
					<li data-target='#carouselExampleIndicators' data-slide-to='0' class='active'></li>
					<li data-target='#carouselExampleIndicators' data-slide-to='1'></li>
					<li data-target='#carouselExampleIndicators' data-slide-to='2'></li>
				</ol>
				<div class='carousel-inner'>
					<div class='carousel-item active'>
						<img class='d-block w-100' src='https://www.newaiter.com.br/newaiter/imagens/<? echo $local?>/caroussel/1.png' alt='First slide'>
						<!--
						<div class='carousel-caption'>
							<h5>1</h5>
							<p>Nullam id dolor id nibh ultricies vehicula ut id elit</p>
						</div>
						-->
					</div>
					<div class='carousel-item'>
						<img class='d-block w-100' src='https://www.newaiter.com.br/newaiter/imagens/<? echo $local?>/caroussel/2.png' alt='Second slide'>
					</div>
					<div class='carousel-item'>
						<img class='d-block w-100' src='https://www.newaiter.com.br/newaiter/imagens/<? echo $local?>/caroussel/3.png' alt='Third slide'>
					</div>
				</div>
				  <a class='carousel-control-prev' href='#carouselExampleIndicators' role='button' data-slide='prev'>
						<span class='sr-only'>Previous</span>
				  </a>
				  <a class='carousel-control-next' href='#carouselExampleIndicators' role='button' data-slide='next'>
						<span class='sr-only'>Next</span>
				  </a>
			</div>
		</div>
	</div>
	
	<div class='container-fluid'>
		<div class='row justify-content-center'>
			<center><div><br><br><h5 style='color:#502F15;'><u>ESCOLHA UMA OPÇÃO E ENTRE EM NOSSO MUNDO MÁGICO DE SABORES</u></h5><br></div>
			<div>
				<a href='https://www.newaiter.com.br/newaiter/cardapio/lanches.php'><img border="0" alt="Lanches" src="https://www.newaiter.com.br/newaiter/imagens/<? echo $local?>/item/lanches.png"></a>
				<a href='https://www.newaiter.com.br/newaiter/cardapio/bebidas.php'><img border="0" alt="Bebidas" src="https://www.newaiter.com.br/newaiter/imagens/<? echo $local?>/item/bebidas.png"></a>
				<a href='https://www.newaiter.com.br/newaiter/cardapio/combos.php'><img border="0" alt="Combos" src="https://www.newaiter.com.br/newaiter/imagens/<? echo $local?>/item/combos.png"></a>
			</div></center>
		</div>
	</div><br>     
   
<?
	echo $rodape;
     
} else {
	$_SESSION['VERICACOES'] = 'POR FAVOR, REALIZE O LOGIN PARA CONTINUAR';
	header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
}
	
?>