<?

//==========================================
//          	   POST
//==========================================

if (isset($_POST['btn_salvar_edicao'])) {
	
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();
	
	$registro_id = $_POST['registro_id'];
	$observacao = $_POST['observacao'];
	$quantidade = $_POST['quantidade'];

	$query = "UPDATE tmp_lista_pedido SET observacao = :observacao, quantidade = :quantidade WHERE id = ".$registro_id.";";
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':observacao', $observacao);
	$stmt->bindParam(':quantidade', $quantidade);
	$stmt->execute();
	
	header('Location: https://www.newaiter.com.br/newaiter/cardapio/pedido.php');
	
}

if (isset($_POST['btn_enviar_pedido'])) {
	
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = $DBA = connect_pdo_mysql();
	
	// VARIAVEIS
	
	$preco_por_item = 0;
	$preco_total = 0;
			
	// ***** 1-INSERE OS DADOS NA TABELA TEMPORARIA
	
	$query = "SELECT tmp_lista_pedido.*, cardapio.id AS id_produto ,cardapio.nome, 
			  cardapio.descricao, cardapio.preco
			  FROM tmp_lista_pedido
			  INNER JOIN cardapio
			  ON tmp_lista_pedido.id_produto = cardapio.id
			  WHERE id_pedido = :id_pedido";
	
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id_pedido', $_SESSION['PEDIDO']);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {
	  
		foreach($result as $row) {
			
			$id = $row->id;
			$id_pedido = $row->id_pedido;
			$quantidade = $row->quantidade;
			$observacao = $row->observacao;
			
			// star_burguer_cardapio
			$id_produto = $row->id_produto;
			$nome = $row->nome;
			$descricao = $row->descricao;
			$preco = $row->preco;
			
			$datetime_bd = date('Y-m-d H:i:s');
			$preco_por_item = ($preco * $quantidade);

			$query2 = $query2."INSERT INTO lista_pedido (id_pedido, id_produto, quantidade, preco, observacao, datetime) VALUES ('".$id_pedido."', '".$id_produto."', '".$quantidade."', '".$preco_por_item."', '".$observacao."', '".$datetime_bd."');";
		}	
		
		$stmt = $DBA->prepare($query2);
		$stmt->execute();
		
		$query2 = "DELETE FROM tmp_lista_pedido
				   WHERE id_pedido = :id_pedido;";
				   
		$stmt = $DB->prepare($query2);
		$stmt->bindParam(':id_pedido', $_SESSION['PEDIDO']);
		$stmt->execute();
				  
		
	}
	
	$query = "SELECT * FROM lista_pedido
			  WHERE id_pedido = :id_pedido";
	
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id_pedido', $_SESSION['PEDIDO']);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {
	  
		foreach($result as $row) {
			
			$preco = $row->preco;
			$preco_total = $preco_total + ($preco * $quantidade);
			
		}
		
		$query = "UPDATE pedido SET preco_total = :preco_total WHERE id = :id;";
		$stmt = $DB->prepare($query);
		$stmt->bindParam(':id',  $_SESSION['PEDIDO']);
		$stmt->bindParam(':preco_total', $preco_total);
		$stmt->execute();
		
	}
	
	$_SESSION['MENSAGEM_PEDIDO'] = 'Pedido enviado para a cozinha';
	header('Location: https://www.newaiter.com.br/newaiter/cardapio/pedido.php');
	
	
}

if (isset($_POST['btn_voltar'])) {

	header('Location: https://www.newaiter.com.br/newaiter/cardapio/index.php');
}

if (isset($_POST['btn_encerrar_comanda'])) {
	
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = $DBA = connect_pdo_mysql();
	
	$forma_pagamento = $_POST['forma_pagamento'];
	
	$query = "UPDATE pedido SET forma_pagamento = :forma_pagamento, finalizado_cliente = 1, status = 4 WHERE id = :id;";
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id', $_SESSION['PEDIDO']);
	$stmt->bindParam(':forma_pagamento', $forma_pagamento);
	$stmt->execute();
	
	$query = "UPDATE lista_pedido SET status = 4 WHERE id_pedido = :id_pedido;";
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id_pedido', $_SESSION['PEDIDO']);
	$stmt->execute();
	
	//$_SESSION['VERICACOES'] = 'POR FAVOR, AGUARDE O GARÇOM OU DIRIJA ATÉ UM CAIXA';
	
	
	header('Location: https://www.newaiter.com.br/newaiter/cardapio/pedido.php');
	/*
	unset($_SESSION['PEDIDO']);
	unset($_SESSION['IMAGEM_LOGO']);
	unset($_SESSION['NOME_USUARIO']);
	unset($_SESSION['MENSAGEM_PEDIDO']);
	unset($_SESSION['MESA_SELECIONADA']);
	unset($_SESSION['LOCAL_SELECIONADO']);
	

	header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
*/
}

if (isset($_POST['btn_chamar_vendedor'])) {
	
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = $DBA = connect_pdo_mysql();
	
	$query = "UPDATE cliente SET chamar_vendedor = 1 WHERE id_pedido = :id;";
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id', $_SESSION['PEDIDO']);
	$stmt->execute();
	
	$_SESSION['CHAMAR_VENDEDOR'] = 1;
	
	header('Location: https://www.newaiter.com.br/newaiter/cardapio/index.php');
	
}

?>