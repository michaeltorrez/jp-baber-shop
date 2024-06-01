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

document.addEventListener("DOMContentLoaded", initActiveMenu)

function initActiveMenu() {
  var currentPath = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
  currentPath = currentPath.substring(currentPath.lastIndexOf("/") + 1);
  if (currentPath) {
    // navbar-nav
    var a = document.getElementById("side-menu").querySelector('[href*="' + currentPath + '"]');
    if (a) {
      a.classList.add("active");
      var parentCollapseDiv = a.closest(".collapse.sidebar-submenu");
      if (parentCollapseDiv) {
        parentCollapseDiv.classList.add("show");
        //parentCollapseDiv.parentElement.children[0].classList.add("active");
        parentCollapseDiv.parentElement.children[0].setAttribute("aria-expanded", "true");
        if (parentCollapseDiv.parentElement.closest(".collapse.menu-dropdown")) {
          parentCollapseDiv.parentElement.closest(".collapse").classList.add("show");
          if (parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling)
            parentCollapseDiv.parentElement.closest(".collapse").previousElementSibling.classList.add("active");

          if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse.menu-dropdown")) {
            parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").classList.add("show");
            if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling) {

              parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active");
              if ((document.documentElement.getAttribute("data-layout") == "horizontal") && parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(".collapse")) {
                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest(".collapse").previousElementSibling.classList.add("active")
              }
            }
          }
        }
      }
    }
  }
}


export function mostrar_errores(errores) {
  console.log('mostrar', errores)
  // for (const campo in errores) {
  //   if (errores.hasOwnProperty(campo)) {
  //     const errorDiv = document.getElementById(`error-${campo}`);
  //     if (errorDiv) {
  //       errores[campo].forEach(error => {
  //         const p = document.createElement('p');
  //         p.textContent = `* ${error}`;
  //         errorDiv.appendChild(p);
  //       });
  //     }
  //   }
  // }
}