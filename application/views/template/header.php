<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
	<div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
		<a class="navbar-brand brand-logo" href="<?= base_url()?>assets/admin/index.html">
			<img src="<?= base_url('images/'.$konfig->logo)?>" alt="logo" style="width: 210px; height: 60px"/>
		</a>
		<a class="navbar-brand brand-logo-mini" href="<?= base_url()?>assets/admin/index.html">
			<img src="<?= base_url('images/'.$konfig->logo)?>" alt="logo" style="width: 70px; height: 30px"/>
		</a>
	</div>
	<div class="navbar-menu-wrapper d-flex align-items-center">
			<ul class="navbar-nav navbar-nav-right">
				<li class="nav-item dropdown d-none d-xl-inline-block">
					<a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
						<span class="profile-text">Hello, <?=$this->session->userdata("f_name").' '.$this->session->userdata("l_name");?></span>
						<img class="img-xs rounded-circle" src="<?= base_url('images/user/'.$this->session->userdata("foto"))?>" alt="Profile image">
					</a>
					<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
					<?php if ($this->session->userdata("level") == 'administrator') { ?>
						<a class="dropdown-item mt-2" href="<?= site_url('user')?>">
							<i class="mdi mdi-settings"></i> Kelola User
						</a>
						<?php } ?>
						<a class="dropdown-item" href="<?= site_url('profil/ganti_password')?>">
							<i class="mdi mdi-lock"></i> Ganti Password
						</a>
						<a class="dropdown-item"  href="<?= site_url('profil/ganti_foto')?>">
							<i class="mdi mdi-image"></i> Ganti Foto Profil
						</a>
						<a class="dropdown-item" href="<?= site_url('login/logout/'.$this->session->userdata("id"))?>">
							<i class="mdi mdi-logout"></i> Keluar
						</a>
					</div>
				</li>
			</ul>
			<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
				<span class="mdi mdi-menu"></span>
			</button>
		</div>
	</nav>