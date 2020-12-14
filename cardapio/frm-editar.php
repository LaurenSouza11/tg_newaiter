<?

// ==========================================
//         FUNCTION FRM CÓDIGO BARRAS
// ==========================================

function frm_editar($registro_id) {
	
	// ***** CONFIGURAÇÕES E BANCO DE DADOS

	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	$DB = connect_pdo_mysql();

	// ------------------------------------------
	//             EDITAR REGISTRO
	// ------------------------------------------
	
	$query = "SELECT tmp_lista_pedido.*, cardapio.nome, 
			  cardapio.descricao, cardapio.preco
			  FROM tmp_lista_pedido
			  INNER JOIN cardapio 
			  ON tmp_lista_pedido.id_produto = cardapio.id
			  WHERE tmp_lista_pedido.id = :id";
	
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id', $_POST['registro_id']);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {
	  
		foreach($result as $row) {
			
			// tmp_lista_pedido_star_burguer
			$id = $row->id;
			$id_pedido = $row->id_pedido;
			$quantidade = $row->quantidade;
			$observacao = $row->observacao;
			
			// star_burguer_cardapio
			$nome = $row->nome;
			$descricao = $row->descricao;
			$preco = $row->preco;
			
			//$txt_nome_descricao = $nome.' '.$descricao;
			
		}
		
	}	

	$pt1 = "<div class='col-12' align='center'>
				<br><h4 style='color:red; text-transform: uppercase;'><b>".$nome."</b></h4>
				<h5>".$descricao."</h5><br>
				<h5><b>R$ ".$preco."</b></h5><br>
			</div>
			<div class='input-group'>
				<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>
					<div class='form-group'>
						<label>Quantidade</label>
							<input type='number' class='form-control' value='".$quantidade."' name='quantidade' style='text-transform: uppercase;' min='1' max='200' required 
							onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
					</div>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>
					<div class='form-group'>
						<label>Observação</label>
							<input type='text' class='form-control' value='".$observacao."' name='observacao' style='text-transform: uppercase;' maxlength='200' required'>
					</div>
				</div>
			</div>";

		// ***** FORM

		$pt1 = "<div class='c-modal-header'>
					<button type='button' class='btn btn-default c-btn-close' data-dismiss='c-modal' onclick=\"close_form('modal_editar')\" style='margin: 0px;'>&times;</button>
					<h4 class='c-modal-title'>Editar</h4>
				</div>
				<div class='c-modal-body'>
					<form method='POST' enctype='multipart/form-data' name='frm_editar' id='frm_editar' action='https://www.newaiter.com.br/newaiter/cardapio/post.php'>
						<div class='col-12'>
							".$pt1."
						</div>
						<div class='clear'></div>
						<div class='card-footer'>
							<button class='btn btn-danger' type='submit' id='btn_salvar_edicao' name='btn_salvar_edicao'>Salvar</button>
							<button class='btn btn-danger' type='button' name='btn_cancelar' onclick=\"close_form('modal_editar')\">Cancelar</button>
						</div>
						<input type='hidden' name='registro_id' id='registro_id' value='".$registro_id."'>
					</form>
				</div>";		

	$frm_editar = $pt1;
	return $frm_editar;

}

?>