<?php
function listagemSantos(){

    $param = $_GET['mes'];
    $mes = recuperaMes($param);

    $caminho = get_home_path() . 'wp-content/plugins/santo-do-dia-siloe/';
    require_once ( $caminho . 'app/Model/Dao.php');
    require_once ($caminho . 'app/Model/Santo.php');
    
    $dao = new Dao();
    $lista = $dao->listaSantoPorMes($mes);
    
    if( $lista ){
        $itens =[];
        foreach($lista as $santo){
            $item = [
                'id' => $santo->id,
                'nome' => $santo->nome,
                'dia' => $santo->dia,
                'mes' => $santo->mes,
                'conteudo' => $santo->conteudo,
                'imagem' => $santo->imagem,
            ];
            array_push($itens, $item);    
        }
        $resposta = [
            'msg' => 'Santos encontrados.',
            'santos' => $itens
        ];
        wp_send_json_success($resposta);
    } else{
        $resposta = [
            'msg' => 'Nenhum santo encontrado.'
        ];
        wp_send_json_error($resposta);
    }
    exit;
}

function recuperaMes($mes){
    $retorno = 0;
    switch ($mes) {
        case "Janeiro":
            $retorno = 1;
            break;
        case "Fevereiro":
            $retorno = 2;
            break;
        case "Marco":
            $retorno = 3;
            break;
        case "Abril":
            $retorno = 4;
            break;
        case "Maio":
            $retorno = 5;
            break;
        case "Junho":
            $retorno = 6;
            break;
        case "Julho":
            $retorno = 7;
            break;
        case "Agosto":
            $retorno = 8;
            break;
        case "Setembro":
            $retorno = 9;
            break;
        case "Outubro":
            $retorno = 10;
            break;
        case "Novembro":
            $retorno = 11;
            break;
        case "Dezembro":
            $retorno = 12;
            break;
    }
    return $retorno;
}

add_action('wp_ajax_listagemSantos', 'listagemSantos');
add_action('wp_ajax_nopriv_listagemSantos', 'listagemSantos');