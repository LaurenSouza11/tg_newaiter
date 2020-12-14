<?

// ==========================================
//                 AJAX EDITAR
// ==========================================

if(!isset($_SESSION)) {
	session_start();
}

if(isset($_POST['registro_id'])) {
	
	// ***** ARQUIVOS E SESSÕES
	
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();

	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/frm-editar.php');

	// ***** FORM
	
	$frm_editar = frm_editar($_POST['registro_id']);
	echo $frm_editar;
	
	echo "<script>
			document.getElementById('modal_editar').style.display = 'block';
		  </script>";
		  
}

?>