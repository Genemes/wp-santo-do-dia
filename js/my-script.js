jQuery(function($){
    var selecionaLinhaTabela = function(){
        //Adicionando e removendo classe .selected conforme seleção do usuário
        $('#tabela-santo tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            //habilita os botoes de editar e excluir
            $('#editarModal').prop("disabled", false);
            $('#editarModal').prop("disabled", false);
            desabilitarBotoes();
        }
        else {
            $('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            //Setando valores nos forms
            preencherCamposFormulario();
            //desabilita os botoes de editar e excluir
            $('#editarModal').prop("disabled", true);
            $('#editarModal').prop("disabled", true);
            habilitarBotoes();
        }
    });

    }
    
    function desabilitarBotoes(){
        $('#button-modal-editar').addClass('disabled');
        $('#button-modal-excluir').addClass('disabled');
        $('link-fechar').addClass('disabled');
        $('link-excluir').addClass('disabled');
    }
    
    function habilitarBotoes(){
        $('#button-modal-editar').removeClass('disabled');
        $('#button-modal-excluir').removeClass('disabled');
        $('link-fechar').removeClass('disabled');
        $('link-excluir').removeClass('disabled');
    }

    var clickMenu = function(){
        //Quando clicar no menu, os botões de edição devem ser desabilitados
        $('.item-lista').on('click', function () {
            desabilitarBotoes();
        });
    };

    var preencherCamposFormulario = function(event){
        let idsanto = $('#tabela-santo tr.selected #id-santo').text();
        idsanto = parseInt(idsanto);
        $("#id-editar").val(idsanto);
        $("#id-excluir").val(idsanto);
        let nome = $('#tabela-santo tr.selected #nome').text();
        $('#santo-excluir').html('Deseja realmente excluir ' + nome + '?');
        $('#santo-editar').html('Deseja editar ' + nome + '?');
    }
    var pegarDataAtual = function(){}
    var dataEditar = function(){}
    
    
    var editarImagemSanto = function(){
        $('#atualizar').css('display', 'none');
        $('#checkbox').val('false');
        $('[name="check"]').change(function() {
            $('#atualizar').toggle(200);
        });
    }

    desabilitarBotoes();
    selecionaLinhaTabela();
    clickMenu();
    editarImagemSanto();
});