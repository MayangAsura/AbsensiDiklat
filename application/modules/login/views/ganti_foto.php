<div class="row">
	<div class="col-lg-6 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h3><?= $profil->f_name.' '.$profil->l_name;?></h3>
				<hr/>
				<center>
					<img class="img-sm rounded-circle" src="<?= base_url('images/user/'.$profil->foto)?>" alt="profile image" style="width: 130px; height: 130px">
				</center>
				<br/>
				<center>
					<h3><?= $profil->f_name.' '.$profil->l_name;?></h3>
					<h5 class="text-primary"><?= $profil->nama_level;?></h5>
					<small><?= $profil->email;?> | <?= $profil->no_hp;?></small>
				</center>
			</div>
		</div>
	</div>
	<div class="col-lg-6 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h3><?= $title?></h3>
				<hr/>
				<center>
					<img class="img-sm rounded-circle" id="blah" src="<?= base_url('images/user/'.$profil->foto)?>" alt="profile image" style="width: 140px; height: 140px">
				</center>
				 <form class="forms-sample" action="#" method="POST" id="form_profil" enctype="multipart/form-data">
					<input type="hidden" value="<?= $this->session->userdata("id");?>" name="id_user" id="id_user"/>
					<div class="form-group">
						<input type="file" class="form-control"value="" id="img" name="profil" placeholder="Logo">
					</div>
					<button  type="submit" id="btnSave" class="btn btn-primary btn-block">
						<i class="mdi mdi-content-save"></i>Simpan
					</button>
				</form> 
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function(){

		$('#form_profil').submit(function(e){
			e.preventDefault(); 
			$.ajax({
				url:'<?php echo base_url();?>index.php/login/ajax_profil',
				type:"post",
				data:new FormData(this),
				processData:false,
				contentType:false,
				cache:false,
				async:false,
				success: function(data){
					window.location.reload(true);
					alert("Foto Profil Berhasil Diupload.");
				}
			});
		});
	});
</script>