<header id="page-topbar">
  <!-- my-0 mx-auto -->
  <div class="navbar-header d-flex justify-content-between align-items-center">
    <div>
      <span class="msr">menu</span>
    </div>

    <div class="d-flex">
      <!-- Modo claro/oscuro -->
      <div class="dropdown d-none d-sm-inline-block">
        <button type="button" class="btn header-item" id="mode-setting-btn">
          <span class="msr icon-lg layout-mode-light">light_mode</span>
          <span class="msr icon-lg layout-mode-dark">dark_mode</span>
        </button>
      </div>

      <!-- Avatar -->
      <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="d-flex align-items-center">
            <img
              src="<?= $usuario['avatar'] ?? ASSETS_URL.'/images/avatar.png' ?>"
              class="rounded-circle shadow header-profile-use"
              alt="" width="32" height="32"
            />
            <span class="text-start ms-xl-2">
              <span class="d-none d-xl-inline-block fw-medium">
                <?= $_SESSION['nombre_completo'] ?>
              </span>
              <span class="d-none d-xl-block text-muted">
                <?= $_SESSION['rol'] ?>
              </span>
            </span>
            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
          </span>
        </button>

        <div class="dropdown-menu dropdown-menu-end shadow">
          <!-- item-->
          <a class="dropdown-item" href="apps-contacts-profile.html">
            <span class="msr fs-5 align-middle me-1">account_circle</span>
            <span class="align-middle">Perfil</span>
          </a>

          <div class="dropdown-divider"></div>
          
          <a class="dropdown-item" href="/logout">
            <span class="msr fs-5 align-middle me-1">logout</span>
            <span class="align-middle">Cerrar sesión</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</header>