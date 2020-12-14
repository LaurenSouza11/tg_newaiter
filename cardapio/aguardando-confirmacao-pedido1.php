<?

if(!isset($_SESSION)) {
	session_start();
}
    
date_default_timezone_set('America/Sao_Paulo');
ob_start();


if((isset($_GET['cod_produto'])) AND (isset($_SESSION['LOGIN'])) AND (isset($_SESSION['PEDIDO']))) {
	
	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/cabecalho-rodape.php');
	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/modal.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');

	$DB = connect_pdo_mysql();
	
	// ***** VARIÁVEIS
	$cod_produto = $_GET['cod_produto'];
	$_SESSION['COD_PRODUTO'] = $cod_produto;
	$datetime_bd = date('Y-m-d H:i:s');
	
	$query = "INSERT INTO tmp_lista_pedido (id_pedido, id_produto, quantidade, datetime) VALUES (:id_pedido, :id_produto, 1, :datetime);";
				
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id_pedido', $_SESSION['PEDIDO']);
	$stmt->bindParam(':id_produto', $cod_produto);
	$stmt->bindParam(':datetime', $datetime_bd);
	
	$stmt->execute();
	
	header('Location: https://www.newaiter.com.br/newaiter/cardapio/pedido.php');
	  
} else {
	
	if(!isset($_GET['cod_produto'])){
		echo 'PRODUTO NÃO ENCONTRADO';
		header('Location: https://www.newaiter.com.br/newaiter/cardapio/lanches.php');
	} else {
		$_SESSION['VERICACOES'] = 'POR FAVOR, REALIZE O LOGIN PARA CONTINUAR';
		header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
	}
	
}

?>