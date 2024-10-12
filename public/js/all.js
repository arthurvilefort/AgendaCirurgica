document.addEventListener('DOMContentLoaded', function() {
  // Captura todos os elementos do calendário
  document.querySelectorAll('[id^=calendar]').forEach(function(calendarEl) {
    // Pega o ID da sala a partir do dataset do elemento
    var salaId = calendarEl.dataset.salaId;

    // Pega todas as cirurgias
    var cirurgias = JSON.parse(calendarEl.dataset.cirurgias);
    
    // Pega os tipos de cirurgias também
    var tiposCirurgias = JSON.parse(calendarEl.dataset.tiposCirurgias);

    // Filtra as cirurgias para exibir apenas as da sala correspondente
    var cirurgiasSala = cirurgias.filter(function(cirurgia) {
      return cirurgia.sala_id == salaId;
    });

    // Mapeia os dados para o formato do FullCalendar
    var eventos = cirurgiasSala.map(function(cirurgia) {
      // Busca o nome da cirurgia correspondente ao ID
      var tipoCirurgia = tiposCirurgias.find(function(tipo) {
        return tipo.id == cirurgia.tipo_cirurgia_id;
      }); 

      // Se encontrar o nome do tipo de cirurgia, use-o, senão, mostre o ID
      var nomeTipoCirurgia = tipoCirurgia ? tipoCirurgia.nome : 'Cirurgia ID ' + cirurgia.tipo_cirurgia_id;

      return {
        title: nomeTipoCirurgia, // Exibe o nome do tipo de cirurgia
        start: cirurgia.data + 'T' + cirurgia.data_inicio,  // Combina data e horário de início
        end: cirurgia.data + 'T' + cirurgia.data_fim,       // Combina data e horário de fim
        backgroundColor: '#007bff',
        borderColor: '#007bff',
        cirurgiaId: cirurgia.cirurgia_id  // Passa o ID da cirurgia para o evento
      };
    });

    // Inicializa o calendário
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'pt-br',
      dayMaxEvents: 3, // Exibe o "+X more" quando há mais eventos
      eventTimeFormat: { // Formatação de exibição do tempo
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      events: eventos // Passa os eventos filtrados e formatados para o FullCalendar
    });

    // Renderiza o calendário no modal ao abrir
    $('#modalCalendar' + salaId).on('shown.bs.modal', function() {
      calendar.render();
    });
  });
});



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

