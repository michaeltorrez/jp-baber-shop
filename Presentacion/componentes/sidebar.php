<?php
  $directoryURI = $_SERVER['REQUEST_URI'];
  $path = parse_url($directoryURI, PHP_URL_PATH);
  $components = explode('/', $path);
  $index = count($components);
  $page = $components[$index-1];


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
          'titulo' => 'Roles',
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
        ]
      ]
    ]
  ];


  function renderMenu($items, $currentPath) {
    foreach ($items as $item):
      $isActive = '';
      $isSubmenuActive = '';

      
      if (isset($item['submenu'])) {
        foreach ($item['submenu'] as $submenuItem) {
          if (strpos($currentPath, $submenuItem['link']) === 0) {
            $isActive = 'active';
            $isSubmenuActive = 'show';
            break;
          }
        }
      } else {
        if ($currentPath === $item['link']) {
          $isActive = 'active';
        }
      }

      if (isset($item['submenu'])):
        $id_collapse = str_replace(' ', '', $item['titulo']); ?>
        <li class="sidebar-nav-item <?= $isActive ?>">
          <a class="sidebar-link" data-bs-toggle="collapse" href="#<?= $id_collapse ?>" role="button" aria-expanded="false" aria-controls="<?= $id_collapse ?>">
            <?php if (isset($item['icono'])): ?>
              <span class="msr"><?= $item['icono'] ?></span>
            <?php endif ?>
            <span><?= $item['titulo'] ?></span>
          </a>
          <ul id="<?= $id_collapse ?>" class="collapse sidebar-submenu list-unstyled <?= $isSubmenuActive ?>">
            <?php renderMenu($item['submenu'], $currentPath) ?>
          </ul>
        </li>
      <?php else: ?>
        <li class="sidebar-item <?= $isActive ?>">
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



  function renderMenu2($items) {
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
          <ul id="<?= $id_collapse ?>"class="collapse sidebar-submenu list-unstyled">
            <?php renderMenu($item['submenu']) ?>
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
  <div id="scrollbar">
    <div class="container-fluid p-0">
      <ul id="side-menu" class="sidebar-nav list-unstyled">
        <li class="menu-title">
          <span class="px-4">Menu</span>
        </li>

        <?php /*foreach ($menuItems as $menuItem): ?>
          <li class="sidebar-nav-item">
            <?php if (isset($menuItem['submenu'])): ?>
              <a class="sidebar-link"
                data-bs-toggle="collapse"
                href="#<?= str_replace(' ', '', $menuItem['titulo']) ?>"
                role="button" aria-expanded="false"
                aria-controls="<?= str_replace(' ', '', $menuItem['titulo']) ?>"
              >
                <span class="msr"><?= $menuItem['icono'] ?></span>
                <span><?= $menuItem['titulo'] ?></span>
              </a>

              <ul id="<?= str_replace(' ', '', $menuItem['titulo']) ?>" class="collapse sidebar-submenu list-unstyled">
                <?php foreach ($menuItem['submenu'] as $submenuItem): ?>
                  <li class="sidebar-item">
                    <?php if (isset($submenuItem['submenu'])): ?>
                      <a class="sidebar-link"
                        data-bs-toggle="collapse"
                        href="#<?= str_replace(' ', '', $submenuItem['titulo']) ?>"
                        role="button" aria-expanded="false"
                        aria-controls="<?= str_replace(' ', '', $submenuItem['titulo']) ?>"
                      >
                        <span><?= $submenuItem['titulo'] ?></span>
                      </a>

                      <ul id="<?= str_replace(' ', '', $submenuItem['titulo']) ?>" class="collapse sidebar-submenu list-unstyled">
                        <?php foreach ($submenuItem['submenu'] as $submenuItem2): ?>
                          <li class="sidebar-item">
                            <a href="<?= $submenuItem2['link'] ?>" class="sidebar-link me-3">
                              <span class="msr"><?= $submenuItem2['icono'] ?></span>
                              <span><?= $submenuItem2['titulo'] ?></span>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>

                    <?php else: ?>
                      <a href="<?= $submenuItem['link'] ?>" class="sidebar-link me-3">
                        <span><?= $submenuItem['titulo'] ?></span>
                      </a>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <a href="<?= $menuItem['link'] ?>" class="sidebar-link">
                <span class="msr"><?= $menuItem['icono'] ?></span>
                <span><?= $menuItem['titulo'] ?></span>
              </a>
            <?php endif; ?>

          </li>
        <?php endforeach; */?>

        <?php renderMenu($menuItems, $path); ?>
  
      </ul>
    </div>
    <div id="sidebar-menu">
    </div>
  </div>
</div>