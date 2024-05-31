
document.addEventListener("DOMContentLoaded", function() {
  const form_login = document.getElementById('form_login');
  form_login.addEventListener('submit', (event) => autenticar(event))
})


function autenticar(event) {
  event.preventDefault()

  const datos = new FormData(form_login)
  
  fetch('/login', { method: 'post', body: datos })
  .then(response => response.json())
  .then(data => {
    console.log(data)
    if (data.errores) {
      const toastLiveExample = document.getElementById('liveToast')
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
      toastBootstrap.show()
    } else if (data.success) {
      // Redireccionamos a la pagina de inicio
      window.location.href = '/'
    }
  })
}