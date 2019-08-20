/*
    Ajax no Wordpress
    () Função PHP
    () admin-ajax.js
    () Função JS
*/
jQuery(function($){

    //Setar o valor de janeiro na variável mês
    var mes = 'Janeiro';

    var listagemSantosAjax = function(mes){
        $.ajax({
            url: wp.ajaxurl,
            type: 'GET',
            data:{
                action: 'listagemSantos',
                mes: mes
            },
            beforeSend:function(){
                $('#lista-santos').html(`
                    <div class="spinner-loading"></div>
                `);
            }
        })
        .done(function(resposta){
            $('#lista-santos').html('');
            let success = resposta.success;
            if(success){
                //Preenche tabela
                $.each(resposta.data.santos, function(i, santo){
                    $('#lista-santos').append(`
                    <tr>
                        <th id="id-santo" class="invisivel"> ${santo.id} </th>
                        <th id="imagem"> <img class="img-tabela" src="${santo.imagem}" alt="${santo.imagem}" > </th>
                        <th id="mes"> ${santo.mes} </th>
                        <th id="dia"> ${santo.dia} </th>
                        <th id="nome"> ${santo.nome} </th>
                    </tr>
                    `);
                });
                
            }else{
                $('#lista-santos').html(`
                    <div class="alerta erro">
                        ${resposta.data.msg}
                    </div>
                `);
            }
        })
        .fail(function(){
            $('#lista-santos').html('');
            $('#lista-santos').html(`
                <div class="alerta erro">
                    ${resposta.data.msg}
                </div>
            `);
        })
    }
    
    //Ação do botão de meses
    $('.item-lista').on('click', function(){
        mes = $(this).find('span').text();
        listagemSantosAjax(mes);
        $('.item-lista').removeClass('active');
        $(this).addClass('active');
    });

    $('#img-upload').change( function(event) {
        $tmppath = URL.createObjectURL(event.target.files[0]);
        $("img.img-upload").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
        //$("#disp_tmp_path").html("Temporary Path=>  <strong>["+$tmppath+"]</strong>");
    });

    function preencheFormData(){
        let nome = $('#nome').val();
        let mes = $('#mes').val();
        let dia = $('#dia').val();
        let conteudo = $('#conteudo').val();
        
        var form = $('formulario')[0];
        var formData = new FormData(form);
        formData.append('imagem', $('input[type=file]')[0].files[0]);
        formData.append('dia', dia);
        formData.append('mes', mes);
        formData.append('nome', nome);
        formData.append('conteudo', conteudo);
        return formData;
    }
    
    $('#salvar').on('click', function(event){
        event.preventDefault();
        var formData = preencheFormData();
        formData.append('action', 'salvar');
        adicionarSantoAjax(formData);
    });
    $('#editar').on('click', function(event){
        event.preventDefault();
        var formData = preencheFormData();
        let id = $('#id-editar').val();
        formData.append('id', id);
        formData.append('action', 'editar');
        atualizarSantoAjax(formData);
    });

    var adicionarSantoAjax = function(formData){
        $.ajax({
            url: wp.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,  
            contentType: false,
            cache: false,
            beforeSend:function(){
                $('#alerta').html(`
                    <div class="alerta warning">
                        Processando...
                    </div>
                `);
            }
        })
        .done(function(resposta){
            $('#alerta').html('');
            let success = resposta.success;
            if(!success){
                $('#alerta').html(`
                    <div class="alerta erro">
                        ${resposta.data.msg}
                    </div>
                `);            
            }else{
                $('#alerta').html(`
                <div class="alerta sucesso">
                    <p> ${resposta.data.santo.nome} (${resposta.data.santo.dia}/${resposta.data.santo.mes})
                    foi incluso na base de dados! </p>
                </div>
                `);
            }
        })
        .fail(function (resposta) {
            $('#alerta').html('');
            $('#alerta').html(`
                <div class="alerta erro">
                    ${resposta.data.msg}
                </div>
            `);
        })
    }

    $('#formulario-excluir').on('click', function(event){
        event.preventDefault();
        let id = $('#id-excluir').val();
        excluirSantoAjax(id);
        $('#excluirModal').addClass('invisivel');
        return false;
    });

//Modal Excluir
//Abrir modal
$('#button-modal-excluir').on('click', function(event){
    $('#modal-excluir').addClass('visivel');
});
$('#button-modal-editar').on('click', function(event){
    $('#modal-editar').addClass('visivel');
});
//Fechar emodal
$('#modal-excluir').on('click', function() {
    fecharModalExcluir();
})
$('#modal-editar').on('click', function() {
    fecharModalEditar();
})
//Fechar modal
$('#link-fechar').on('click', function(event){
    fecharModalEditar(); 
});

function fecharModalExcluir(){
    $('#modal-excluir').removeClass('visivel');
    $('#modal-excluir').addClass('invisivel');
}

function fecharModalEditar(){
    $('#modal-editar').removeClass('visivel');
    $('#modal-editar').addClass('invisivel');
}

//Chama função de excluir
$('#link-excluir').on('click', function(event){
    let id = $('#id-excluir').val();
    console.log('Id: '+id);
    excluirSantoAjax(id);
    $('#modal-excluir').removeClass('visivel');
    $('#modal-excluir').addClass('invisivel');
});


    var excluirSantoAjax = function(id){
        $.ajax({
            url: wp.ajaxurl,
            type: 'POST',
            data:{
                action: 'excluirSanto',
                id: id
            },
            beforeSend:function(){
                console.log('AjaxLoading Remove...');
                $('#alerta').removeClass('invisivel');
                $('#alerta').html(`
                    <div class="alerta warning">
                        Processando...
                    </div>
                `);
            }
        })
        .done(function(resposta){
            $('#alerta').html('');
            $('#alerta').html(`
                <div class="alerta sucesso">
                    ${resposta.data.msg}
                </div>
            `);
            listagemSantosAjax(mes);
        })
        .fail(function(resposta){
            $('#alerta').html('');
            $('#alerta').html(`
                <div class="alerta erro">
                    ${resposta.data.msg}
                </div>
            `);
        })
    }
    

    //Chama função de editar
    $('#link-editar').on('click', function(event){
        let id = $('#id-editar').val();
        console.log('Id: '+id);
        excluirSantoAjax(id);
        $('#modal-excluir').removeClass('visivel');
        $('#modal-excluir').addClass('invisivel');
    });


    var atualizarSantoAjax = function(formData){
        $.ajax({
            url: wp.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,  
            contentType: false,
            cache: false,
            beforeSend:function(){
                $('#alerta').html(`
                    <div class="alerta warning">
                        Processando...
                    </div>
                `);
            }
        })
        .done(function(resposta){
            $('#alerta').html('');
            let success = resposta.success;
            if(!success){
                $('#alerta').html(`
                    <div class="alerta erro">
                        ${resposta.data.msg}
                    </div>
                `);
            }else{
                $('#alerta').html(`
                    <div class="alerta sucesso">
                        ${resposta.data.msg}
                    </div>
                `);
            }
        })
        .fail(function (resposta) {
            $('#alerta').html('');
            $('#alerta').html(`
                <div class="alerta erro">
                    ${resposta.data.msg}
                    <br>Não foi possível alterar o santo. Tente novamente mais tarde
                </div>
            `);
        })
    }

})