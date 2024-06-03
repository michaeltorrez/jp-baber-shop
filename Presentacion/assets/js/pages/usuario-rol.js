const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-primary",
    cancelButton: "btn btn-danger"
  },
  buttonsStyling: false
});


function cargar_roles() {
  const select_usuario = document.getElementById('select_usuario')

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
}


function eliminar_asignacion(id_usuario, id_rol) {
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
      formdata.append('id', id_usuario);
      fetch('eliminar_asignacion.php', {
        method: 'POST',
        body: formdata,
      })
      .then(response => response.json())
      .then(data => {
        console.log(data)
        if (data.success) {
          swalWithBootstrapButtons.fire({
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