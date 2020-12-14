<?

// ==========================================
//            AJAX DELETE EXECUTE
// ==========================================

if(isset($_POST['registro_id'])) {
	
	session_start();
	
	// ***** ARQUIVOS E FUNÇÕES

	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();

	// ***** 1-APAGA O REGISTRO
	
	$query = "DELETE FROM tmp_lista_pedido WHERE id = :registro_id;";
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':registro_id', $_POST['registro_id']);
	$stmt->execute();
	
	$registro = $_POST['registro_id'];

	// ***** MODAL
	$modal_content = "<div class='c-modal-header'>
					  <button type='button' class='c-btn-close' data-dismiss='c-modal' onclick=\"close_form_reload('modal_delete')\">&times;</button>
					  <h4 class='c-modal-title'>Mensagem</h4>
					</div>
					
					<div class='c-modal-body' >
						<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
							<br>
							<p>Excluído com sucesso!</p><hr>
							<button type='button' class='btn btn-danger' data-dismiss='c-modal' onclick=\"close_form_reload('modal_delete')\">Ok</button>																
						</div>
						<div class='c-clear'></div>
					</div>";
	
	echo $modal_content;
	
	echo "<script>
			document.getElementById('modal_delete').style.display = 'block';
		  </script>";		


}

?>