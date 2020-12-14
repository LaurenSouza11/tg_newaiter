<?

// ==========================================
//       AJAX POPULAR DADOS DO LOCAL
// ==========================================

if(!isset($_SESSION)) {
	session_start();
}

//header('Access-Control-Allow-Origin: *');

if(isset($_POST['locais_disponiveis'])) {

	$locais_disponiveis = $_POST['locais_disponiveis'];

	// ***** ARQUIVOS E SESSÕES

	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();
	
	$array_dados_local = array();
	$endereco = '';
	$telefone = '';
	$contato = '';
	$nome_imagem = '';
	$dadosJSON = '';
	$caminho_logo = '';
	
	$query = "SELECT endereco, telefone, celular, cidade, nome_imagem_bd
	FROM locais_atendidos
	WHERE nome = :nome;";
	
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':nome', $locais_disponiveis);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {
	  
		foreach($result as $row) {

			$endereco = $row->endereco;
			$telefone = $row->telefone;
			$celular = $row->celular;
			$cidade = $row->cidade;
			$nome_imagem = $row->nome_imagem_bd;
		}
		
	}

	$endereco = '<b>ENDEREÇO: </b>'.$endereco.', '.$cidade.' - SP';
	$caminho_logo = "<img src='https://www.newaiter.com.br/newaiter/imagens/logo/".$nome_imagem.".png'>";

	if($telefone != '' AND $celular != ''){
		$contato = '<b>TELEFONE: </b>'.$telefone / '<b>CELULAR: </b>'.$celular.'<br><br>';
		$array_dados_local = array($endereco, $contato, $caminho_logo);
	}elseif($telefone == ''){
		$celular = '<b>CELULAR: </b>'.$celular.'<br><br>';
		$array_dados_local = array($endereco, $celular, $caminho_logo);
	} else {
		$telefone = '<b>TELEFONE: </b>'.$telefone.'<br><br>';
		$array_dados_local = array($endereco, $telefone, $caminho_logo);
	}
	
	$dadosJSON = json_encode($array_dados_local);
	
	echo $dadosJSON;
 
} else {
	echo '';
	error_log('erro');
}


?>