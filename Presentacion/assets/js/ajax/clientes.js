
document.addEventListener('DOMContentLoaded', function() {
  mostrarToast()

  var eliminarCliente = document.getElementById('EliminarClienteModal')
  var eliminarButton = document.getElementById('eliminar-cliente')

  if (eliminarCliente && eliminarButton) {
    eliminarCliente.addEventListener('show.bs.modal', function (e) {
      const button = e.relatedTarget
      const url = button.getAttribute('href')
      
      eliminarButton.onclick = function(event) {
        fetch(url, { method: 'POST' })
          .then(response => response.json())
          .then(data => {
            toastr.options = {
              "closeButton": true,
              "positionClass": "toast-bottom-right"
            }
            switch (data.status) {
              case 'success':
                button.closest('.cliente').remove()
                document.getElementById("close-modal").click()
                toastr['success'](data.message)
                break
              
              case 'error':
                document.getElementById("close-modal").click()
                toastr['error'](data.message)
                break
            }
          })
      }
    })
  }

})


// function mostrarToast() {
//   const toastMessage = sessionStorage.getItem('toastMessage');
//   if (toastMessage) {
//     toastr.options = {
//       "closeButton": true,
//       "positionClass": "toast-bottom-right"
//     };
//     toastr['success'](toastMessage);
//     sessionStorage.removeItem('toastMessage'); // Limpiar el mensaje después de mostrarlo
//   }
// }


