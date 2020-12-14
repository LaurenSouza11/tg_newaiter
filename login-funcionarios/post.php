<?

//==========================================
//             POST LOGIN/CADASTRO
// ========================================== 
 
if (isset($_POST['btn_enviar_login_funcionarios'])) {
	
	session_start();
	
	$login = mb_strtoupper($_POST['login']);
	$senha = mb_strtoupper($_POST['senha']);
	
	$_SESSION['LOGIN'] = $login;
	$_SESSION['SENHA'] = $senha;
	
	$confirmacao_senha = mb_strtoupper($_POST['confirmacao_senha']);
 
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();
	
	// ***** VERIFICA SE O LOGIN E A SENHA ESTÃO CORRETOS
	
	$query = "SELECT funcionarios.login, funcionarios.senha, funcionarios.nome, locais_atendidos.nome as nome_local, locais_atendidos.nome_imagem_bd
			  FROM funcionarios INNER JOIN locais_atendidos
			  ON funcionarios.local_id = locais_atendidos.id
			  WHERE login = :login AND senha = :senha;";

	$stmt = $DB->prepare($query);
	$stmt->bindParam(':login', $login);	
	$stmt->bindParam(':senha', $senha);	
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) { 
	
		foreach($result as $row) {
			
			$nome = $row->nome;
			$nome_local = $row->nome_local;
			$nome_imagem_bd = $row->nome_imagem_bd;
			
			$nome_explode = explode(" ", $nome);
			$_SESSION['NOME_FUNCIONARIO'] = $nome_explode[0];
						
			$_SESSION['LOCAL_SELECIONADO_FUNCIONARIO'] = $local;
			$_SESSION['IMAGEM_LOGO_FUNCIONARIO'] = $nome_imagem_bd;
			
			header('Location: https://www.newaiter.com.br/newaiter/tela-inicial-funcionarios/index.php'); 
		}
		
	} else {
		$_SESSION['VERICACOES'] = 'LOGIN OU SENHA INCORRETO!';
		header('Location: https://www.newaiter.com.br/newaiter/login-funcionarios/1-login.php');
	}	
	
}

?>