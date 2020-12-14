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
	
	$local = $_SESSION['IMAGEM_LOGO'];
	 
	// ***** ARQUIVOS E FUNÇÕES

	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/cabecalho-rodape.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	
	// ***** VARIÁVEIS
	$array_subgrupo = array();
	$count_subgrupo = 0;
	$pt1 = '';
	$pt2 = '';
	   
	$DB = connect_pdo_mysql();
	$cabecalho = cabecalho('COMBOS', $_SESSION['LOCAL_SELECIONADO'], $userName , '');
	$rodape = rodape();
	
	$query = "SELECT DISTINCT subgrupo, tipo_subgrupo
			  FROM cardapio 
			  INNER JOIN subgrupo_tipo_alimento_bebida
			  ON cardapio.subgrupo = subgrupo_tipo_alimento_bebida.id
			  WHERE ".$local." = 1 AND grupo = 9 ORDER BY tipo_subgrupo;";

	$stmt = $DB->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {

		foreach($result as $row) {
			
			$count_subgrupo = 1;
			
			$subgrupo = $row->subgrupo;
			$tipo_subgrupo = $row->tipo_subgrupo;
			
			$tmp_subgrupo = $subgrupo.'-'.$tipo_subgrupo;
			
			array_push($array_subgrupo, $tmp_subgrupo);
		
		}
	}

	if ($count_subgrupo > 0){
		
		foreach($array_subgrupo as $tmp_subgrupo){
			
			$tmp = explode('-', $tmp_subgrupo);
			$subgrupo = $tmp[0];
			$tipo_subgrupo = $tmp[1];
			
			$pt2 = '';

			$query = "SELECT id, nome, descricao, preco, imagem
					  FROM cardapio
					  WHERE ".$local." = 1 AND grupo = 9 AND subgrupo = :subgrupo;";

			$stmt = $DB->prepare($query);
			$stmt->bindParam(':subgrupo', $subgrupo);	
			$stmt->execute();
			$result = $stmt->fetchAll();

			if (count($result)) {

				foreach($result as $row) {
					
					$id = $row->id;
					$nome = $row->nome;
					$descricao = $row->descricao;
					$preco = $row->preco;
					$imagem = $row->imagem;

					if(strlen($descricao) < 50 AND strlen($nome) < 25){
						$descricao_abrev = $descricao;
						$popover = '';
					
					} else {
						
						if (strlen($nome) > 25){
							$descricao_abrev = substr($descricao, 0,55);
						} else {
							$descricao_abrev = substr($descricao, 0, 60);
						}
		
						$descricao_abrev = $descricao_abrev.' ...';
						$popover = "<i class='fas fa-plus' style='color:red;' data-container='body' data-placement='top' data-toggle='popover' title='".$descricao."'></i>";
					}
 
					$pt2 = $pt2."<div class='col-6 col-md-4 col-lg-4 col-xl-3' style='margin-bottom: 25px;'>
									<div class='card altura-card'>
										<img class='card-img-top' style='height: 90px;' src='https://www.newaiter.com.br/newaiter/imagens/".$local."/cardapio/combos/".$imagem."' alt='Card image cap'>
										<div class='card-body'>
											<h4 class='card-title'><b>".$nome."</b></h4>
											<p class='card-text'>
												".$descricao_abrev.$popover."
											</p> 
											<center><button type='button' id='btn_enviar_cadastro' name='btn_enviar_login' value='btn_enviar_login' class='btn btn-block btn-outline-danger btn-sm' onclick='adicionar_pedido(".$id.");'>Adicionar</button></center>
										</div>  
										<div class='card-footer align-bottom' align='bottom;'>
											<center><small class='text-muted'><b>R$ ".$preco."</b></small></center> 
										</div>
									</div>
								</div>";
				
				}
			}
 
			$pt1 = $pt1."<div class='col-12'>	
				 
						<br><h5 style='margin-bottom: -10px; color:red;'>".$tipo_subgrupo."</h5>
						<hr style='color:#4682B4;'>
						 
						<div class='card-deck' style='margin-top: 10px;'>
							
							".$pt2."
							
						</div>  
					</div>";

		}
		
	} else {
		
		echo 'Vazio';
		
	}
		 			
	echo $cabecalho;	
?>	

	<style>
	
		@media (max-width: 330px){
			.altura-card{
				height: 580px;
			}
		}
		
		@media (min-width: 331px) AND (max-width: 360px){
			.altura-card{
				height: 530px;
			}
		}
	
		@media (min-width: 361px) AND (max-width: 381px){
			.altura-card{
				height: 490px;
			}
		}
		
		@media (min-width: 382px) AND (max-width: 410px){
			.altura-card{
				height: 445px;
			}
		}
		
		@media (min-width: 411px) AND (max-width: 460px){
			.altura-card{
				height: 350px;
			}
		}
		
		@media (min-width: 461px) AND (max-width: 550px){
			.altura-card{
				height: 370px;
			}
		}
		
		@media (min-width: 551px) AND (max-width: 650px){
			.altura-card{
				height: 325px;
			}
		}
		
		@media (min-width: 651px) AND (max-width: 767px){
			.altura-card{
				height: 305px;
			}
		}
		
		@media (min-width: 768px) AND (max-width: 1400px){
			.altura-card{
				height: 325px;
			}
		}

		@media (min-width: 1401px){
			.altura-card{
				height: 305px;
			}
		}
		
	</style>
   
	<div class='container-fluid'>
		<div class='row'>

			<? echo $pt1 ?>

		</div>
	</div>
	
	
<?
	echo $rodape;
	
?>

	<script>

		$(function () {
		  $('[data-toggle="popover"]').popover()
		})
		
		function adicionar_pedido(cod_produto) {
			window.location.href = 'https://www.newaiter.com.br/newaiter/cardapio/aguardando-confirmacao-pedido1.php?cod_produto='+cod_produto;
		}
		
	</script>
   
<?
     
} else {
	$_SESSION['VERICACOES'] = 'POR FAVOR, REALIZE O LOGIN PARA CONTINUAR';
	header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
}
	
?>