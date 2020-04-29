// $("inicio").datepicker(() => {
//
// });
const $documento_add = document.getElementById('documento_add');

$documento_add.addEventListener('click', (e) => {
    e.preventDefault();
    const $lista_documentos = document.getElementById('lista_documentos');

    // div input grupo
    const $div_input_group = document.createElement('div');
    $div_input_group.className = 'input-group';

    const $div_input_group_append = document.createElement('div');
    $div_input_group_append.className = 'input-group-append';

    // cria button insere
    // const $botao_insere = document.createElement('a');
    // $botao_insere.className = 'btn btn-outline-secondary btn-success';
    // const $i_botao_insere = document.createElement('i');
    // $i_botao_insere.className = 'fas fa-check-circle';
    // $botao_insere.appendChild($i_botao_insere);

    // cria button delete
    const $botao_delete = document.createElement('a');
    $botao_delete.className = 'btn btn-outline-secondary btn-danger';
    $botao_delete.id = 'botao_delete';
    const $i_botao_delete = document.createElement('i');
    $i_botao_delete.className = 'fas fa-minus-circle';
    $botao_delete.appendChild($i_botao_delete);

    // adiciona os botões ao div
    // $div_input_group_append.appendChild($botao_insere);
    $div_input_group_append.appendChild($botao_delete);

    // cria li
    const $li = document.createElement('li');
    $li.className = 'list-group-item';


    // cria input para ID do documento
    const $input_id = document.createElement('input');
    $input_id.className = 'form-control';
    $input_id.placeholder = 'id';
    $input_id.type = 'hidden';
    $input_id.name = 'documentos[id][]';

    // cria input para Nome do documento
    const $input_nome = document.createElement('input');
    $input_nome.className = 'form-control';
    $input_nome.placeholder = 'Nome';
    $input_nome.required = 'required';
    $input_nome.type = 'text';
    $input_nome.name = 'documentos[nome][]';

    // cria input para Descrição do documento
    const $input_descricao = document.createElement('input');
    $input_descricao.className = 'form-control';
    $input_descricao.placeholder = 'Descrição';
    $input_descricao.required = 'required';
    $input_descricao.type = 'text';
    $input_descricao.name = 'documentos[descricao][]';

    // adiciona os botões ao div
    $div_input_group.appendChild($input_id);
    $div_input_group.appendChild($input_nome);
    $div_input_group.appendChild($input_descricao);
    $div_input_group.appendChild($div_input_group_append);

    // adiciona input no li
    $li.appendChild($div_input_group);

    // adiciona li na ul
    $lista_documentos.appendChild($li);

    // move foco para input
    $input_nome.focus();
});

//  document.body.addEventListener('click', (e) => {
//     if (e.target.id == 'botao_delete') {
//         console.log(e.target);
//         e.target.parentNode.parentNode.parentNode.remove();
//         // const $documento = e.target.parentNode.parentNode.parentNode;
//         // $documento.remove();
//         // console.log('vanilla');
//     }
// });

// Exclusão de algum documento
$("body").on("click", "#botao_delete", function(e) {
    const $documento_li = this.parentNode.parentNode.parentNode;
    $documento_li.remove();
});
