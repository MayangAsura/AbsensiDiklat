 <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="<?= base_url('images/user/'.$this->session->userdata("foto"))?>" width="130" height="40" alt="profile image">
          </div>
          <div class="text-wrapper">
            <p class="profile-name"><?=$this->session->userdata("f_name").' '.$this->session->userdata("l_name");?></p>
            <div>
              <small class="designation text-muted"><?=$this->session->userdata("level");?></small>
              <span class="status-indicator online"></span><br/><br/>
            </div>
          </div>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?= site_url('dashboard')?>">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <?php foreach($menu as $menu) { ?>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#<?= $menu->id_menu?>" aria-expanded="false" aria-controls="<?= $menu->id_menu?>">
        <i class="menu-icon <?= $menu->icon_menu?>"></i>
        <span class="menu-title"><?= $menu->menu?></span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="<?= $menu->id_menu?>">
        <ul class="nav flex-column sub-menu">
          <?php foreach($submenu as $sub) { 
            if($menu->id_menu == $sub->id_parents) {
              ?>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url().$sub->link?>"> <i class="menu-icon <?=$sub->icon_menu?>"></i> <?=$sub->menu?> </a>
              </li>
              <?php } } ?>
            </ul>
          </div>
        </li>
        <?php  } ?>

        <?php if ($this->session->userdata("level") == 'administrator') { ?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="menu-icon mdi mdi-account"></i>
            <span class="menu-title">Manajemen User</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="auth">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('user')?>"> <i class="menu-icon mdi mdi-account"></i> Kelola User </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('level')?>"> <i class="menu-icon mdi mdi-account-switch"></i> Kelola Level User </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#konfigurasi" aria-expanded="false" aria-controls="konfigurasi">
            <i class="menu-icon mdi mdi-settings"></i>
            <span class="menu-title">Konfigurasi</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="konfigurasi">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('menu')?>"> <i class="menu-icon mdi mdi-account"></i> Kelola Menu </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('konfig')?>"> <i class="menu-icon mdi mdi-settings"></i> Konfigurasi </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= site_url('icon')?>"> <i class="menu-icon mdi mdi-settings"></i> Kelola Icon </a>
              </li>
            </ul>
          </div>
        </li>
        <?php } ?>
      </ul>
    </nav>
