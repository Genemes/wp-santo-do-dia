<?php
$id = (int)$_POST['id-editar'];
$dao = new Dao();
$santo = $dao->getSanto($id);
	

//variáveis globais
$classe = 'erro';
$mensagem = '';
$img;
?>

<div id="welcome-panel" class="welcome-panel">
	<div class="welcome-panel-content">
        <h2>Bem-vindo(a) ao Santo do dia!</h2>
    	<p class="about-description">Aqui você poderá adicionar novos santos, que irão aparecer no App e no site.</p>
		<br>
		<br>
			<form id="formulario" class="formulario" enctype="multipart/form-data" action="#" method="POST">
				<div class="input-box">
					<input id="id-editar" type="hidden" name="id-editar" value="<?php print $santo->id; ?>">
					<input id="nome" type="text" name="nome" value="<?php print $santo->nome; ?>" required>
					<label for="nome">Informe o nome do Santo</label>
				</div>
				<div class="input-box">
					<input id="dia" type="number" name="dia" value="<?php print $santo->dia; ?>" min="1" max="31" required>
					<label for="dia">Informe o dia</label>
				</div>
				<div class="input-box">
					<input id="mes" id="mes" type="number" name="mes" value="<?php print $santo->mes; ?>" min="1" max="12" required>
					<label for="mes">Informe o mês</label>
				</div>

				<?php
					$content = $santo->conteudo;
					$editor_id = 'conteudo';
					wp_editor( $content, $editor_id, array(
						'textarea_name' => $editor,
						'media_buttons'=>true,
						'tinymce'=>true,
						'textarea_rows'=>3,
						'wpautop'=>false,
						'editor_css' => '<style> .wp-editor-area{ color: #000 !important } </style>'
						)
					);
				?>

				<div>
					Atualizar imagem do santo: <input type="checkbox" name="check" /> 
				</div>

				<div class="input-file" id="atualizar">
					<label for="imagem">Imagem</label>
					<input id="imagem" type="file" name="imagem" value="">
					<img src="" class="img-upload" style="display:none;" />
					<br>
					<div id="disp_tmp_path"></div>
					<input type="hidden" name="checkbox" id="checkbox">
				</div>
				<input id="editar" class="botao btn-sucesso" name="Editar" type="submit">
				<div id="alerta"></div>
			</form>

			
            
        </div>
	</div>
</div>