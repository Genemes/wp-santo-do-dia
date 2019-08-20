<?php

class Dao {

	//Lista todos os santos
	public function listaSantoPorMes($mes) {
		$lista = array();
		global $wpdb;
		$tabela = $wpdb->prefix . "santo";
		try {
			$aux = null;
			$keys = $wpdb->get_results("SELECT * FROM {$tabela} WHERE mes = " . $mes);
			foreach ( $keys as $values ) {
				$aux = new Santo();
				$aux->id = $values->id;
				$aux->nome = $values->nome;
				$aux->dia = $values->dia;
				$aux->mes = $values->mes;
				$aux->imagem = $values->imagem;
				array_push($lista, $aux);
			}
			return $lista;
		} catch ( Exception $ex ) {
			print $ex->getMessage();
			return null;
		}
	}

	//Lista todos os santos
	public function readSanto() {
		$lista = array();
		global $wpdb;
		$tabela = $wpdb->prefix . "santo";
		try {
			$aux = null;
			$keys = $wpdb->get_results("SELECT * FROM {$tabela}");
			foreach ( $keys as $values ) {
				$aux = new Santo();
				$aux->id = $values->id;
				$aux->nome = $values->nome;
				$aux->dia = $values->dia;
				$aux->mes = $values->mes;
				$aux->imagem = $values->imagem;
				array_push($lista, $aux);
			}
			return $lista;
		} catch ( Exception $ex ) {
			print $ex->getMessage();
		}
	}

	//Busca um santo
	public function getSanto($id) {
		$santo = null;
		global $wpdb;
		$tabela = $wpdb->prefix . "santo";
		try {
			$aux = null;
			$santo = new Santo();
			$santo = $wpdb->get_row("SELECT * FROM {$tabela} WHERE id = " . $id);
			return $santo;
		} catch ( Exception $ex ) {
			print $ex->getMessage();
			return $santo;
		}
	}
	
	//Busca um santo através dos parâmetros mês e dia
	public function getSantoDiaMes($dia, $mes){
		global $wpdb;
		$tabela = $wpdb->prefix . "santo";
		try {
			$santo = $wpdb->get_row("SELECT * FROM {$tabela} WHERE dia = ".$dia." AND mes = ".$mes);
			return $santo;
		} catch ( Exception $ex ) {
			print $ex->getMessage();
			return null;
		}
	}
	
	public function salvar($santo){
		global $wpdb;
		$tabela = $wpdb->prefix . "santo";
		$dados = array( 
			'nome' => $santo->__get(nome),
			'dia' => $santo->__get(dia),
			'mes' => $santo->__get(mes),
			'conteudo' => $santo->__get(conteudo),
			'imagem' => $santo->__get(imagem)
		);
		return $wpdb->insert( $tabela, $dados );
	}

	public function atualizar($santo){
		global $wpdb;
		$tabela = $wpdb->prefix . "santo";
		$update = $wpdb->update(
			$tabela,
			array(
				'nome' => $santo->__get(nome),
				'dia' => $santo->__get(dia),
				'mes' => $santo->__get(mes),
				'conteudo' => $santo->__get(conteudo),
				'imagem' => $santo->__get(imagem)
			), array('ID' => $santo->__get(id))
		);
		return $update;
	}

	public function excluir($id){
		global $wpdb;
		$tabela = $wpdb->prefix . "santo";
		return $wpdb->delete($tabela, array ('id' => $id));
	}
}
