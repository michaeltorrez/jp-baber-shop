const SwalPersonalizado = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-danger me-2",
    cancelButton: "btn"
  },
  buttonsStyling: false
});


function cargar_roles() {
  const select_usuario = document.getElementById('select_usuario')
  const form_asignar = document.getElementById('form_asignar')

  select_usuario.addEventListener('change', () => {
    const id = select_usuario.value
    
    fetch(`/usuario-rol/roles-disponibles/${id}`, { method: 'POST' })
    .then(response => response.json())
    .then(data => {
      const select_roles = document.getElementById('rol')
      select_roles.innerHTML = '<option value="" disabled selected hidden></option>'
      data.success.forEach(rol => {
        let nuevaOpcion = document.createElement("option")
        nuevaOpcion.value = rol.id_rol
        nuevaOpcion.text = rol.descripcion
        select_roles.add(nuevaOpcion)
      });
    })
  })

  form_asignar.addEventListener('submit', event => asignar_rol(event))


}

function asignar_rol(event) {
  event.preventDefault()
  const datos = new FormData(form_asignar)

  fetch('/usuario-rol/asignar', { method: 'POST', body: datos })
  .then(response => response.json())
  .then(data => {
    // preguntamos si data trae la prop success
    if (data.success) {
      // si tiene la prop entonces el proceso fue exitoso y mostramos el mensaje al usuario
      SwalPersonalizado.fire({
        title: 'Éxito',
        text: data.success,
        icon: 'success',
        confirmButtonText: 'Aceptar'
      })
      // una ves mostrado el mensaje, cuando el usuario de en el boton aceptar o cierre el modal
      //lo redirigimos a la lista de usuario-rol
      .then(() => location.href = '/usuario-rol')
    }
  })
}


function eliminar_asignacion(id_usuario, id_rol) {
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
      var formdata = new FormData();
      formdata.append('id_usuario', id_usuario);
      formdata.append('id_rol', id_rol);

      fetch('/usuario-rol/eliminar', { method: 'POST', body: formdata })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          SwalPersonalizado.fire({
            title: "¡Eliminado!",
            text: "La asignación de usuario-rol se ha sido eliminado.",
            icon: "success",
          }).then(() => location.reload())
        }
      })
    }
    
  })
}

document.addEventListener("DOMContentLoaded", function() {
  switch (window.location.pathname) {
    case '/usuario-rol':
      document.getElementById("dt-search-0").focus()
      break;
    
    case '/usuario-rol/asignar':
      cargar_roles()
      break;

    default:
      break;
  }
})