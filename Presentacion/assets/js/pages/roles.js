// Para personalizar el mensaje de sweetAlert2
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-danger me-2",
    cancelButton: "btn"
  },
  buttonsStyling: false
});


function eliminar_rol(id) {
  swalWithBootstrapButtons.fire({
    title: "¿Estás seguro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "¡Si, borralo!",
    buttonsStyling: false,
    showCloseButton: true
  }).then((result) => {
    if (result.isConfirmed) {
      console.log('asdasdasda  paso')
      fetch(`roles/eliminar/${id}`, { method: 'POST' })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          swalWithBootstrapButtons.fire({
            title: "¡Eliminado!",
            text: "El rol ha sido eliminado.",
            icon: "success",
          }).then(() => location.reload())
        }
      })
    }
    
  })
}

document.addEventListener("DOMContentLoaded", function() {
  pathname = window.location.pathname
  if (pathname === '/roles') {
    document.getElementById("dt-search-0").focus()
  } else if (pathname === '/roles/nuevo' || pathname.startsWith('/roles/editar/')) {
    const form_rol = document.getElementById('form_rol');
    form_rol.addEventListener('submit', (event) => nuevo_rol(event))
  } 
})

function nuevo_rol(event) {
  event.preventDefault()

  const datos = new FormData(form_rol)

  fetch('', { method: 'POST', body: datos })
  .then(response => response.json())
  .then(data => {
    console.log(data)
  })
}