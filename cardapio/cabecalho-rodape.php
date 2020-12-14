<?


function cabecalho($pageTitle, $leftTitle, $userName, $imgProfile) {
	
	if(!isset($_SESSION)) {
	session_start();
}
  
date_default_timezone_set('America/Sao_Paulo');
ob_start();
   
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once($_SERVER['DOCUMENT_ROOT'].'newaiter/conexao/conexao-bd.php');
$DB = connect_pdo_mysql();

$local = $_SESSION['IMAGEM_LOGO'];
$pedido = $_SESSION['PEDIDO'];
$tipos_disponiveis = '';

$query = "SELECT DISTINCT grupo, grupo_tipo_alimento_bebida.tipo_grupo FROM cardapio 
		  INNER JOIN grupo_tipo_alimento_bebida ON cardapio.grupo = grupo_tipo_alimento_bebida.id 
		  WHERE ".$local." = 1";

	$stmt = $DB->prepare($query);
	$stmt->execute();
	$result = $stmt->fetchAll();

	if (count($result)) {

		foreach($result as $row) {
	
			$tipo_grupo = $row->tipo_grupo;
			$tipo_grupo_lower =  strtolower($tipo_grupo);
			
			$tipos_disponiveis = $tipos_disponiveis."
													<li class='nav-item'>
														<a href='https://www.newaiter.com.br/newaiter/cardapio/".$tipo_grupo_lower.".php' class='nav-link'>
															<p>".$tipo_grupo."</p>
														</a>
													</li>";
		
		}
	} 

	$nav = "
	<nav class='main-header navbar navbar-expand navbar-white navbar-light'>

		<ul class='navbar-nav'>
		
			<li class='nav-item'>
				<a class='nav-link' data-widget='pushmenu' href='#'><i class='fas fa-bars'></i></a>
			</li>

			<li class='nav-item'>

				<a class='btn btn-app'>
				<span class='badge bg-warning' 
				style='font-size: 12px;'>3232</span>
					<i class='fas fa-heart'></i> 404
				</a>

				<a class='btn btn-app'>
				<span class='badge bg-danger' 
				style='font-size: 12px;'>2323</span>
					<i class='fas fa-heart'></i> Error
				</a>
				
				<a class='btn btn-app' style='background-color: #5A6268; color: white;'>
					<i class='fas fa-edit'></i> Edit
				</a>
				<a class='btn btn-app' style='background-color: #5A6268; color: white;'>
					<i class='fas fa-play'></i> Play
				</a>
				<a class='btn btn-app' style='background-color: #5A6268; color: white;'>
					<i class='fas fa-pause'></i> Pause
				</a>
				<a class='btn btn-app' style='background-color: #5A6268; color: white;'>
					<i class='fas fa-save'></i> Save
				</a>
				<a class='btn btn-app' style='background-color: #5A6268; color: white;'>
				<span class='badge bg-warning'>3</span>
					<i class='fas fa-bullhorn'></i> Teste
				</a>
				<a class='btn btn-app'>
				<span class='badge bg-success'>300</span>
					<i class='fas fa-barcode'></i> Products
				</a>
				<a class='btn btn-app'>
				<span class='badge bg-purple'>891</span>
					<i class='fas fa-users'></i> Users
				</a>
				<a class='btn btn-app'>
				<span class='badge bg-teal'>67</span>
					<i class='fas fa-inbox'></i> Orders
				</a>
				<a class='btn btn-app'>
				<span class='badge bg-info'>12</span>
					<i class='fas fa-envelope'></i> Inbox
				</a>
				<a class='btn btn-app'>
				<span class='badge bg-danger' 
				style='font-size: 12px;'>531</span>
					<i class='fas fa-heart'></i> Likes
				</a>
			</li>			

		</ul>
		
	</nav>";
	
	$nav = "
	<nav class='main-header navbar navbar-expand navbar-dark navbar-danger'>
	
		<div class='col-2 col-md-1 col-lg-1 col-xl-1' >
			<ul class='navbar-nav'>
				<li class='nav-item'>
					<a class='nav-link' data-widget='pushmenu' href='#'><i class='fas fa-bars'></i></a>
				</li>
			</ul>
		</div>
		<div class='col-8' align='left'>
			<h3>".$pageTitle."</h3>
		</div> 
		<div class='col-2 image' align='right'>
			<img src='https://www.newaiter.com.br/newaiter/imagens/logo/".$local.".png' class='elevation-2' style='border-radius: 5px; max-height: 50px;' alt='User Image'>
		</div>

	</nav>";

	$cabecalho = "
           
	<!DOCTYPE html>

	<html lang='pt-br'> 

		<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<title>".$pageTitle."</title>
			<meta name='viewport' content='width=device-width, initial-scale=1'>
			<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/fontawesome-free/css/all.css'>
			<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css'>
			<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/jqvmap/jqvmap.min.css'>
			<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/admin/dist/css/adminlte.css'>
			<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'>
			<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css'>
			<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/css-novo/newaiter.css'>		
<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/css-novo/datagrid.css'>	  
<link rel='stylesheet' href='https://www.newaiter.com.br/newaiter/estrutura/style/css-novo/modal.css'>	       	
		</head>
		   
		<body class='hold-transition sidebar-mini layout-fixed'>
		
			<!-- início do preloader -->
			<div id='preloader'>
				<div class='inner'>
				   <div class='bolas'>
					  <div></div>
					  <div></div>
					  <div></div>                    
				   </div>
				</div>
			</div>
			<!-- fim do preloader -->
	
			<div class='wrapper'>
		
				".$nav."
					
				<aside class='main-sidebar sidebar-light-danger elevation-4'>
					<a href='https://www.newaiter.com.br/newaiter/cardapio/index.php' class='brand-link'>
						<span class='brand-text font-weight-light' align='center'><b>".$leftTitle."</b></span>
					</a>
					<div class='sidebar'>
						<div class='user-panel mt-3 pb-3 mb-3 d-flex'>
							<div class='info'>
								<a href='#' class='d-block' style='color:black;'>".$userName."</a>
							</div>
						</div>
						
						<nav class='mt-2'>
							<ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>
							   <li class='nav-item has-treeview menu-open'>
									<a href='#' class='nav-link'> <i class='far fa-file-alt'></i>
										<p>&nbsp; Cardápio <i class='fas fa-angle-left right'></i> </p>
									</a>
									<ul class='nav nav-treeview'>

										".$tipos_disponiveis."

									</ul>
								</li>
								<li class='nav-item has-treeview menu-open'>
									<a href='#' class='nav-link'> <i class='far fa-file-alt'></i>
										<p>&nbsp; Pedidos <i class='fas fa-angle-left right'></i> </p>
									</a>
									<ul class='nav nav-treeview'>

										<li class='nav-item'>
											<a href='https://www.newaiter.com.br/newaiter/cardapio/pedido.php' class='nav-link'>
												<p>COMANDA</p>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</nav>
						<nav class='mt-2'>
							<ul class='nav nav-pills nav-sidebar flex-column' data-widget='treeview' role='menu' data-accordion='false'>
							   <li class='nav-item has-treeview menu-open'>
									<ul class='nav nav-treeview'>
										<li class='nav-item'>
											<a href='https://www.newaiter.com.br/newaiter/login/1-login.php' class='nav-link'>
												<div class='center'><u><b>SAIR</b></u></div>
											</a>
					
										</li>
									</ul>
								</li>
							</ul>
						</nav>
						
					</div>
				</aside>
				
				<div class='content-wrapper'>
					<section class='content'>
						<div class='container-fluid'>";
			
	return $cabecalho;

}

