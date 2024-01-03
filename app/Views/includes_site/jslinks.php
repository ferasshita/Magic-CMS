<?php
$page_name = $page;
 ?>
	<!-- Vendor JS v-->
	<script src="<?php echo base_url();?>Asset/js/vendors.min.js"></script>

	<!-- Vendor Plugnin -->

  <!--charts v-->
	<script defer src="<?php echo base_url();?>Asset/assets/vendor_components/chart.js-master/Chart.min.js"></script>
  <!--charts v-->
	<script defer src="<?php echo base_url();?>Asset/js/pages/chartjs-int.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!--searching select box v-->
	<script src="<?php echo base_url();?>Asset/assets/vendor_components/select2/dist/js/select2.full.js"></script>
  <!--table v-->
    <script src="<?php echo base_url();?>Asset/assets/vendor_components/datatable/datatables.min.js"></script>
    <!--phone number fields-->
	<script src="<?php echo base_url();?>Asset/assets/vendor_plugins/input-mask/jquery.inputmask.js"></script>
  <!--js library for dates-->
	<script src="<?php echo base_url();?>Asset/assets/vendor_components/moment/min/moment.min.js"></script>
  <!--date picker -->
	<script src="<?php echo base_url();?>Asset/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!--template elements X v-->
	<script src="<?php echo base_url();?>Asset/js/template.js"></script>
  <!--theme v-->
	<script src="<?php echo base_url();?>Asset/js/demo.js"></script>
  <!--table v-->
    <script src="<?php echo base_url();?>Asset/js/pages/data-table.js"></script>
<!--form elements-->
    <script src="<?php echo base_url();?>Asset/js/pages/advanced-form-element.js"></script>
    <!--form submit v-->
    <script src="<?php echo base_url(); ?>Asset/js/jquery.form.js"></script>
<!-- cards bonds transfar -->
<script defer src="<?php echo base_url();?>Asset/assets/vendor_components/formatter/formatter.js"></script>
<script defer src="<?php echo base_url();?>Asset/assets/vendor_components/formatter/jquery.formatter.js"></script>
<script defer src="<?php echo base_url();?>Asset/js/pages/formatter.js"></script>
<!-- extra  -->
<script defer src="<?php echo base_url(); ?>Asset/js/pages/form-x-editable.js"></script>
<script defer src="<?php echo base_url(); ?>Asset/assets/vendor_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script>
	$(function () {
		'use strict'

		$('[data-provide~="fullscreen"]').on('click', function () {
			screenfull.toggle($('#container')[0]);
		});

	});
</script>
