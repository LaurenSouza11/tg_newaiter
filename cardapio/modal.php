<?

// ==========================================
//                   MODAL
// ==========================================

function modal() {

	// ***** VARIÁVEIS
	
	$modal = '';
	$js_modal = '';	

	// ***** EDITAR REGISTRO

	$modal = $modal."<div class='container'>
						<div class='c-modal' id='modal_editar' role='dialog'>
							<div class='c-modal-dialog'>
								<div class='c-modal-content' id='c-modal-new'>
								</div>				  
							</div>
						</div>										  
					</div>";
																				  
	// ***** DELETAR REGISTRO

	$modal = $modal."<div class='container'>
						<div class='c-modal' id='modal_delete' role='dialog'>
							<div class='c-modal-dialog'>											
								<div class='c-modal-content' id='c-modal-delete'>
								</div>				  
							</div>
						</div>										  
					</div>";

	return $modal;

}

?>