<?php

/**
 * Bean contendo informações dos santos.
 *
 * @author Genemes
 */
class Santo {
	private $id;
	private $nome;
	private $dia;
	private $mes;
	private $conteudo;
	private $imagem;

	public function __set($atrib, $value){
	          $this->$atrib = $value;
	}
	public function __get($atrib){
	  return $this->$atrib;
	}

}
