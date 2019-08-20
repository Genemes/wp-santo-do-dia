<?php
//Variáveis globais
$menssagem = [];
$pastaImagem = '';
$url = get_bloginfo("url");

$caminho = ABSPATH . 'wp-content/plugins/santo-do-dia-siloe/';
require_once($caminho . 'app/Model/Dao.php');
require_once($caminho . 'app/Model/Santo.php');

if ($_POST['action'] == 'salvar') {
    adicionarSanto();
} else if ($_POST['action'] == 'editar') {
    updateSanto();
}
function adicionarSanto(){
    $dao = new Dao();
    $santo = $dao->getSantoDiaMes($_POST['dia'], $_POST['mes']);
    if ($santo) {
        $resposta = [
            'msg' => 'Santo já existe na base de dados'
        ];
        wp_send_json_error($resposta);
    } else {
        global $menssagem;
        fazerUpload();
        if($menssagem['status'] == false){
            $resposta = [
                'msg' => $menssagem['msg']
            ];
            wp_send_json_error($resposta);
        }else{
            $santo = new Santo();
            $santo->__set(nome, $_POST['nome']);
            $santo->__set(dia, $_POST['dia']);
            $santo->__set(mes, $_POST['mes']);
            $santo->__set(conteudo, $_POST['conteudo']);
            $santo->__set(imagem, $GLOBALS['url']);
            
            if($dao->salvar($santo) > 0){
                $item = [
                    'nome' => $santo->__get(nome),
                    'dia' => $santo->__get(dia),
                    'mes' => $santo->__get(mes)
                ];
                $resposta = [
                    'msg' => 'Santo salvo com sucesso.',
                    'santo' => $item
                ];
                wp_send_json_success($resposta);
            }else{
                $resposta = [
                    'msg' => 'Erro ao salvar os dados no banco de dados!'
                ];
                wp_send_json_error($resposta);
            }       
        }
    }
    exit();
}


function updateSanto(){
    global $menssagem;
    $dao = new Dao();
    $obj = $dao->getSanto($_POST['id']);
    $santo = new Santo();
    //Variavel para verificar se o upload foi executado
    $upload = false;
    
    $santo->__set(id, $_POST['id']);
    $santo->__set(nome, $_POST['nome']);
    $santo->__set(dia, $_POST['dia']);
    $santo->__set(mes, $_POST['mes']);
    $santo->__set(conteudo, $_POST['conteudo']);
    //Verifica se é necessário fazer upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {
        fazerUpload();
        //Verifica se o upload foi feito corretamente
        if($menssagem['status'] == false){
            $resposta = [
                'msg' => $menssagem['msg']
            ];
            wp_send_json_error($resposta);
        }else{
            $upload = true;
            $santo->__set(imagem, $GLOBALS['url']);
        }
    } else {
        $santo->__set(imagem, $obj->imagem);
    }

    $result = $dao->atualizar($santo);
    if ($result > 0) {
        //Sucesso
        $resposta = [
            'msg' => 'Santo(a) atualizado(a) com sucesso.',
            'status' => true
        ];
        wp_send_json_success($resposta);
    } else if ($result === 0) {
        $resposta = [];
        if($upload){
            $resposta = [
                'msg' => 'A imagem do santo foi atualizada!',
                'status' => true
            ];
        }else{
            $resposta = [
                'msg' => 'Operação realizada com sucesso, entretanto nenhuma alteração foi realizada',
                'status' => false
            ];
        }
        //Sucesso, mas sem atualização na base de dados
        wp_send_json_success($resposta);
    } else {
        //Erro
        $resposta = [
            'msg' => 'Ocorreu um erro ao atualizar. Tente novamente mais tarde.'
        ];
        wp_send_json_error($resposta);
    }

    exit();
}

function fazerUpload(){
    $upload = false;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {
        $extensoes_aceitas = array('bmp', 'jpg', 'png');
        $array_extensoes = explode('.', $_FILES['imagem']['name']);
        $extensao = strtolower(end($array_extensoes));
         // Validamos se a extensão do arquivo é aceita
        $extensaoImagem = substr($_FILES['imagem']['name'], -3);        
        if (array_search($extensaoImagem, $extensoes_aceitas) === false) {
            $msg = 'A extensao do arquivo esta invalida. Tente imagens nos formatos: .png, .jpg ou .bmp';
            manipulaArrayGlobal($upload, $msg);
        }
        // Verifica se o upload foi enviado via POST   
        else if (is_uploaded_file($_FILES['imagem']['tmp_name'])) {
            $upload['pasta'] = ABSPATH. 'wp-content/uploads/santos/';
            if (!file_exists( $upload['pasta'] )){
                mkdir( $upload['pasta'] , 0755);
            }
            // Monta o caminho de destino com o nome do arquivo  
            $GLOBALS['pastaImagem'] = ABSPATH . 'wp-content/uploads/santos/'. $_POST['dia'] . "-" . $_POST['mes'] . "." . $extensaoImagem;
            $GLOBALS['url'] =  get_bloginfo("url") . '/wp-content/uploads/santos/'  . $_POST['dia'] . "-" . $_POST['mes'] . "." . $extensaoImagem;
            // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $GLOBALS['pastaImagem'] )) {
                $upload = true;
                $msg = 'Upload realizado com sucesso!';
                manipulaArrayGlobal($upload, $msg);
            } else {
                $msg = 'Houve um erro de upload ao tentar gravar a imagem!';
                manipulaArrayGlobal($upload, $msg);
            }
        }
    } else {
        $retorno = false;
        $msg = 'Erro ao realizar upload';
        manipulaArrayGlobal($retorno, $msg);
    }
}

function manipulaArrayGlobal( $upload, $msg ){
    global $menssagem;
    $menssagem = null;
    $menssagem = [
        'status' => $upload,
        'msg'    => $msg
    ];
    return $menssagem;
}

add_action('wp_ajax_adicionarSanto', 'adicionarSanto');
add_action('wp_ajax_nopriv_adicionarSanto', 'adicionarSanto');
add_action('wp_ajax_atualizarSanto', 'updateSanto');
add_action('wp_ajax_nopriv_atualizarSanto', 'updateSanto');