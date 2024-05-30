<?php
  $directoryURI = $_SERVER['REQUEST_URI'];
  $path = parse_url($directoryURI, PHP_URL_PATH);
  $components = explode('/', $path);
  $index = count($components);
  $page = $components[$index-1];

  $menuItems = [
    [
      'titulo' => 'Acceso y seguridad',
      'icono' => 'security',
      'submenu' => [
        [
          'titulo' => 'Usuarios',
          'link' => '/usuarios',
          'active' => $page === 'administrarUsuarios.php'
        ],
        [
          'titulo' => 'Roles',
          'link' => '/roles',
          'active' => $page === 'administrarRoles.php'
        ],
        [
          'titulo' => 'Asignar usuario-rol',
          'link' => 'asignar',
          'active' => $page === 'asignarRol.php'
        ]
      ]
    ],
    [
      'titulo' => 'Parametrización',
      'icono' => 'settings',
      'submenu' => [
        [
          'titulo' => 'Servicios',
          'link' => PAGES_URL.'/asignar/administrar_asignar.php',
          'active' => $page === 'asignarRol.php'
        ],
        [
          'titulo' => 'Catalogo de servicios',
          'link' => PAGES_URL.'/asignar/administrar_asignar.php',
          'active' => $page === 'asignarRol.php'
        ],
        [
          'titulo' => 'Productos',
          'link' => PAGES_URL.'/asignar/administrar_asignar.php',
          'active' => $page === 'asignarRol.php'
        ],
        [
          'titulo' => 'Clientes',
          'link' => PAGES_URL.'/asignar/administrar_asignar.php',
          'active' => $page === 'asignarRol.php'
        ]
      ]
    ]
  ];

?>

<div class="app-menu">
  <!-- LOGO -->
  <div class="navbar-brand-box">
    <a href="/" class="logo fw-bold fs-5">
      <span class="ps-2">JP Barber Shop</span>
    </a>
  </div>

  <!-- MENU -->
  <div id="scrollbar">
    <div class="container-fluid p-0">
      <ul id="side-menu" class="sidebar-nav list-unstyled">
        <li class="menu-title">
          <span class="px-4">Menu</span>
        </li>

        <?php foreach ($menuItems as $menuItem): ?>
          <?php if (isset($menuItem['submenu'])): ?>
              <li class="sidebar-nav-item">
                <a class="sidebar-link" data-bs-toggle="collapse" href="#<?= str_replace(' ', '', $menuItem['titulo']) ?>" role="button" aria-expanded="false" aria-controls="<?= str_replace(' ', '', $menuItem['titulo']) ?>">
                  <span class="msr"><?= $menuItem['icono'] ?></span>
                  <span><?= $menuItem['titulo'] ?></span>
                </a>

                  <ul id="<?= str_replace(' ', '', $menuItem['titulo']) ?>" class="collapse sidebar-submenu list-unstyled">
                      <?php foreach ($menuItem['submenu'] as $submenuItem): ?>
                          <li class="sidebar-item">
                              <a href="<?= $submenuItem['link'] ?>" class="<?= $submenuItem['active'] ? 'active' : '' ?> sidebar-link me-3">
                                  <span><?= $submenuItem['titulo'] ?></span>
                              </a>
                          </li>
                      <?php endforeach; ?>
                  </ul>
              </li>
          <?php else: ?>
              <li class="sidebar-nav-item">
                  <a href="<?= $menuItem['link'] ?>" class="<?= $menuItem['active'] ? 'active' : '' ?> sidebar-link">
                      <span class="msr"><?= $menuItem['icono'] ?></span>
                      <span><?= $menuItem['titulo'] ?></span>
                  </a>
              </li>
          <?php endif; ?>
      <?php endforeach; ?>
  
        <!-- <li class="sidebar-nav-item">
          <a class="sidebar-link" data-bs-toggle="collapse" href="#menuAcceso" role="button" aria-expanded="false" aria-controls="menuAcceso">
            <span class="msr">security</span>
            <span>Acceso y seguridad</span>
          </a>
  
          <ul id="menuAcceso" class="collapse sidebar-submenu list-unstyled">
            <li class="sidebar-item">
              <a href="<?= PAGES_URL ?>/usuarios/administrar_usuarios.php"
                class="<?= $page === 'administrarUsuarios.php' ? 'active' : '' ?> sidebar-link me-3">
                <span>Usuarios</span>
              </a>
            </li>
            <li class="sidebar-nav-item">
              <a href="<?= PAGES_URL ?>/roles/administrar_roles.php"
                class="<?= $page === 'administrarRoles.php' ? 'active' : '' ?> sidebar-link me-3">
                <span>Roles</span>
              </a>
            </li>
  
            <li class="sidebar-nav-item">
              <a href="<?= PAGES_URL ?>/asignar/administrar_asignar.php"
                class="<?= $page === 'asignarRol.php' ? 'active' : '' ?> sidebar-link me-3">
                <span>Asignar uaurio-rol</span>
              </a>
            </li>
          </ul>
        </li> -->
  
      </ul>
    </div>
    <div id="sidebar-menu">
    </div>
  </div>
</div>