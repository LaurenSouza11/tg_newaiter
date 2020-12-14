<?
 
// ==========================================
//             		INDEX
// ==========================================

if(!isset($_SESSION)) {
	session_start();
}
  
date_default_timezone_set('America/Sao_Paulo');
ob_start();
   
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['LOGIN']) AND (isset($_SESSION['PEDIDO']))) {
	 
	if(isset($_SESSION['NOME_USUARIO'])){
		$userName = $_SESSION['NOME_USUARIO'];
	} else {
		$userName = '';
	} 
	
	if(isset($_SESSION['MENSAGEM_PEDIDO'])){
		$mensagem_pedido = $_SESSION['MENSAGEM_PEDIDO'];
	} else {
		$mensagem_pedido = '';
	}
	
	$_SESSION['PEDIDO'];
	 
	// ***** ARQUIVOS E FUNÇÕES

	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/cabecalho-rodape.php');
	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/modal.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	// ***** VARIÁVEIS
	   
	$DB = connect_pdo_mysql();
	$cabecalho = cabecalho('LISTA DE PRODUTOS', $_SESSION['LOCAL_SELECIONADO'], $userName , '');
	$rodape = rodape();
	$modal = modal();
	
	$pt1 = $pt2 = $pt3 = $pt4 = $pt5 = $pt6 = $modal1 = '';
	$btn_acao_lote = '';
	$preco_total = 0;
	
	$count = 0;
	
	$modal_content = '';
	$js_modal_content = '';
	
	// ***** 1-INSERE OS DADOS NA TABELA TEMPORARIA
	
	$query = "SELECT tmp_lista_pedido.*, cardapio.nome, 
			  cardapio.descricao, cardapio.preco
			  FROM tmp_lista_pedido
			  INNER JOIN cardapio 
			  ON tmp_lista_pedido.id_produto = cardapio.id
			  WHERE id_pedido = :id_pedido";
	
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id_pedido', $_SESSION['PEDIDO']);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {
	  
		foreach($result as $row) {
			
			$count = $count + 1;
			
			// tmp_lista_pedido_star_burguer
			$id = $row->id;
			$id_pedido = $row->id_pedido;
			$quantidade = $row->quantidade;
			$observacao = $row->observacao;
			
			// star_burguer_cardapio
			$nome = $row->nome;
			$descricao = $row->descricao;
			$preco = $row->preco;
			
			$preco_total = $preco_total + ($preco * $quantidade);
			
			$msg = $nome;
			
			// BTN 'btn_acao_por_linha'
			$btn_acao_linha = "
				<select class='form-control' name='btn_acao_linha".$id."' id='btn_acao_linha".$id."' onChange=\"acao_linha(".$id.", '".$msg."', '".$nome."')\">
					<option value=''>&nbsp;</option>
					<option value='1'>&#9998; Editar</option>	
					<option value='2'>&#9421; Excluir</option>
				</select>";
		
			// ***** RESUMO DOS ELEMENTOS POR LINHA
			
			$pt2 = $pt2."<tr>
							<td>								
								".$btn_acao_linha."
								<input type='hidden' name='file_id' value=".$id.">	
							</td>
							<td>								
								".$count."
							</td>
							</td>								
							<td class='c-center'>
								".$quantidade."
							</td>
							<td style='text-align: justify-all;'>
								<b>".$nome."</b> - ".$descricao." - R$ ".$preco."
							</td>	
							<td>
								".$observacao."
							</td>														
						</tr>";
	
			
		}
		
		// ***** RESUMO DOS ELEMENTOS DO FORM
	
		$pt1 = $modal_content."	<div class='datagrid' style='overflow: auto;'>
									<form method='post' name='pedido' id='pedido' action='https://www.newaiter.com.br/newaiter/cardapio/post.php'>
									<center><h5 style='margin:10px; color:red;'>Pedidos Pendente</h5></center>
									<table>
										<thead>
											<tr class='c-center'>
												<th class='c-center sorttable_nosort'>EDITAR/ EXCLUIR</th>
												<th class='c-center sorttable_nosort'>Nº</th>
												<th class='c-center sorttable_nosort'>QTD.</th>
												<th class='c-center'>ITEM/ DESCRIÇÃO</th>	
												<th>OBS.</th>												
											</tr>
										</thead>
										<tbody>";
										
		$pt3 = "			    
										</tbody>
											<tfoot>
												<tr>
													<td colspan='5'>
														<div id='paging' align='LEFT' style='font-size:16px;'>
															<br>
															&nbsp;&nbsp;<b><u>Preço Total: ".$preco_total."</u></b><br>	
															<br>&nbsp;&nbsp;O que você deseja?<br><br>
															&nbsp;&nbsp;<button type='submit' id='btn_voltar' name='btn_voltar' value='btn_voltar' class='btn btn-danger'>Continuar pedindo</button>
															<button type='submit' id='btn_enviar_pedido' name='btn_enviar_pedido' value='btn_enviar_pedido' class='btn btn-danger' align='left'>Enviar para cozinha</button>
															<br><br>
														</div>
													</td>
												</tr>
											</tfoot>										
									</table>
									</form>
								</div>";
		
	} else {
		
		$pt1 = "<br><div id='paging' align='center' style='font-size:18px;'> Nenhum pedido em andamento </div>";
		$pt2 = $pt3 = '';
	}
	 
	 // ***** 1-INSERE OS DADOS NA TABELA TEMPORARIA
	
	$query = "SELECT lista_pedido.*, nome, 
			  cardapio.descricao, cardapio.preco AS preco_unitario
			  FROM lista_pedido
			  INNER JOIN cardapio 
			  ON lista_pedido.id_produto = cardapio.id
			  WHERE id_pedido = :id_pedido";
	
	$stmt = $DB->prepare($query);
	$stmt->bindParam(':id_pedido', $_SESSION['PEDIDO']);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {
	  
		foreach($result as $row) {
			
			$count = $count + 1;
			
			// tmp_lista_pedido
			$id = $row->id;
			$id_pedido = $row->id_pedido;
			$quantidade = $row->quantidade;
			$preco = $row->preco;
			$status = $row->status;
			
			// cardapio
			$nome = $row->nome;
			$descricao = $row->descricao;
			$preco_unitario = $row->preco_unitario;
			
			if ($status == 0){
				$status_txt = 'ENVIADO PARA COZINHA';
				$desablitado = '';
			} elseif ($status == 4){
				$status_txt = 'AGUARDANDO CONFIRMAÇÃO DE PAGAMENTO';
				$desablitado = ' disabled ';
			}
			
			// ***** RESUMO DOS ELEMENTOS POR LINHA
			
			$pt5 = $pt5."<tr>
							<td style='text-align: justify-all;'>
								<b>".$count."</b>
							</td>
							<td style='text-align: justify-all;'>
								<b>".$nome."</b>
							</td>
							<td class='c-center'>
								".$quantidade."
							</td>
							<td>
								R$ ".$preco_unitario."
							</td>	
							<td>
								R$ ".$preco."
							</td>
							<td>
								".$status_txt."
							</td>	
						</tr>";
	
			
		}
		
		$query = "SELECT preco_total
				  FROM pedido
				  WHERE id = :id";
		
		$stmt = $DB->prepare($query);
		$stmt->bindParam(':id', $_SESSION['PEDIDO']);
		$stmt->execute();
		$result = $stmt->fetchAll();

		if (count($result)) {
		  
			foreach($result as $row) {
				
				$preco_total = $row->preco_total;
				
			}
			
		}
		
		// ***** RESUMO DOS ELEMENTOS DO FORM
	
		$pt4 = $modal_content."	<div class='datagrid' style='overflow: auto;'>
									<form method='post' name='pedido1' id='pedido1' action='https://www.newaiter.com.br/newaiter/cardapio/post.php'>
									<center><h5 style='margin:10px; color:red;'>Pedidos Enviado a Cozinha</h5></center>
									<table>
										<thead>
											<tr class='c-center'>
												<th class='c-center sorttable_nosort'>Nº</th>
												<th class='c-center sorttable_nosort'>ITEM</th>
												<th class='c-center sorttable_nosort'>QTD.</th>
												<th class='c-center'>PREÇO UNIT.</th>	
												<th>PREÇO TOTAL</th>												
												<th>STATUS</th>												
											</tr>
										</thead>
										<tbody>";
										
		$pt6 = "			    
										</tbody>
											<tfoot>
												<tr>
													<td colspan='6'>
														<div id='paging' align='LEFT' style='font-size:16px;'>
															<br>
															&nbsp;&nbsp;<b><u>Preço Total: ".$preco_total."</u></b><br>	
															<br>&nbsp;&nbsp;O que você deseja?<br><br>
															<button type='button' ".$desablitado." class='btn btn-danger' align='left' data-toggle='modal' data-target='#ModalEncerrarPedido'>Encerrar comanda</button>
					
															<br><br>
														</div>
													</td>
												</tr>
											</tfoot>										
									</table>
									</form>
								</div>";
								
		$modal1 = "
					<div class='modal fade' id='ModalEncerrarPedido' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
					  <div class='modal-dialog' role='document'>
						<div class='modal-content'>
						 <form method='post' name='envia_login' id='envia_login' action='https://www.newaiter.com.br/newaiter/cardapio/post.php'>
						  <div class='modal-header'>
							<h5 class='modal-title' id='exampleModalLabel'>Encerrar Comanda</h5>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							  <span aria-hidden='true'>&times;</span>
							</button>
						  </div>
						  <div class='modal-body'>
							<span style='font-size: 18px; text-align: center;'>Preço Total: <b> ".$preco_total." reais</b></span><br><br>
							<div class='form-group'>
								<label for='forma_pagamento'>Forma de Pagamento</label>
								<select class='form-control' id='forma_pagamento' name='forma_pagamento' required>
								  <option></option>
								  <option>Dinheiro</option>
								  <option>Cartão</option>
								  <option>Dinheiro e Cartão</option>
								</select>
							</div>
							<div>
								<span style='font-size: 18px; text-align: center;'>Deseja encerrar a comanda?</b></span><br><br>
							</div>
						  </div>
						  <div class='modal-footer'>
							<button type='button' class='btn btn-secondary' data-dismiss='modal'>Não</button>
							<button class='btn btn-danger' type='submit' id='btn_encerrar_comanda' name='btn_encerrar_comanda'>Sim</button>
						  </div>
						  </form>
						</div>
					  </div>
					</div>
					";
		
	} else {
		
		$pt4 = "<br><div id='paging' align='center' style='font-size:18px;'> Nenhum item na comanda </div>";
		$pt5 = $pt6 = '';
	}
	
							
	echo $cabecalho;
	
