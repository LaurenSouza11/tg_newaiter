<?

//==========================================
//           POST ESCOLHA DO LOCAL
// ==========================================

if (isset($_POST['btn_salvar_escolha'])) {
		
	session_start();
	
	$locais_disponiveis = mb_strtoupper($_POST['locais_disponiveis']);
	$_SESSION['LOCAL_SELECIONADO'] = mb_strtoupper($_POST['locais_disponiveis']);;
	$codigo_mesa = mb_strtoupper($_POST['codigo_mesa']);

	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = $DBM = connect_pdo_mysql();
	
	// ***** VERIFICA SE JA EXISTE ESSE CADASTRO
	
	$query = "SELECT nome_imagem_bd 
			  FROM locais_atendidos
			  WHERE nome = :nome";

	$stmt = $DB->prepare($query);
	$stmt->bindParam(':nome', $locais_disponiveis);	
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {

		foreach($result as $row) {
	
			$nome_imagem_bd = $row->nome_imagem_bd;
		
		}
	} 

	$query = "SELECT * 
			  FROM ".$nome_imagem_bd."_mesas
			  WHERE codigo = :codigo";

	$stmt = $DBM->prepare($query);
	$stmt->bindParam(':codigo', $codigo_mesa);	
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) { 
	
		foreach($result as $row) {
			
			$id = $row->id;
			$disponivel = $row->disponivel;

			if ($disponivel == 0){
				
				unset ($_SESSION['VERICACOES_TELA_INICIAL']); 
				 
				$_SESSION['IMAGEM_LOGO'] = $nome_imagem_bd;
				$_SESSION['MESA_SELECIONADA'] = $id;
				$login = $_SESSION['LOGIN']; 
				
				$query = "UPDATE ".$nome_imagem_bd."_mesas SET disponivel = 1 WHERE codigo = :codigo;";
				$stmt = $DB->prepare($query);
				$stmt->bindParam(':codigo', $codigo_mesa);
				$stmt->execute();
				
				$datetime_bd = date('Y-m-d H:i:s');
				$tmp = $id.rand(100, 999999).$login.strtotime("now");
				
				$query = "INSERT INTO pedido (id_mesa, login, estabelecimento, datetime, tmp) VALUES (:id_mesa, :login, :estabelecimento, :datetime, :tmp);";
				$stmt = $DB->prepare($query);
				$stmt->bindParam(':id_mesa', $id);
				$stmt->bindParam(':login', $login);
				$stmt->bindParam(':estabelecimento', $nome_imagem_bd);
				$stmt->bindParam(':datetime', $datetime_bd);
				$stmt->bindParam(':tmp', $tmp);
				$stmt->execute();
				
				$query = "SELECT id
				FROM pedido 
				WHERE tmp = :tmp";

				$stmt = $DBM->prepare($query);
				$stmt->bindParam(':tmp', $tmp);	
				$stmt->execute();
				$result = $stmt->fetchAll();

				if (count($result)) { 
				
					foreach($result as $row) {
						
						$id_pedido = $row->id;
						$_SESSION['PEDIDO'] = $id_pedido;
						$login = $_SESSION['LOGIN'];
						
						$query = "UPDATE cliente SET id_pedido = :id_pedido, local = :local WHERE login = '".$login."';";
						$stmt = $DB->prepare($query);
						$stmt->bindParam(':id_pedido', $id_pedido);
						$stmt->bindParam(':local', $nome_imagem_bd);
						$stmt->execute();

					}
					
				}
				
				//$_SESSION['IMAGEM_LOGO'] = $nome_imagem_bd;
				$caminho = 'Location: https://www.newaiter.com.br/newaiter/cardapio/index.php';
				header($caminho);
			
			} else {
				$_SESSION['VERICACOES_TELA_INICIAL'] = 'MESA OCUPADA';
				header('Location: https://www.newaiter.com.br/newaiter/tela-inicial/escolha-do-local.php');
			}

		}
		      
	} else {

		$_SESSION['VERICACOES_TELA_INICIAL'] = 'CÓDIGO MESA INEXISTENTE';
		header('Location: https://www.newaiter.com.br/newaiter/tela-inicial/escolha-do-local.php');

	}
 
}

?>