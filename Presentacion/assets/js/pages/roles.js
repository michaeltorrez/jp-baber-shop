//import { mostrar_errores } from 'app.js'

// Para personalizar el mensaje de sweetAlert2
const SwalPersonalizado = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-primary",
    cancelButton: "btn ms-2"
  },
  buttonsStyling: false
});


function eliminar_rol(id) {
  SwalPersonalizado.fire({
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
          SwalPersonalizado.fire({
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

// funcion para crear nuevo rol
function nuevo_rol(event) {
  event.preventDefault()
  const datos = new FormData(form_rol)

  // llamda fetch a crear_rol.php atravez del index (enrutamiento)
  fetch('/roles/nuevo', { method: 'POST', body: datos })
  .then(response => response.json()) // la respuesta la convertimos a json
  .then(data => {
    // verificamos si en la data de respuestas existe un mensaje de exito
    if (data.success) {
      // Mostrar SweetAlert2 con el mensaje de éxito
      SwalPersonalizado.fire({
        title: 'Éxito',
        text: data.success,
        icon: 'success',
        confirmButtonText: 'Aceptar'
      }).then(() => location.href = '/roles') // redirigimos a lista de roles
    
    // verificamos si en la data de respuestas existen errores
    } else if (data.errores) {
      mostrar_errores(data.errores)
    }
  })
}

function mostrar_errores(errores) {
  for (const campo in errores) {
    if (errores.hasOwnProperty(campo)) {
      const errorDiv = document.getElementById(`error-${campo}`);
      if (errorDiv) {
        errores[campo].forEach(error => {
          const p = document.createElement('p');
          p.textContent = `* ${error}`;
          errorDiv.appendChild(p);
        });
      }
    }
  }
}