<?

// ==========================================
//       AJAX POPULAR FORMA DE PAGAMENTO
// ==========================================

if(!isset($_SESSION)) {
	session_start();
}

//header('Access-Control-Allow-Origin: *');

if(isset($_POST['forma_pagamento'])) {
	
	$forma_pagamento = $_POST['forma_pagamento'];

	if ($forma_pagamento == 'DINHEIRO' OR $forma_pagamento == 'Dinheiro e Cartão
	'){
		
	} 
 
 echo 'ola';
} else {
	echo 'erro';
	error_log('erro');
}


?>