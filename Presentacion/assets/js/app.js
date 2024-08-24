//const getStoredTheme = () => localStorage.getItem('theme')
const setStoredTheme = theme => localStorage.setItem('theme', theme)


let btnThemeMode = document.getElementById('mode-setting-btn')


const getPreferredTheme = () => {
  const storedTheme = getStoredTheme()
  if (storedTheme) {
    return storedTheme
  }

  return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
}


const setTheme = theme => {
  if (theme === 'auto') {
    document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'))
  } else {
    setStoredTheme(theme)
    document.documentElement.setAttribute('data-bs-theme', theme)
  }
}

setTheme(getPreferredTheme())

btnThemeMode.addEventListener('click', () => {
  let html = document.getElementsByTagName('html')[0]
  if (html.hasAttribute('data-bs-theme')) {
    let mode = html.getAttribute('data-bs-theme')
    if (mode === 'dark') {
      setTheme('light')
    } else {
      setTheme('dark')
    }
  }
})



document.addEventListener("DOMContentLoaded", function() {
  const currentPath = window.location.pathname;

  // Función para activar el ítem del menú
  function activateMenuItem(menuItem) {
    menuItem.classList.add("active");

    // Si el ítem está dentro de un colapso, expandir el colapso padre
    const parentCollapse = menuItem.closest("ul.collapse");
    if (parentCollapse) {
      parentCollapse.classList.add("show");
    }
  }

  // Obtener todos los enlaces del menú
  const menuLinks = document.querySelectorAll("#side-menu a.sidebar-link");
  
  // Variable para almacenar el enlace que coincide con la URL actual
  let matchedLink = null
  
  // Iterar sobre cada enlace
  menuLinks.forEach(link => {
    const linkPath = new URL(link.href).pathname;
    if (!link.href.includes('#') && (currentPath === linkPath || currentPath.startsWith(linkPath + "/"))) {
      matchedLink = link
    }
  })
  
  // Si se encontró un enlace que coincide, activarlo
  if (matchedLink) {
    activateMenuItem(matchedLink);
  }

});

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


function mostrarToast() {
  const toastMessage = sessionStorage.getItem('toastMessage')
  if (toastMessage) {
    toastr.options = {
      "closeButton": true,
      "positionClass": "toast-bottom-right"
    }
    toastr['success'](toastMessage)
    // Limpiar el mensaje después de mostrarlo
    sessionStorage.removeItem('toastMessage')
  }
}

mostrarToast()