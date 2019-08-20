<?php
//variáveis globais
$classe = 'erro';
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
					<input id="nome" type="text" name="nome" required value="Teste">
					<label for="nome">Informe o nome do Santo</label>
				</div>
				<div class="input-box">
					<input id="dia" type="number" name="dia" min="1" max="31" required value="1">
					<label for="dia">Informe o dia</label>
				</div>
				<div class="input-box">
					<input id="mes" id="mes" type="number" name="mes" min="1" max="12" required value="1">
					<label for="mes">Informe o mês</label>
				</div>

				<?php
					$content = 'Conteúdo do santo do dia...';
					$editor_id = 'conteudo';
					wp_editor( $content, $editor_id, array(
						'textarea_name' => $editor_id,
						'media_buttons'=>true,
						'tinymce'=>true,
						'textarea_rows'=>3,
						'wpautop'=>false,
						'editor_css' => '<style> .wp-editor-area{ color: #000 !important } </style>'
						)
					);
				?>

				<div class="input-file">
					<label for="img-upload">Imagem</label>
					<input id="img-upload" type="file" name="img-upload" value="" required >
					<img src="" class="img-upload" style="display:none;" />
					<p class="disp_tmp_path"></p>
					<br>
				</div>
				<input id="salvar" class="botao btn-sucesso" name="Salvar" type="submit">
				<div id="alerta"></div>
			</form>

        </div>
	</div>
</div>