<?php
  $url = $_SERVER['REQUEST_URI'];
  $items = explode('/', trim($url, '/'));
?>
<div class="container-fluid">        
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3 class=""><?= ($pagetitle) ? $pagetitle : '' ?></h3>
      </div>
      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/">
              <span class="msr">home</span>
            </a>
          </li>

          <?php
            $path = '';
            for ($i = 0; $i < count($items); $i++):
              $path .= '/' . $items[$i];
            ?>
              <?php if ($i == count($items) - 1): ?>
                <li class="breadcrumb-item active"><?= ucfirst($items[$i]) ?></li>
              <?php else: ?>
                <li class="breadcrumb-item">
                  <a href="<?= $path ?>"><?= ucfirst($items[$i]) ?></a>
                </li>
              <?php endif; ?>
            <?php endfor;
          ?>
        </ol>
      </div>
    </div>
  </div>
</div>

