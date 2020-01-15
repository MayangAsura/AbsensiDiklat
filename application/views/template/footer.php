  <!-- container-scroller -->
  <!-- plugins:js -->
<!--   <script type="text/javascript" src="<?= base_url()?>assets/admin/vendors/datatables/js/jquery.dataTables.js"></script>
-->
<!-- <script src="<?= base_url()?>assets/admin/vendors/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script> -->
<script src="<?= base_url()?>assets/admin/vendors/datepicker/js/bootstrap-datepicker.js"></script>
erd54
<script src="<?= base_url()?>assets/admin/vendors/js/vendor.bundle.base.js"></script>
<script src="<?= base_url()?>assets/admin/vendors/js/vendor.bundle.addons.js"></script>
<script src="<?= base_url()?>assets/admin/js/off-canvas.js"></script>
<script src="<?= base_url()?>assets/admin/js/misc.js"></script>  
<script type="text/javascript">

  function formatDate(date) {
    var monthNames = [
    "Januari", "Februari", "Maret",
    "April", "Mei", "Juni", "Juli",
    "Agustus", "September", "Oktober",
    "November", "Desember"
    ];

    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();

    return day + ' ' + monthNames[monthIndex] + ' ' + year;
  }


  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#img").change(function() {
    readURL(this);
  });

  $("#bukti").change(function() {
    readURL(this);
  });

  function formatDate(date) {
    var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
    ];

    if((date.substr(6,1) <= 9)) {

      var monthIndex = date.substr(6,1) - 1;

    } else if ((date.substr(5,2) >= 10)) {

      var monthIndex = date.substr(5,2) - 1;
    }

    var day = (date.substr(8,2));
    var year = (date.substr(0,4));

    return day + ' ' + monthNames[monthIndex] + ' ' + year;
  }
</script>
  <!-- endinject -->