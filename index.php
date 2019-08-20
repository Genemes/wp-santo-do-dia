<?php

/*
 * Plugin Name: Santo do dia - Siloé
 * Plugin URI: http://siloe.org.br
 * Description: Plugin responsável por gerenciar o "Santo do dia", tanto no site como no app ENSS. Com esse plugin podemos adicionar, listar, editar e excluir os santos.
 * Version: 2.0
 * Author: Francisco Genemes
 * Author URI: http://siloe.org.br/
 */

//chamando a função de criação da tabela no banco de dados após o plugin ser instalado
register_activation_hook( __FILE__, 'instalarPluginSanto' );

// Criação da tabela na base de dados
function instalarPluginSanto() {
	global $wpdb;
	$tabela = $wpdb->prefix . "santo";
	$sql = "CREATE TABLE $tabela(
	id INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR(255) NOT NULL,
	dia INT NOT NULL,
	mes INT NOT NULL,
	conteudo LONGTEXT NOT NULL,
	imagem VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (id)
	)";
	//carregando o arquivo upgrade.php. Este arquivo eh responsável por executar os comandos acima.
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
//chamando quando o plugin é desintalado
register_uninstall_hook( __FILE__, 'desinstalarPluginSanto' );

// Exclusão da tabela na base de dados
function desinstalarPluginSanto() {
	echo 'Plugin desinstalado!';
}

require_once ('app/loader.php');

add_action( "admin_menu", "criarMenuSantos" );
function criarMenuSantos() {
	$icon_url = 'dashicons-groups';
	add_menu_page( "Gerenciar Santo", "Santo do dia", 0, "add-santo-menu", "addSanto", $icon_url, 20);
	add_submenu_page( "add-santo-menu", "Listar Santos", "Listar Santos", 0, "submenu-listar-santo", "listarSantos" );
	add_submenu_page( "add-santo-menu", "Atualizar Santo", "Atualizar Santos", 0, "submenu-atualizar-santo", "atualizarSanto" );
}

function addSanto() {
	require_once ('app/add.php');
}

function listarSantos() {
	//require_once ('listarSantos.php');
	require_once ('app/lista.php');
}

function atualizarSanto(){
	//require_once ('atualizarSanto.php');
	require_once ('app/update.php');
}
/*Adicionando rotas WP-API*/
require_once ('app/santo-json.php');

/*Adicionando funções Ajax*/
require_once ('_ajax/listar-santo.php');
require_once ('_ajax/add-santo.php');
require_once ('_ajax/delete-santo.php');

?>