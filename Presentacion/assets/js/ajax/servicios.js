
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-danger me-2",
    cancelButton: "btn"
  },
  buttonsStyling: false
})


Dropzone.autoDiscover = false;

var dropzone = new Dropzone("#dropzone", {
  url: '/servicios/upload',
  method: 'post',
  maxFilesize: 2, // tamaño máximo de archivo en MB
  acceptedFiles: 'image/*', // solo permitir imágenes
  autoProcessQueue: false, // Evita el envío automático del formulario
  maxFiles: 1,
  addRemoveLinks: true
})

dropzone.on('maxfilesexceeded', function (file) {
  dropzone.removeFile(file)
})

dropzone.on('success', function(file, response) {
  const result = JSON.parse(response)
  if (result.status === 'success') {
    swalWithBootstrapButtons.fire({
      title: 'Éxito',
      text: 'El producto ha sido creado exitosamente',
      icon: 'success',
    }).then(() => window.location.href = '/servicios')
  }
})

function init() {
  document.getElementById('form_servicio').addEventListener('submit', function (e) {
    e.preventDefault()
    e.stopPropagation()
    submitForm()
  })
}


function submitForm() {
  const form = document.getElementById('form_servicio')
  const formData = new FormData(form)
  const id_servicio = formData.get('id_servicio')
  const url = id_servicio ? `/servicios/editar/${id_servicio}`: '/servicios/agregar'
  document.querySelectorAll('.text-danger').forEach(el => el.textContent = '')
  
  fetch(url, { method: 'POST', body: formData })
  .then(response => response.json())
  .then(data => {
    switch (data.status) {
      case 'success':
        const _id = id_servicio ?? data.id.id
        dropzone.on('sending', function (file, xhr, formData) {
          formData.append('id', _id)
        })
          
        if (dropzone.getQueuedFiles().length > 0) {
          dropzone.processQueue()
        } else {
          if (data.status === 'success') {
            swalWithBootstrapButtons.fire({
              title: 'Éxito',
              text: 'El servicio ha sido creado exitosamente',
              icon: 'success',
            }).then(() => window.location.href = '/servicios')
          }
        }
        break;
      case 'errores':
        // Mostrar errores debajo de los campos correspondientes
        for (const campo in data.message) {
          if (data.message.hasOwnProperty(campo)) {
            const errorDiv = document.getElementById(`error-${campo}`);
            if (errorDiv) {
              data.message[campo].forEach(error => {
                const p = document.createElement('p');
                p.textContent = `* ${error}`;
                errorDiv.appendChild(p);
              });
            }
          }
        }
        break;
    
      default:
        break;
    }

  })
  .catch(error => {
    console.error('Error:', error); // Manejar errores
  })
}


function eliminar_servicio(id_servicio) {
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
      formdata.append('id_servicio', id_servicio);
      
      fetch('/servicios/eliminar', { method: 'POST', body: formdata })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          swalWithBootstrapButtons.fire({
            title: "¡Eliminado!",
            text: "El servicio ha sido eliminado.",
            icon: "success",
          }).then(() => window.location.href = '/servicios')
        }
      })
    }
    
  })
}


init()