<?php
$dao = new Dao();
//Sempre começa a listagem pelo mês de Janeiro(1)
$dados = $dao->listaSantoPorMes(1);
?>

<div id="welcome-panel" class="welcome-panel">
	<div class="welcome-panel-content">
	<h2>Listagem dos Santos</h2>
    	<p class="about-description">Aqui você poderá visualizar, buscar, editar ou excluir santos.</p>
	<div id="alerta" class="alerta invisivel"> </div>

<div class="meses">
	<div class="grid">
		<div class="col col--1-of-3">
			<div class="menu">
				<div class="active item-lista"> <span>Janeiro</span> </div>
				<div class="item-lista"> <span>Fevereiro</span> </div>
				<div class="item-lista"> <span>Marco</span> </div>
				<div class="item-lista"> <span>Abril</span> </div>
				<div class="item-lista"> <span>Maio</span> </div>
				<div class="item-lista"> <span>Junho</span> </div>
				<div class="item-lista"> <span>Julho</span> </div>
				<div class="item-lista"> <span>Agosto</span> </div>
				<div class="item-lista"> <span>Setembro</span> </div>
				<div class="item-lista"> <span>Outubro</span> </div>
				<div class="item-lista"> <span>Novembro</span> </div>
				<div class="item-lista"> <span>Dezembro</span> </div>
			</div>
   		</div>
   		<div class="col col--2-of-3">
		   		
			<ul>
				<table id="tabela-santo" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th width="0%" class="invisivel">Id</th>
							<th width="25%">Imagem</th>
							<th width="25%">Mês</th>
							<th width="25%">Dia</th>
							<th width="25%">Nome</th>
						</tr>
					</thead>
					<tbody id="lista-santos">
						<?php 
						foreach ( $dados as $santo ){?>
							<tr>
								<th id="id-santo" class="invisivel"> <?php print $santo->id; ?> </th>
								<th id="imagem"> <img class="img-tabela" src="<?php print $santo->imagem; ?>" alt="<?php print $santo->nome; ?>" > </th>
								<th id="mes"> <?php print $santo->mes; ?> </th>
								<th id="dia"> <?php print $santo->dia; ?> </th>
								<th id="nome"> <?php print $santo->nome; ?> </th>
							</tr> 
					<?php } ?>
					</tbody>
				</table>
			</ul>
			<div class="botoes-edicao">
				<button id="button-modal-editar" class="botao btn-confirm">Editar</button>
				<button id="button-modal-excluir" class="botao btn-erro">Excluir</button>
			</div>

			<div id="modal-excluir" class="modal">
				<div class="modal-content">
					<span id="close" class="close">&times;</span>
					<input type="hidden" name="id-excluir" id="id-excluir">
					<h3 id="santo-excluir">Nenhum santo selecionado</h3>
					<div class="botoes-edicao">
						<a id="link-fechar" class="botao btn-sucesso">Não</a>
						<a id="link-excluir" class="botao btn-confirm">Sim</a>
					</div>
				</div>
			</div>

			<div id="modal-editar" class="modal">
				<div class="modal-content">
					<span id="close" class="close">&times;</span>

					<form class="formulario" action="?page=submenu-atualizar-santo" method="post">
						<input type="hidden" name="id-editar" id="id-editar">
						<h3 id="santo-editar">Nenhum santo selecionado</h3>
						<div class="botoes-edicao">
							<input id="link-fechar" type="submit" class="botao btn-sucesso" value="Editar">
						</div>
					</form>
				</div>
			</div>

   		</div>
  	</div>
 </div>

</div>
