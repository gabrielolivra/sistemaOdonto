$(document).ready(function () {
    // Aplica a máscara ao campo de CEP
    $('#cep').inputmask('99999-999');
    $('#cpf').inputmask('999.999.999-99');
    $('#telefone').inputmask('(99) 99999-9999');
});

        $('#nome').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#endereco').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#cidade').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });
        $('#estado').on('input', function () {
            $(this).val($(this).val().toUpperCase());
        });

function buscarCEP() {
    var cep = document.getElementById('cep').value;
    if (cep.length === 9) { // Ajuste para considerar o formato com a máscara
        fetch(`https://viacep.com.br/ws/${cep.replace('-', '')}/json/`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('cidade').value = data.localidade || '';
                document.getElementById('estado').value = data.uf || '';
            })
            .catch(error => console.error('Erro ao buscar CEP:', error));
    }
}