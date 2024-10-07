



document.addEventListener('DOMContentLoaded', function () {

  if (mensagemErro) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: mensagemErro,
    })
  }
  if (mensagemAlerta) {
    Swal.fire({
      icon: 'warning',
      title: 'Atenção',
      text: mensagemAlerta,
    })
  }
  if (mensagemSucesso) {
    Swal.fire({
      icon: 'success',
      title: 'Sucesso',
      text: mensagemSucesso,
    })
  }
});


// Inicializar a tabela #tabela_itens2, independentemente
if ($.fn.dataTable.isDataTable('#tabela_itens')) {
  table = $('#tabela_itens').DataTable();
} else {
  // Se ainda não foi inicializada, configurar DataTable para #tabela_itens2
  table = $('#tabela_itens').DataTable({
    "language": {
      processing: "Processando...",
      search: "Pesquisar&nbsp;:",
      lengthMenu: "Mostrar _MENU_ itens",
      info: "Exibindo _START_ a _END_ item em _TOTAL_ itens",
      infoEmpty: "Exibindo item de 0 a 0 de 0 itens",
      infoFiltered: "(filtrado por _MAX_ itens no total)",
      infoPostFix: "",
      loadingRecords: "Carregando...",
      zeroRecords: "Nenhum item para exibir",
      emptyTable: "Nenhum dado disponível na tabela",
      paginate: {
        first: "Primeiro",
        previous: "Anterior",
        next: "Próximo",
        last: "Último"
      },
      aria: {
        sortAscending: ": habilita a ordenação da coluna em ordem crescente",
        sortDescending: ": habilita a ordenação da coluna em ordem decrescente"
      }
    }
  });
}


document.addEventListener('DOMContentLoaded', function () {
  // Seleciona todos os elementos de alerta com a classe 'alert-dismissible'
  var alertElement = document.querySelector('.alert-dismissible');

  if (alertElement) {
    // Define um tempo de 5 segundos para desaparecer
    setTimeout(function () {
      alertElement.style.display = 'none';
    }, 5000); // 5000 milissegundos = 5 segundos
  }
});

