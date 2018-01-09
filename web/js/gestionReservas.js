$('#borrarModal').on('show.bs.modal', function (event) {
  var lanzadera = $(event.relatedTarget) // Enlace que lanza el modal de borrado
  var numReserva = lanzadera.data('whatever')
  var modal = $(this)
  modal.find('.modal-body').text('¿Está seguro que quiere borrar la reserva? ' + numReserva)
  modal.find('#linkBorrarReserva')[0].href=(modal.find('#linkBorrarReserva')).data('whatever')+"/"+numReserva
})
$('#aceptarModal').on('show.bs.modal', function (event) {
  var lanzadera = $(event.relatedTarget) // Enlace que lanza el modal de borrado
  var numReserva = lanzadera.data('whatever')
  var modal = $(this)
  modal.find('.modal-body').text('¿Está seguro que quiere acptar la reserva? ' + numReserva)
  modal.find('#linkAceptarReserva')[0].href=(modal.find('#linkAceptarReserva')).data('whatever')+"/"+numReserva
})
