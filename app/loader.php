<?php

function carregar_css_santos() {
	wp_enqueue_style( 'prefix-style', plugins_url('santo-do-dia-siloe/css/estilo.css') );
}
add_action( 'admin_enqueue_scripts', 'carregar_css_santos' );

function carregar_js_santos() {
	$versao = rand(0,999);
    
	wp_register_script(
		'my-script',
		plugins_url( '../js/my-script.js', __FILE__ ),
		array('jquery'),
		$versao, //versão do plugin
		false //carregamento no final da página
	);
	wp_enqueue_script('my-script');

	$js_folder = plugins_url('../js/app.js', __FILE__);
	wp_enqueue_script('app', $js_folder, null, $versao, false);

	$wpVars = [
		'ajaxurl' => admin_url('admin-ajax.php')
	];
	wp_localize_script('app', 'wp', $wpVars);
	
}
add_action( 'admin_enqueue_scripts', 'carregar_js_santos' );
?>