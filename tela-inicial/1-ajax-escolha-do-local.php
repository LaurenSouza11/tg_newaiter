<?

// ==========================================
//       AJAX POPULAR ESCOLHA DO LOCAL
// ==========================================

if(!isset($_SESSION)) {
	session_start();
}

//header('Access-Control-Allow-Origin: *');

if(isset($_POST['cidade'])) {
	$cidade = $_POST['cidade'];

	// ***** ARQUIVOS E SESSÕES

	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();
	
	$array_restaurantes = array();
	$nome = '';
	$dadosJSON = '';
	
	$query = "SELECT nome
	FROM locais_atendidos
	WHERE cidade = :cidade AND aceita_comer_local = 1
	ORDER BY nome ASC;";
	
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':cidade', $cidade);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {
	  
		foreach($result as $row) {

			$nome = $row->nome;
			
			array_push($array_restaurantes, $nome);
		}
		
	}
     
	$dadosJSON = json_encode($array_restaurantes);
	
	echo $dadosJSON;
	
	//error_log($dadosJSON);   
 
} else {
	echo '';
	error_log('erro');
}


?>