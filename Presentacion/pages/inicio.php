<?php
  include 'assets/utiles/config.php';
  require_once '../Negocio/acceso.php';
  require_once '../Negocio/funciones.php';
  include LAYOUT_PATH.'/main.php';
?>

<head>
  <?php
    include_archivo_con_variables(LAYOUT_PATH.'/meta.php', array('title' => 'Inicio'));
    include LAYOUT_PATH.'/css.php';
  ?>
</head>

<body>
    <?php
      include 'componentes/topbar.php';
      include  'componentes/sidebar.php';
    ?>
    djhfsdjhfshjd

<?php include LAYOUT_PATH.'/footer.php' ?>