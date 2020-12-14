<?
 
// ==========================================
//         INDEX ESCOLHA DO LOCAL
// ==========================================

if(!isset($_SESSION)) {
	session_start();
}
 
date_default_timezone_set('America/Sao_Paulo');
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['LOGIN'])) {
	 
	//error_log('sei la '.$_SESSION['VERICACOES_TELA_INICIAL']);
  
	if (isset($_SESSION['VERICACOES_TELA_INICIAL'])) {
		$verificar = $_SESSION['VERICACOES_TELA_INICIAL'];
		
	}  else {
		$verificar = '';
		unset ($_SESSION['VERICACOES_TELA_INICIAL']);  
		       
	}
	
	if(isset($_SESSION['NOME_USUARIO'])){
		$userName = $_SESSION['NOME_USUARIO'];
	} else {
		$userName = '';
	}

	     
	// ***** ARQUIVOS E FUNÇÕES
	
	require($_SERVER['DOCUMENT_ROOT'].'newaiter/estrutura/cabecalho-rodape.php');
	
	error_log('doc '.$_SERVER['DOCUMENT_ROOT']);
	require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
	
	// ***** VARIÁVEIS
	
	$DB = connect_pdo_mysql();
	$cabecalho = cabecalho('NEWAITER', 'Local/Delivery', $userName , '');
	$rodape = rodape();
	
	$array_cidade = array();
	$input_cidade = '';
	$locais_disponiveis = '';
	$codigo_mesa = '';
	$script = '';
	$endereco = '';
	$telefone = '';
	
	// ***** RETORNA AS CIDADES CADASTRADA
	
	$query = "SELECT DISTINCT cidade
	FROM locais_atendidos
	ORDER BY cidade ASC;";
	
	$stmt = $DB->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {
	  
		foreach($result as $row) {
			
			$cidade = $row->cidade;
			
			$input_cidade = $input_cidade."<option>".$cidade."</option>";
		}
		
	}

	$input_cidade = "	
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			<div class='form-group'>
				<label>CIDADES DISPONÍVEIS</label>
				<select class='form-control' name='cidade' id='cidade' onKeyUp='atualiza_locais_disponiveis();' onChange='atualiza_locais_disponiveis();' required>
					<option selected>CIDADES</option>
					".$input_cidade."
				</select>
			</div>
		</div>";
		
		
	$pt1 = "	

	<div class='input-group'>
	
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='color:blue;'>
			<center><b><u>".$verificar."</u></b></center><br>
		</div>
	
		".$input_cidade."
	
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			<div class='form-group'>
				<label>LOCAIS DISPONÍVEIS</label>
				<select class='form-control' name='locais_disponiveis' id='locais_disponiveis' onKeyUp='pega_dados_local();' onChange='pega_dados_local();' required>
					<option selected>LOCAIS</option>
					".$locais_disponiveis."
				</select> 
			</div>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='center' name='imagem' id='imagem'>
		</div>
		 
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='left' name='endereco' id='endereco'>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='left' name='telefone' id='telefone'>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			<div class='form-group'>
				<label>CÓDIGO DA MESA</label>
					<input type='text' class='form-control' value='".$codigo_mesa."' name='codigo_mesa' id='codigo_mesa' style='text-transform: uppercase;' maxlength='6' required>
			</div>
		</div>
		
	</div>
	
	<script>
	
		//document.getElementById('btn_salvar').disabled = true;
		document.getElementById('locais_disponiveis').disabled = true;
		document.getElementById('endereco').style.display = 'none';
		document.getElementById('telefone').style.display = 'none';
		document.getElementById('imagem').style.display = 'none';
	
		
		function atualiza_locais_disponiveis() {
			
			document.getElementById('endereco').style.display = 'none';
			document.getElementById('telefone').style.display = 'none';
			document.getElementById('imagem').style.display = 'none';
			
			var cidade = document.getElementById('cidade').value;
			
			if (cidade != 'CIDADES' && cidade != ''){
				document.getElementById('locais_disponiveis').disabled = false;
			} else {
				document.getElementById('locais_disponiveis').disabled = true;

			} 
			
			var urlPopularCidade = 'https://www.newaiter.com.br/newaiter/tela-inicial/1-ajax-escolha-do-local.php';
			// AJAX	
			$.ajax({
				type: 'POST',
				url: urlPopularCidade,
				dataType: 'json',
				data: {
					cidade
				},
				success: function(data) {
					
					$(locais_disponiveis).empty();
					$(locais_disponiveis).append('<option >' + 'LOCAIS' + '</option>');
					
					 jQuery.each(data, function(index) {

						$(locais_disponiveis).append('<option >' + data[index] + '</option>');
					});
 
				}

			});
		}
  
		function pega_dados_local() {
			
			var locais_disponiveis = document.getElementById('locais_disponiveis').value;

			if (locais_disponiveis != 'LOCAIS' && locais_disponiveis != ''){
				document.getElementById('endereco').style.display = 'block';
				document.getElementById('telefone').style.display = 'block';
				document.getElementById('imagem').style.display = 'block';
			} else {
				document.getElementById('endereco').style.display = 'none';
				document.getElementById('telefone').style.display = 'none';
				document.getElementById('imagem').style.display = 'none';
			}
			
			var urlPopularDadosLocal = 'https://www.newaiter.com.br/newaiter/tela-inicial/2-ajax-dados-local.php';

			// AJAX	
			$.ajax({
				type: 'POST',
				url: urlPopularDadosLocal,
				dataType: 'json',
				data: {
					locais_disponiveis
				},
				success: function(data) {
					
					document.getElementById('endereco').innerHTML = data[0];
					document.getElementById('telefone').innerHTML = data[1];
					document.getElementById('imagem').innerHTML = data[2];
 
				}

			});
		}

	</script>";	


	// ***** MONTAS OS INPUT E AS SELECT OPTIONS
	/*	
	$pt1 = "	
	
	<div class='col-12'>
		<center><b><u>Deseja usar a localização do celular?</u></b></center><br>
		<button class='btn btn-primary' type='button' name='btn_sim' id='btn_sim' onclick='opcao1()' >SIM</button>
		<button class='btn btn-primary' type='button' name='btn_nao' id='btn_nao' onclick='opcao2()'>NÃO</button>
	
	</div>
	  
	<div class='input-group' id='opcao1'>
	 
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='color:blue;'>
			<center><b><u>".$verificar."</u></b></center><br>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='center' name='maps' id='maps'>
		</div>
	
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='center' name='imagem' id='imagem'>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='center' name='local' id='local'>
		</div>
		
		 
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='left' name='endereco' id='endereco'>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='left' name='telefone' id='telefone'>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			<div class='form-group'>
				<label>CÓDIGO DA MESA</label>
					<input type='text' class='form-control' value='".$codigo_mesa."' name='codigo_mesa' id='codigo_mesa' style='text-transform: uppercase;' maxlength='6' required>
			</div>
		</div>
		
	</div>
	
	<div class='input-group' id='opcao2'>
	
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='color:blue;'>
			<center><b><u>".$verificar."</u></b></center><br>
		</div>
	
		".$input_cidade."
	
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			<div class='form-group'>
				<label>LOCAIS DISPONÍVEIS</label>
				<select class='form-control' name='locais_disponiveis' id='locais_disponiveis' onKeyUp='pega_dados_local();' onChange='pega_dados_local();' required>
					<option selected>LOCAIS</option>
					".$locais_disponiveis."
				</select> 
			</div>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='center' name='imagem' id='imagem'>
		</div>
		 
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='left' name='endereco' id='endereco'>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' align='left' name='telefone' id='telefone'>
		</div>
		
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
			<div class='form-group'>
				<label>CÓDIGO DA MESA</label>
					<input type='text' class='form-control' value='".$codigo_mesa."' name='codigo_mesa' id='codigo_mesa' style='text-transform: uppercase;' maxlength='6' required>
			</div>
		</div>
		
	</div>
	
	<script>
	
		//document.getElementById('btn_salvar').disabled = true;
		document.getElementById('locais_disponiveis').disabled = true;
		document.getElementById('endereco').style.display = 'none';
		document.getElementById('telefone').style.display = 'none';
		document.getElementById('imagem').style.display = 'none';
		document.getElementById('opcao1').style.display = 'none';
		document.getElementById('opcao2').style.display = 'none';
		
		function opcao1(){
			
			document.getElementById('opcao1').style.display = 'block';
			document.getElementById('opcao2').style.display = 'none';
			
			var x = document.getElementById('maps');
			
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition, showError);
			} else { 
				x.innerHTML = 'Geolocation is not supported by this browser.';
			}
			
			function showPosition(position) {
			  
			     lat=position.coords.latitude;
				 lon=position.coords.longitude;	

var urlRetornaDadosLocalizacao = 'https://www.newaiter.com.br/newaiter/tela-inicial/3-ajax-retorna-dados-localizacao.php';
			
			// AJAX	
			$.ajax({
				type: 'POST',
				url: urlRetornaDadosLocalizacao,
				dataType: 'json',
				data: {
					lat, lon
				},
				success: function(data) {
					
					document.getElementById('endereco').innerHTML = data[0];
					document.getElementById('telefone').innerHTML = data[1];
					document.getElementById('imagem').innerHTML = data[2];
 
				}

			});

			
			}
 
			function showError(error) {
			  switch(error.code) {
				case error.PERMISSION_DENIED:
				  x.innerHTML = 'User denied the request for Geolocation.'
				  break;
				case error.POSITION_UNAVAILABLE:
				  x.innerHTML = 'Location information is unavailable.'
				  break;
				case error.TIMEOUT:
				  x.innerHTML = 'The request to get user location timed out.'
				  break;
				case error.UNKNOWN_ERROR:
				  x.innerHTML = 'An unknown error occurred.'
				  break;
			  }
			}
	
		 
			
		}
		
		function opcao2(){
			document.getElementById('opcao1').style.display = 'none';
			document.getElementById('opcao2').style.display = 'block';
		}
		
		function atualiza_locais_disponiveis() {
			
			document.getElementById('endereco').style.display = 'none';
			document.getElementById('telefone').style.display = 'none';
			document.getElementById('imagem').style.display = 'none';
			
			var cidade = document.getElementById('cidade').value;
			
			if (cidade != 'CIDADES' && cidade != ''){
				document.getElementById('locais_disponiveis').disabled = false;
			} else {
				document.getElementById('locais_disponiveis').disabled = true;

			} 
			
			var urlPopularCidade = 'https://www.newaiter.com.br/newaiter/tela-inicial/1-ajax-escolha-do-local.php';
			// AJAX	
			$.ajax({
				type: 'POST',
				url: urlPopularCidade,
				dataType: 'json',
				data: {
					cidade
				},
				success: function(data) {
					
					$(locais_disponiveis).empty();
					$(locais_disponiveis).append('<option >' + 'LOCAIS' + '</option>');
					
					 jQuery.each(data, function(index) {

						$(locais_disponiveis).append('<option >' + data[index] + '</option>');
					});
 
				}

			});
		}
  
		function pega_dados_local() {
			
			var locais_disponiveis = document.getElementById('locais_disponiveis').value;

			if (locais_disponiveis != 'LOCAIS' && locais_disponiveis != ''){
				document.getElementById('endereco').style.display = 'block';
				document.getElementById('telefone').style.display = 'block';
				document.getElementById('imagem').style.display = 'block';
			} else {
				document.getElementById('endereco').style.display = 'none';
				document.getElementById('telefone').style.display = 'none';
				document.getElementById('imagem').style.display = 'none';
			}
			
			var urlPopularDadosLocal = 'https://www.newaiter.com.br/newaiter/tela-inicial/2-ajax-dados-local.php';

			// AJAX	
			$.ajax({
				type: 'POST',
				url: urlPopularDadosLocal,
				dataType: 'json',
				data: {
					locais_disponiveis
				},
				success: function(data) {
					
					document.getElementById('endereco').innerHTML = data[0];
					document.getElementById('telefone').innerHTML = data[1];
					document.getElementById('imagem').innerHTML = data[2];
 
				}

			});
		}

	</script>";
	*/
	// ***** FORM

	$pt1 = $script."
 
		<div class='c-modal-body'>
			<form method='POST' enctype='multipart/form-data' name='frm_new_edit' id='frm_new_edit' action='https://www.newaiter.com.br/newaiter/tela-inicial/post.php'>
				<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
					".$pt1."
				</div>
				<div class='clear'></div>
				<div class='card-footer'>
					<div id='card_footer'>
						<button class='btn btn-danger' type='submit' id='btn_salvar_escolha' name='btn_salvar_escolha'>Salvar</button>
						<button class='btn btn-danger' type='button' name='btn_cancelar'>Cancelar</button>
					</div>
				</div>
			</form>
		</div>";
		
				    			
	echo $cabecalho;	
	
							
	?>

	<section class="content-header">
		<ol class="breadcrumb"></ol>
	</section>

	<section class="content">

		<section id='S_QUERY'>
			<div class="container">
			  <div class="row" align="center">
				<div class="col-12">
					<?echo $pt1;?>
				</div>
			  </div>
			</div>						
		</section>

	</section>

	<?

		echo $rodape;

} else {
	$_SESSION['VERICACOES'] = 'POR FAVOR, REALIZE O LOGIN PARA CONTINUAR';
	header('Location: https://www.newaiter.com.br/newaiter/login/1-login.php');
}

?>