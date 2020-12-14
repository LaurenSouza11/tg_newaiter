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
	
	// ***** ARQUIVOS E FUNÇÕES

	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/cabecalho-rodape.php');
	require($_SERVER['DOCUMENT_ROOT'].'newaiter/cardapio/modal.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	// ***** VARIÁVEIS
	   
	$DB = connect_pdo_mysql();
	$cabecalho = cabecalho('COMANDA', $_SESSION['LOCAL_SELECIONADO'], $userName , '');
	$rodape = rodape();
	$modal = modal();
	
	$pt1 = $pt2 = $pt3 = '';
	$btn_acao_lote = '';
	$preco_total = 0;
	
	$count = 0;
	
	$modal_content = '';
	$js_modal_content = '';
	
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
			}
			
			// ***** RESUMO DOS ELEMENTOS POR LINHA
			
			$pt2 = $pt2."<tr>
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
	
		$pt1 = $modal_content."	<div class='datagrid' style='overflow: auto;'>
									<form method='post' name='pedido' id='pedido' action='https://www.newaiter.com.br/newaiter/cardapio/post.php'>
									<table>
										<thead>
											<tr class='c-center'>
												<th class='c-center sorttable_nosort'>Nº</th>
												<th class='c-center sorttable_nosort'>PRODUTO</th>
												<th class='c-center sorttable_nosort'>QUANT.</th>
												<th class='c-center'>PREÇO UNITÁRIO</th>	
												<th>PREÇO</th>												
												<th>STATUS</th>												
											</tr>
										</thead>
										<tbody>";
										
		$pt3 = "			    
										</tbody>
											<tfoot>
												<tr>
													<td colspan='6'>
														<div id='paging' align='LEFT' style='font-size:16px;'>
															<br>
															&nbsp;&nbsp;<b><u>Preço Total: ".$preco_total."</u></b><br>	
															<br>&nbsp;&nbsp;O que você deseja?<br><br>
															&nbsp;&nbsp;<button type='submit' id='btn_voltar' name='btn_voltar' value='btn_voltar' class='btn btn-danger'>Continuar pedindo</button>
															<button type='button' class='btn btn-danger' align='left' data-toggle='modal' data-target='#ModalEncerrarPedido'>Encerrar comanda</button>
					
															<br><br>
														</div>
													</td>
												</tr>
											</tfoot>										
									</table>
									</form>
								</div>";
								
		$modal = "
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
		
		$pt1 = "<br><div id='paging' align='center' style='font-size:18px;'> Nenhum item na comanda </div>";
		$pt2 = $pt3 = '';
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
	 
	 <div style='color:red;'>
		<center><b><u><? echo $mensagem_pedido; ?></u></b></center><br>
	</div>
			
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-12'>
			</div>
			<div class='table-responsive'>
				<? echo $pt1.$pt2.$pt3 ?>							
			</div>
			
			<? echo $modal ?>
		</div>

	</div>
	
	<script>
	
		$('#myModal').on('shown.bs.modal', function () {
		  $('#myInput').trigger('focus')
		})
	
	</script>

<?
	echo $rodape;
     
} else {
	$_SESSION['VERICACOES'] = 'POR FAVOR, REALIZE O LOGIN PARA CONTINUAR';
	header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
}
	
?>