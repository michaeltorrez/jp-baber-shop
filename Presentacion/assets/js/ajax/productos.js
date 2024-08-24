const form_producto = document.getElementById('form_producto')


const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-danger me-2",
    cancelButton: "btn"
  },
  buttonsStyling: false
})


Dropzone.autoDiscover = false;
var dropzone = new Dropzone("#dropzone", {
  url: '/productos/agregar',
  method: 'post',
  maxFilesize: 3, // tamaño máximo de archivo en MB
  acceptedFiles: 'image/*', // solo permitir imágenes
  autoProcessQueue: false, // Evita el envío automático del formulario
  maxFiles: 1,
  addRemoveLinks: true,
})

const existingImagen = document.getElementById('imagen').value

if (existingImagen) {
  const mockFile = { name: existingImagen, size: 123456 }
  dropzone.displayExistingFile(mockFile, '/files/productos/' + existingImagen)
}

form_producto.addEventListener('submit', function (e) {
  e.preventDefault()

  const formData = new FormData(form_producto);
  const id_producto = formData.get('id_producto')
  const url = id_producto ? `/productos/editar/${id_producto}` : '/productos/agregar'
  dropzone.options.url = url


  if (dropzone.getQueuedFiles().length > 0) {
    // Si hay archivos en la cola, súbelos junto con los datos del formulario
    dropzone.on("sending", function(file, xhr, formData) {
      // Agregar los demás datos del formulario a los datos del Dropzone
      const formDataArray = new FormData(form_producto);
      formDataArray.forEach((value, key) => {
        formData.append(key, value);
      })
    })

    dropzone.processQueue();  // Procesar la cola de archivos
  } else {
    // Si no hay archivos en la cola, simplemente enviar el formulario
    submitForm(url)
  }


  // Manejo de la respuesta de Dropzone
  dropzone.on("success", function(file, response) {
    handleResponse(JSON.parse(response))
  });

  dropzone.on("error", function(file, response) {
    handleResponse(response)
  });
})


function submitForm(url) {
  const formData = new FormData(form_producto)
  
  fetch(url, { method: 'POST', body: formData })
  .then(response => response.json())
  .then(data => {
    switch (data.status) {
      case 'success':
        swalWithBootstrapButtons.fire({
          title: 'Éxito',
          text: 'El producto ha sido creado exitosamente',
          icon: 'success',
        }).then(() => window.location.href = '/productos')

        break;
      case 'errores':
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'))
        let firstInvalidInput = null  // Para guardar el primer campo con error

        for (const campo in data.message) {
          if (data.message.hasOwnProperty(campo)) {
            const input = form_producto.querySelector(`[name="${campo}"]`)
            if (input) {
              input.classList.add('is-invalid')
              const feedback = input.nextElementSibling
              if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = data.message[campo].join(', ')
              }
              if (!firstInvalidInput) {
                firstInvalidInput = input  // Guardar el primer campo con error
              }
            }
          }
        }

        // Colocar el foco en el primer campo con error
        if (firstInvalidInput) {
          firstInvalidInput.focus()
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


function eliminar_producto(id_producto) {
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
      formdata.append('id_producto', id_producto);
      
      fetch('/productos/eliminar', { method: 'POST', body: formdata })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          swalWithBootstrapButtons.fire({
            title: "¡Eliminado!",
            text: "El producto ha sido eliminado.",
            icon: "success",
          }).then(() => window.location.href = '/productos')
        }
      })
    }
    
  })
}


function handleResponse(data) {
  switch (data.status) {
    case 'success':
      swalWithBootstrapButtons.fire({
        title: 'Éxito',
        text: 'El producto ha sido creado exitosamente',
        icon: 'success',
      }).then(() => window.location.href = '/productos');
      break;
    case 'errores':
      document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
      let firstInvalidInput = null;  // Para guardar el primer campo con error

      for (const campo in data.message) {
        if (data.message.hasOwnProperty(campo)) {
          const input = form_producto.querySelector(`[name="${campo}"]`);
          if (input) {
            input.classList.add('is-invalid');
            const feedback = input.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
              feedback.textContent = data.message[campo].join(', ');
            }
            if (!firstInvalidInput) {
              firstInvalidInput = input;  // Guardar el primer campo con error
            }
          }
        }
      }

      // Colocar el foco en el primer campo con error
      if (firstInvalidInput) {
        firstInvalidInput.focus();
      }
      break;
    default:
      console.error('Unexpected response:', data);
      break;
  }
}


function editar(id_producto) {
  alert(id_producto)
}