// ==========================================
//                    RODAPÉ
// ==========================================

function rodape() {
	
	$rodape = "					
						</div>
					</section>
				</div>
				
				<footer class='main-footer'>
					<strong>Copyright &copy; 2020 Newaiter.</strong>
					<div class='float-right d-none d-sm-inline-block'>
						<b>Versão</b> 3.0
					</div>
				</footer>
				<aside class='control-sidebar control-sidebar-dark'></aside>
			</div>
			
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/jquery/jquery.min.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/jquery-ui/jquery-ui.min.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/jqvmap/jquery.vmap.min.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/jqvmap/maps/jquery.vmap.usa.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/jquery-knob/jquery.knob.min.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/dist/js/adminlte.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/dist/js/demo.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/datatables/jquery.dataTables.js'></script>
			<script src='https://www.newaiter.com.br/newaiter/estrutura/style/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js'></script>
			
			<script>
				$.widget.bridge('uibutton', $.ui.button)
				
				$(window).on('load', function () {
					$('#preloader .inner').fadeOut();
					$('#preloader').delay(350).fadeOut('slow'); 
					$('body').delay(350).css({'overflow': 'visible'});
				})	
 
				 $(function () {
					$('#example1').DataTable();
					$('#example2').DataTable({
					  'paging': true,
					  'lengthChange': false,
					  'searching': false,
					  'ordering': true,
					  'info': true,
					  'autoWidth': false,
					});
				  });				
				
			</script>		
			 
		</body>
		
	</html>";
	
	return $rodape;
	
}

?>