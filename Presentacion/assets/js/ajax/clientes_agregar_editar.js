const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: "btn btn-danger me-2",
    cancelButton: "btn"
  },
  buttonsStyling: false
})

const form_cliente = document.getElementById('form_cliente')

form_cliente.addEventListener('submit', e => agregar_clientes(e))

function agregar_clientes(e) {
  e.preventDefault()
  
  const formData = new FormData(form_cliente)
  
  fetch('/clientes/agregar', { method: 'post', body: formData })
  .then(result => result.json())
  .then(data => {
    switch (data.status) {
      case 'success':
        sessionStorage.setItem('toastMessage', data.message);
        window.location.replace('/clientes')
        break;

      case 'errores':
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'))
        let firstInvalidInput = null  // Para guardar el primer campo con error

        for (const campo in data.message) {
          if (data.message.hasOwnProperty(campo)) {
            const input = form_cliente.querySelector(`[name="${campo}"]`)
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