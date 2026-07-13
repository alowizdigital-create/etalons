<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #235467;">
  <!-- Brand Logo -->
  <a href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'edit']) ?>" class="brand-link" style="border-bottom: 1px solid #3c7d9e;">
    <!-- Utiliser un placeholder si l'image 'xtech.jpg' n'est pas AdvanceApp, sinon laisser l'image -->
    <?php
    /* Si l'image 'xtech.jpg' n'est pas le logo AdvanceApp, vous pouvez utiliser un placeholder SVG/CSS ici */
    echo $this->Html->image('avatar.png', [
        'class' => 'brand-image img-circle elevation-3',
        'alt' => 'AdvanceApp Logo'
    ]);
    ?>
    <span class="brand-text font-weight-light ml-2" style="font-size: 20px; color: #0d837c; font-weight: bold !important;">SEtal</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
   <nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <!-- Étalonnages -->
    <li class="nav-item">
      <a href="<?= $this->Url->build(['controller' => 'CalibrationRecords', 'action' => 'index']) ?>" class="nav-link">
        <i class="nav-icon fas fa-ruler-combined"></i>
        <p><?= __('Étalonnages') ?></p>
      </a>
    </li>
    
     <!-- Étalonnages -->
    <li class="nav-item">
      <a href="<?= $this->Url->build(['controller' => 'CalibrationRecords', 'action' => 'state']) ?>" class="nav-link">
        <i class="nav-icon fas fa-ruler-combined"></i>
        <p><?= __('Etats') ?></p>
      </a>
    </li>

    <!-- Appareils -->
    <li class="nav-item">
      <a href="<?= $this->Url->build(['controller' => 'Devices', 'action' => 'index']) ?>" class="nav-link">
        <i class="nav-icon fas fa-microchip"></i>
        <p><?= __('Appareils') ?></p>
      </a>
    </li>

    <!-- Agents -->
    <li class="nav-item">
      <a href="<?= $this->Url->build(['controller' => 'Agents', 'action' => 'index']) ?>" class="nav-link">
        <i class="nav-icon fas fa-user-tie"></i>
        <p><?= __('Agents') ?></p>
      </a>
    </li>

    <!-- Les relances -->
    <li class="nav-item">
      <a href="<?= $this->Url->build(['controller' => 'Messages', 'action' => 'index']) ?>" class="nav-link">
        <i class="nav-icon fas fa-envelope-open-text"></i>
        <p><?= __('Les relances') ?></p>
      </a>
    </li>

    <!-- Entreprises -->
    <li class="nav-item">
      <a href="<?= $this->Url->build(['controller' => 'Companies', 'action' => 'index']) ?>" class="nav-link">
        <i class="nav-icon fas fa-building"></i>
        <p><?= __('Entreprises') ?></p>
      </a>
    </li>
    <!-- Déconnexion -->
    <li class="nav-item">
      <a href="" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p><?= __('Déconnexion') ?></p>
      </a>
    </li>

  </ul>
</nav>

    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
