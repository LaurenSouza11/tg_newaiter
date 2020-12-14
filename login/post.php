<?

//==========================================
//             POST LOGIN/CADASTRO
// ==========================================

if (isset($_POST['btn_enviar_cadastro'])) {
	
	session_start();
	
	$nome = mb_strtoupper($_POST['nome']);
	$cpf = mb_strtoupper( $_POST['cpf']);
	$rg = mb_strtoupper($_POST['rg']);
	$ddd_telefone = mb_strtoupper($_POST['ddd_telefone']);
	$telefone = mb_strtoupper($_POST['telefone']);
	$ddd_celular = mb_strtoupper($_POST['ddd_celular']);
	$celular = mb_strtoupper($_POST['celular']);
	$rua = mb_strtoupper($_POST['rua']);
	$numero = mb_strtoupper($_POST['numero']);
	$bairro = mb_strtoupper($_POST['bairro']);
	$cidade = mb_strtoupper($_POST['cidade']);
	$estado = mb_strtoupper($_POST['estado']);
	$login = mb_strtoupper($_POST['login']);
	$senha = mb_strtoupper($_POST['senha']);
	$confirmacao_senha = mb_strtoupper($_POST['confirmacao_senha']);

	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();
	
	// ***** VERIFICA SE JA EXISTE ESSE CADASTRO
	
	$query = "SELECT login 
			  FROM cliente
			  WHERE login = :login";

	$stmt = $DB->prepare($query);
	$stmt->bindParam(':login', $login);	
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) { 
	
		foreach($result as $row) {
	
			$_SESSION['VERICACOES'] = 'E-MAIL JÁ CADASTRADO! Por favor escolha outro';
			header('Location: https://www.newaiter.com.br/newaiter/login/2-cadastro-parte1.php'); 
		
		}
	
	} else {
		  
		if ($senha == $confirmacao_senha){
		
			$query = "INSERT INTO cliente (nome, rg, cpf, ddd_telefone, telefone, ddd_celular, celular, rua, numero, bairro, cidade, estado, login, senha, confirmacao_senha) VALUES (:nome, :rg, :cpf, :ddd_telefone, :telefone, :ddd_celular, :celular, :rua, :numero, :bairro, :cidade, :estado, :login, :senha, :confirmacao_senha);";
				
			$stmt = $DB->prepare($query);
			$stmt->bindParam(':nome', $nome);
			$stmt->bindParam(':rg', $rg);
			$stmt->bindParam(':cpf', $cpf);
			$stmt->bindParam(':ddd_telefone', $ddd_telefone);
			$stmt->bindParam(':telefone', $telefone);
			$stmt->bindParam(':ddd_celular', $ddd_celular);
			$stmt->bindParam(':celular', $celular);
			$stmt->bindParam(':rua', $rua);
			$stmt->bindParam(':numero', $numero);
			$stmt->bindParam(':bairro', $bairro);
			$stmt->bindParam(':cidade', $cidade);
			$stmt->bindParam(':estado', $estado);
			$stmt->bindParam(':login', $login);
			$stmt->bindParam(':senha', $senha);
			$stmt->bindParam(':confirmacao_senha', $confirmacao_senha);
			
			$stmt->execute();
		
			$_SESSION['VERICACOES'] = 'CADASTRO CONCLUÍDO! POR FAVOR, REALIZE O LOGIN PARA CONTINUAR';
			header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
	
		} else {
			$_SESSION['VERICACOES'] = 'SENHAS NÃO CONFEREM!';
			header('Location: https://www.newaiter.com.br/newaiter/login/2-cadastro-parte1.php'); 
		}
			
	}	
	  
}  
 
if (isset($_POST['btn_enviar_login'])) {
	
	session_start();
	
	$login = mb_strtoupper($_POST['login']);
	$senha = mb_strtoupper($_POST['senha']);
	
	$_SESSION['LOGIN'] = $login;
	$_SESSION['SENHA'] = $senha;
	
	$confirmacao_senha = mb_strtoupper($_POST['confirmacao_senha']);
 
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();
	
	// ***** VERIFICA SE O LOGIN E A SENHA ESTÃO CORRETOS
	
	$query = "SELECT login, senha, nome, id_pedido, local
			  FROM cliente
			  WHERE login = :login AND senha = :senha;";

	$stmt = $DB->prepare($query);
	$stmt->bindParam(':login', $login);	
	$stmt->bindParam(':senha', $senha);	
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) { 
	
		foreach($result as $row) {
			
			$nome = $row->nome;
			$id_pedido = $row->id_pedido;
			$local = $row->local;
			
			if ($id_pedido == 0 AND $local == ''){
				
				$nome_explode = explode(" ", $nome);
				$_SESSION['NOME_USUARIO'] = $nome_explode[0];
				
				unset ($_SESSION['VERICACOES']);  
				header('Location: https://www.newaiter.com.br/newaiter/tela-inicial/index.php'); 
				
			} else {
				
				$nome_explode = explode(" ", $nome);
				$_SESSION['NOME_USUARIO'] = $nome_explode[0];
				
				$_SESSION['PEDIDO'] = $id_pedido;
				
				if (strpos($local, '_' ) === false) {
					
					strtolower($local);
					$_SESSION['LOCAL_SELECIONADO'] = $local;
					$_SESSION['IMAGEM_LOGO'] = str_replace(' ', '_', $local);
					
					
				} else {
					
					strtoupper($local);
					$_SESSION['IMAGEM_LOGO'] = $local;
					$_SESSION['LOCAL_SELECIONADO'] = str_replace('_', ' ', $local);
				
				}
				
				header('Location: https://www.newaiter.com.br/newaiter/cardapio/index.php'); 
			}
			
		}
	} else {
		$_SESSION['VERICACOES'] = 'LOGIN OU SENHA INCORRETO!';
		header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
	}	
	
}

?>