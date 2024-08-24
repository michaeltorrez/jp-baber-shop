<?php
  $directoryURI = $_SERVER['REQUEST_URI'];
  // $path = parse_url($directoryURI, PHP_URL_PATH);
  // $components = explode('/', $path);
  // $index = count($components);
  // $page = $components[1];

  $menuItems = [
    [
      'titulo' => 'Inicio',
      'icono' => 'home',
      'link' => '/'
    ],
    [
      'titulo' => 'Acceso y seguridad',
      'icono' => 'security',
      'submenu' => [
        [
          'titulo' => 'Administrar usuarios',
          'link' => '/usuarios'
        ],
        [
          'titulo' => 'Administrar roles',
          'link' => '/roles'
        ],
        [
          'titulo' => 'Usuario-rol',
          'link' => '/usuario-rol'
        ]
      ]
    ],
    [
      'titulo' => 'Parametrización',
      'icono' => 'settings',
      'submenu' => [
        [
          'titulo' => 'Servicios',
          'link' => '/servicios'
        ],
        [
          'titulo' => 'Productos',
          'link' => '/productos'
        ],
        [
          'titulo' => 'Catalogo',
          'link' => '/catalogo'
        ],
        [
          'titulo' => 'Clientes',
          'link' => '/clientes'
        ],
        [
          'titulo' => 'Promosiones',
          'link' => '/promociones'
        ]
      ]
    ],
    [
      'titulo' => 'Transaccionales',
      'icono' => 'sync_alt',
      'submenu' => [
        [
          'titulo' => 'Ventas',
          'link' => '/ventas'
        ],
        [
          'titulo' => 'Compra',
          'link' => '/compra'
        ]
      ]
    ]
  ];


  function renderMenu($items, $currentPath) {
    // recorremos los items del menu
    foreach ($items as $item):
      if (isset($item['submenu'])):
        $id_collapse = str_replace(' ', '', $item['titulo']); ?>
        <li class="sidebar-nav-item">
          <a class="sidebar-link" data-bs-toggle="collapse" href="#<?= $id_collapse ?>" role="button" aria-expanded="false" aria-controls="<?= $id_collapse ?>">
            <?php if (isset($item['icono'])): ?>
              <span class="msr"><?= $item['icono'] ?></span>
            <?php endif ?>
            <span><?= $item['titulo'] ?></span>
          </a>
          <ul id="<?= $id_collapse ?>" class="collapse sidebar-submenu list-unstyled">
            <?php renderMenu($item['submenu'], $currentPath) ?>
          </ul>
        </li>
      <?php else: ?>
        <li class="sidebar-item">
          <a href="<?= $item['link'] ?>" class="sidebar-link me-3">
            <?php if (isset($item['icono'])): ?>
              <span class="msr"><?= $item['icono'] ?></span>
            <?php endif ?>
            <span><?= $item['titulo'] ?></span>
          </a>
        </li>
      <?php endif;
    endforeach;
  }
?>

<div class="app-menu">
  <!-- LOGO -->
  <div class="navbar-brand-box">
    <a href="/" class="logo fw-bold fs-5">
      <span class="ps-2">JP Barber Shop</span>
    </a>
  </div>

  <!-- MENU -->
  <div id="scrollbar" class="h-100">
    <div class="container-fluid p-0">
      <ul id="side-menu" class="sidebar-nav list-unstyled">
        <li class="menu-title">
          <span class="px-4">Menu</span>
        </li>
        <?php renderMenu($menuItems, $directoryURI); ?>
  
      </ul>
    </div>
    <div id="sidebar-menu">
    </div>
  </div>
</div>