
const form_login = document.getElementById('form_login');
form_login.addEventListener('submit', (event) => autenticar(event), false)
// document.addEventListener("DOMContentLoaded", function() {
// })


function autenticar(event) {
  event.preventDefault()
  const datos = new FormData(form_login)
  
  fetch('/login', { method: 'post', body: datos })
  .then(response => response.json())
  .then(data => {
    switch (data.status) {
      case 'success':
        window.location.href = '/'
        break;

      case 'error':
        // Limpiar validaciones previas
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'))
        let firstInvalidInput = null  // Para guardar el primer campo con error

        for (const campo in data.message) {
          if (data.message.hasOwnProperty(campo)) {
            const input = form_login.querySelector(`[name="${campo}"]`)
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

        break
      case 'notification':
        toastr.options = {
          "closeButton": true,
          "positionClass": "toast-bottom-center"
        };
        toastr['error'](data.message);
        break
    
      default:
        break
    }
  })
}