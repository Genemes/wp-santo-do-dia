<?php
function excluirSanto(){

    $id = $_POST['id'];
    
    $caminho = get_home_path() . 'wp-content/plugins/santo-do-dia-siloe/';
    require_once ( $caminho . 'app/Model/Dao.php');
    require_once ($caminho . 'app/Model/Santo.php');
    
    $dao = new Dao();
    $consulta = $dao->excluir($id);
    
    if( $consulta > 0 ){
        $resposta = [
            'msg' => 'Santo excluído com sucesso.'
        ];
        wp_send_json_success($resposta);
    } else{
        $resposta = [
            'msg' => 'Erro ao excluir.'
        ];
        wp_send_json_error($resposta);
    }
    exit;
}

add_action('wp_ajax_excluirSanto', 'excluirSanto');
add_action('wp_ajax_nopriv_excluirSanto', 'excluirSanto');