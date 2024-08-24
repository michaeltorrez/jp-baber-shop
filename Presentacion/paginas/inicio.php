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
    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          <h3 class="pt-4">🎉 Bienvenido <?= $_SESSION['nombre_completo'] ?></h3>
          <div id="simple-bar">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam iure optio cupiditate voluptate culpa non, earum adipisci rerum porro, molestiae nam distinctio delectus rem reiciendis consectetur consequatur recusandae ad modi?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo nihil aspernatur magnam consequuntur sint quibusdam eum tempore fugit voluptatem? Inventore fugit voluptatum iusto laudantium sed expedita optio et, rem aut!
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime amet tempora exercitationem, nostrum suscipit aspernatur culpa officiis ea quam nemo, sunt accusamus sed a fugiat quisquam qui unde minima corporis.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi officiis distinctio delectus alias aliquam deleniti ea laudantium et recusandae! Quam magnam ea velit dolores cupiditate quaerat autem rerum provident vitae?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae, velit beatae officia maxime voluptate eos natus voluptatem voluptates, blanditiis vel sed a. Odit possimus odio illo architecto dolorem commodi necessitatibus?
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Velit, id, distinctio inventore deleniti magnam tempore similique cupiditate illo nobis eos reprehenderit rerum facilis exercitationem quas? Repellendus at iure fuga rem!
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis, aperiam omnis aut ducimus dolore quae fugiat tenetur placeat velit esse, praesentium facilis labore natus! Itaque quo est nemo debitis obcaecati.
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestias suscipit adipisci nobis, magnam minus quia magni ipsum, placeat odio necessitatibus laborum quisquam unde ut assumenda inventore veritatis, doloribus modi tempore.
          </div>
        </div>
      </div>
    </div>

<?php include LAYOUT_PATH.'/footer.php' ?>