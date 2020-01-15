<!-- MODAL ADD -->
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	              <div class="modal-dialog" role="document">
		                <div class="modal-content">
			                  <div class="modal-body">
				<div class="card">
					<div class="card-body">
						<h5 class="text-center title"></h5>
						   <form class="forms-sample" id="form_upload" enctype="multipart/form-data">
							<input type="hidden" value="" name="id_upload" id="id_upload"/>
							<center>
								<img id="blah" src="#" alt="" width="250" class="img-responsive" />
							</center>
							<br/>
							<div class="form-group">
								<label>Logo</label>
								<input type="file" class="form-control"value="" id="img" name="logo" placeholder="Logo">
							</div>
							<button  type="submit" id="btnSave" class="btn btn-primary btn-block">
								<i class="mdi mdi-content-save"></i>Simpan
							</button>
							<button type="button" class="btn btn-default btn-block" data-dismiss="modal">
								<i class="mdi mdi-close"></i>Keluar
							</button>
						</form>
					</div>
				</div>
			         </div>
		                </div>
	              </div>
            </div>
        <!--END MODAL ADD-->
<script type="text/javascript">
	$(document).ready(function(){

		$('#form_upload').submit(function(e){
			e.preventDefault(); 
			$.ajax({
				url:'<?php echo base_url();?>index.php/konfig/do_upload',
				type:"post",
				data:new FormData(this),
				processData:false,
				contentType:false,
				cache:false,
				async:false,
				success: function(data){
					swal("Success !", "Gambar Berhasil Diupload!", "success");
					$('#modal_upload').modal('hide');
					reload_table();
				}
			});
		});


	});

</script>
