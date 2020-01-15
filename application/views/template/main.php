<!DOCTYPE html>
<html lang="en">
<?php 

$this->simple_login->cek_login();

$this->load->model('m_konfigurasi');
$this->load->model('m_menu_bar');
$konfig = $this->m_konfigurasi->get_konfig();
$menu = $this->m_menu_bar->get_menu($this->session->userdata("id_level"));
$submenu = $this->m_menu_bar->get_submenu($this->session->userdata("id_level"));
$data = array(
	'konfig' => $konfig,
);
$data_menu = array(
	'menu' => $menu,
	'submenu' => $submenu
);
?>
<head>
	<?php $this->load->view("template/head",$data);?>
	<style type="text/css">
		#scroll-icon {
			color: $color-leuchterred;
			display: none;
			position: fixed; right: 3.5rem; bottom: 3rem; 
			font-size: 3rem;
		}
		#loading_layer{
			position:absolute;
			width:100%;
			height:100%;
			z-index:999999;
			background-color: #fff;
			text-align: center;
			margin: auto;
		}
		#preloader {
			margin-left: auto;
			margin-right: auto;
			margin-top: 300px;
			display: block;
		}
	</style>
</head>

<body onload="hideLoadingLayer();">
	<div id="loading_layer">
		<img src="<?=base_url('images/preloader.gif')?>" width="100" height="100" id="preloader"/>
	</div>
	<div class="container-scroller">
		<?php $this->load->view("template/header", $data);?>
		<div class="container-fluid page-body-wrapper">
			<?php $this->load->view("template/sidebar",$data_menu);?>
			<div class="main-panel">
				<div class="content-wrapper">
					<?php $this->load->view("template/konten");?>
				</div>
				<?php $this->load->view("template/konten_footer",$data);?>
			</div>
		</div>
	</div>
	<?php $this->load->view("template/footer");?>
	<div id="scroll-icon">
		<i class="fa fa-long-arrow-down" aria-hidden="true"></i>
	</div>
	<script type="text/javascript">
		function hideLoadingLayer(){
			document.getElementById("loading_layer").style.visibility="hidden";
		}
	</script>
</body>
</html>