?>	

	<div class='container-fluid'>
		<div class='row' align='center'>
			<div class='col-12'>
				<br><h3 style='color:red'><b>PEDIDO N° <? echo $_SESSION['PEDIDO'] ?></b></h3>
			</div>
		</div>
	</div>
	
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-12'>
			</div>
			<div class='table-responsive'>
				<? echo $pt1.$pt2.$pt3 ?>							
			</div>
		</div>
	
	<div style='color:red;'>
		<center><b><u><? echo $mensagem_pedido; ?></u></b></center><br>
	</div>
	 
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-12'>
			</div>
			<div class='table-responsive'>
				<? echo $pt4.$pt5.$pt6 ?>							
			</div>
		</div>

		 <? echo $modal.$modal1 ?>	
		 
	</div>
	
	<script>

		// ***** NOVO REGISTRO

		var modal_new = document.getElementById('modal_new');
			
		
		// ***** AÇÃO POR LINHA
		
		function acao_linha(registro_id, msg, nome) {

			var btn_acao_linha = document.getElementById('btn_acao_linha'+registro_id);		
			if (btn_acao_linha.selectedIndex > -1) {
				
				var acao = btn_acao_linha.options[btn_acao_linha.selectedIndex].value;
				
				// EDITAR
				if (acao == 1) {

					var urlModal = "https://www.newaiter.com.br/newaiter/cardapio/ajax-editar.php";
					var modalContent = '#c-modal-new';
					
					$.ajax({
						type: "POST",
						url: urlModal,
						data: {
							registro_id
						},
						success: function(data) {
						  $(modalContent).html(data);
						}
					});
					
				}				

				// EXCLUIR (CONFIRMAÇÃO)
				if (acao == 2) {

					var url_ajax = "https://www.newaiter.com.br/newaiter/cardapio/ajax-deletar-confirmar.php";
					var modalContent = '#c-modal-delete';
					
					// AJAX		
					$.ajax({
						type: "POST",
						url: url_ajax,
						data: {
							registro_id, msg, nome
						},
						success: function(data) {
							$(modalContent).html(data);
						}
					});	
					
				}	
							
			}
		}
		
		// ***** EXCLUIR INDIVIDUAL (EXECUÇÃO)
		
		function excluir(registro_id, nome) {

			var url_ajax = 'https://www.newaiter.com.br/newaiter/cardapio/ajax-deletar-executar.php';
			var modalContent = '#c-modal-delete';

			// AJAX		
			$.ajax({
				type: "POST",
				url: url_ajax,
				data: {
					registro_id, nome
				},
				success: function(data) {
					$(modalContent).html(data);
				}
			});			
			
		}
		
		// ***** FECHAR FORMULÁRIO

		function close_form(form) {
			document.getElementById(form).style.display = 'none';
		}
		
		function close_form_reload(form) {
			document.getElementById(form).style.display = 'none';
			location.reload();
		}	
	
	</script>
	
<?
	echo $rodape;
     
} else {
	$_SESSION['VERICACOES'] = 'POR FAVOR, REALIZE O LOGIN PARA CONTINUAR';
	header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
}
	
?>