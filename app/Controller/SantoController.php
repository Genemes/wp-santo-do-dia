<?php
class SantoController extends Controller {

    public function dispatcher($view){
		$this->view($view);
        exit();
    }

	public function listarSantos() {
		$view = 'listaView';
		$this->dispatcher($view);
	}

	public function addSanto() {
		$view = 'addSantoView';
        $this->dispatcher($view);
	}

	public function updateSanto() {
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ){
			$id = $_POST["id-editar"];
		}
		$id = (int)$_POST['id-editar'];
		
		$dao = new Dao();
        $santo = $dao->getSanto($id);
		if($santo != NULL){
			//Chama a função para visualizar informação
			$view = 'updateSantoView';
			$this->dispatcher($view);
		}else{
			//Não foi selecionado nenhum santo para edição ou o item selecionado é inválido.
			$view = 'listaView';
			$this->dispatcher($view);
		}
		//$this->view($this->$view, $this->$dados);
        exit();
	}

}
?>