
// Para personalizar el mensaje de sweetAlert2
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-danger me-2",
    cancelButton: "btn"
  },
  buttonsStyling: false
});


function eliminar_usuario(id_usuario) {
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
      var formdata = new FormData();
      formdata.append('id_usuario', id_usuario);
      
      fetch('/usuarios/eliminar', { method: 'POST', body: formdata })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          swalWithBootstrapButtons.fire({
            title: "¡Eliminado!",
            text: "El usuario ha sido eliminado.",
            icon: "success",
          }).then(() => window.location.href = '/usuarios')
        }
      })
    }
    
  })
}

document.addEventListener("DOMContentLoaded", function() {
  pathname = window.location.pathname
  if (pathname === '/usuarios') {
    document.getElementById("dt-search-0").focus()
  } else if (pathname === '/usuarios/agregar' || pathname.startsWith('/usuarios/editar/')) {
    const form_usuario = document.getElementById('form_usuario');
    form_usuario.addEventListener('submit', (event) => nuevo_usuario(event))
  } 
})



function nuevo_usuario(event) {
  event.preventDefault()
  const datos = new FormData(form_usuario)
  let id_usuario = datos.get('id_usuario')
  const url = id_usuario ? `/usuarios/editar/${id_usuario}`: '/usuarios/agregar'

  // Limpiar mensajes de error anteriores
  document.querySelectorAll('.text-danger').forEach(el => el.textContent = '')
  
  fetch(url, { method: 'POST', body: datos })
  .then( response => response.json())
  .then(data => {
    if (data.success) {
      // Mostrar SweetAlert2 con el mensaje de éxito
      Swal.fire({
        title: 'Éxito',
        text: data.success,
        icon: 'success',
        confirmButtonText: 'Aceptar'
      }).then(() => {
        // Redireccionamos a la lista de usuarios
        window.location.href = '/usuarios'
      })
    } else if (data.errores) {
      // Mostrar errores debajo de los campos correspondientes
      for (const campo in data.errores) {
        if (data.errores.hasOwnProperty(campo)) {
          const errorDiv = document.getElementById(`error-${campo}`);
          if (errorDiv) {
            data.errores[campo].forEach(error => {
              const p = document.createElement('p');
              p.textContent = `* ${error}`;
              errorDiv.appendChild(p);
            });
          }
        }
      }
    }
  })
}
