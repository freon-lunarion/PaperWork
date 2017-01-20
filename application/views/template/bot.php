
  </body>
  <!-- Loading External JS file(s) -->
  <script type='text/javascript' src="<?php echo base_url(); ?>vendor/jquery/dist/jquery.js"></script>
  <script type='text/javascript' src="<?php echo base_url(); ?>vendor/moment/min/moment.min.js"></script>
  <script type='text/javascript' src="<?php echo base_url(); ?>vendor/bootstrap/dist/js/bootstrap.js"></script>
  <script type='text/javascript' src="<?php echo base_url(); ?>vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <script type='text/javascript' src="<?php echo base_url(); ?>vendor/sweetalert/dist/sweetalert-dev.js"></script>
  <script type='text/javascript' src="<?php echo base_url(); ?>vendor/datatables/media/js/jquery.dataTables.min.js"></script>
  <script type='text/javascript' src="<?php echo base_url(); ?>vendor/datatables/media/js/dataTables.bootstrap.min.js"></script>
  <script type='text/javascript' src="<?php echo base_url(); ?>vendor/datatables-bootstrap3/BS3/assets/js/dataTables.js"></script>


  <!-- end of Loading External JS file(s) -->

</html>
<script>
  var baseUrl = '<?php echo base_url()?>index.php/';
  $('.datepicker').datetimepicker({
    'format' : 'YYYY-MM-DD',
  });

</script>
