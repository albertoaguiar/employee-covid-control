import './bootstrap';
import $ from 'jquery';
import 'jquery-inputmask';

$(document).ready(function(){
    $('#cpf').inputmask('999.999.999-99'); // Exemplo de máscara para CPF
});