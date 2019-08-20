<?php
class Controller {
	protected function view( $nome ) {
		$local = get_home_path().'wp-content/plugins/santo-do-dia-siloe/app/View/';
		return require_once ($local . $nome . '.php');
		exit();
	}
}

?>
