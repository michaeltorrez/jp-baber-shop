const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-primary",
    cancelButton: "btn btn-danger"
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
      var formdata = new FormData();
      formdata.append('id', id);
      fetch('eliminar_rol.php', {
        method: 'POST',
        body: formdata,
      })
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
  document.getElementById("dt-search-0").focus()
})