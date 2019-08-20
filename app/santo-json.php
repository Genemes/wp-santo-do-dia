<?php
\/**
 * Registra /wp-json/santo/v1/santos route
 */
//Busca todos os santos
add_action( 'rest_api_init', function(){
	register_rest_route('santo/v1', '/santos', array(
		'methods' => 'GET', //WP_REST_Server::READABLE, 
		'callback' => 'get_santos',
		'args' => array(
			'id' => array(
				'validate_callback' => function($param, $request, $key){
					return is_numeric( $param );
				}
			),
		)
	));
});

function get_santos(){
	global $wpdb;
	$tabela = $wpdb->prefix . "santo";
	$query = "Select * FROM {$tabela}";
	$lista = $wpdb->get_results($query);

	if(empty($lista)){
		return new WP_Error('no_saints', 'Nenhum santo encontrado', array('status' => 404));
	}
	return $lista;
}

/**
 * Registra /wp-json/santo/v1/mes/id route
 */
add_action( 'rest_api_init', function(){
	register_rest_route('santo/v1', '/mes/(?P<id>\d+)', array(
		'methods' => 'GET', //WP_REST_Server::READABLE, 
		'callback' => 'get_santos_mes',
		'args' => array(
			'id' => array(
				'validate_callback' => function($param, $request, $key){
					return is_numeric( $param );
				}
			),
		)
	));
});
//Busca santos do mes
function get_santos_mes($data){
	global $wpdb;
	$tabela = $wpdb->prefix . "santo";
	$query = "SELECT * FROM {$tabela} WHERE mes = " . $data['id'];
	$santos = $wpdb->get_results($query);
	if ( empty( $santos ) ) {
		return new WP_Error('no_saint', 'Nenhum santo encontrado neste mês', array('status' => 404));
	}
	return $santos;
}

/**
 * Registra /wp-json/santo/v1/santos/dia route
 */
add_action( 'rest_api_init', function(){
	register_rest_route('santo/v1', '/dia', array(
		'methods' => 'GET', //WP_REST_Server::READABLE, 
		'callback' => 'get_santo_dia',
		'args' => array(
			'id' => array(
				'validate_callback' => function($param, $request, $key){
					return is_numeric( $param );
				}
			),
		)
	));
});
//Busca santo do dia
function get_santo_dia(){
	//alterar o timezone
	$dia = date('d');
	$mes = date('m');
	global $wpdb;
	$tabela = $wpdb->prefix . "santo";
	$query = "SELECT * FROM {$tabela} WHERE mes = " .$mes. " AND dia = ".$dia;
	$santo = $wpdb->get_row($query);

	if(empty($santo)){
		return new WP_Error('no_saint', 'Santo Inválido', array('status' => 404));
	}
	return $santo;
}
