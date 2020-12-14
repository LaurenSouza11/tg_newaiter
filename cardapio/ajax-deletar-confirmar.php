<?

// ==========================================
//            AJAX DELETE CONFIRM
// ==========================================

if(isset($_POST['registro_id'])) {
	
	$registro_id = $_POST['registro_id'];
	$msg = $_POST['msg'];
	$nome = $_POST['nome'];

	// ***** MODAL
					
	$modal_content = "<div class='c-modal-header'>
						  <button type='button' class='c-btn-close' data-dismiss='c-modal' onclick=\"close_form('modal_delete')\">&times;</button>
						  <h4 class='c-modal-title'>Mensagem</h4>
						</div>
					
					<div class='c-modal-body' >
						<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
							<br>
							<p>Deseja realmente excluir o registro abaixo?</p>
							<span style='color:red;'>".$msg."</span>
							<hr>
							<button type='button' class='btn btn-danger' data-dismiss='c-modal' onclick=\"excluir(".$registro_id.", '".$nome."')\">Ok</button>	
							<button type='button' class='btn btn-danger' data-dismiss='c-modal' onclick=\"close_form('modal_delete')\">Cancelar</button>															
						</div>
						<div class='c-clear'></div>
					</div>";

	echo $modal_content;

	echo "<script>
			document.getElementById('modal_delete').style.display = 'block';
		  </script>";												

}

?>