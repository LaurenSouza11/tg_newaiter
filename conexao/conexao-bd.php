<?

//==========================================
//        CONEXÃO COM O BANCO DE DAODOS
// ==========================================

function connect_pdo_mysql() {
 
	$host = 'mysql.newaiter.com.br';
	$dbname = 'newaiter';
	$user = 'newaiter';
	$password = 'lauren121117';

	try {

		$DB = new PDO("mysql:host=$host;dbname=$dbname", $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		$DB->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');

	} catch(PDOException $e) {
		
		if ($_SESSION['debug'] == 1) {	
			throw new PDOException($e);
			echo 'Erro: ' . $e->getMessage();
		}

	}

	return $DB;

}

?>
