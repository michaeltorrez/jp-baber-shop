const getStoredTheme = () => localStorage.getItem('theme')

const setTheme2 = theme => {
  document.documentElement.setAttribute('data-bs-theme', theme)
}

setTheme2(getStoredTheme())