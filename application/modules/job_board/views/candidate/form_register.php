<?php
  $this->load->view('template/top');
  $this->load->view('nav_bar');
?>
<div class="container-fluid">
    <section class="container">
		<div class="container-page">
			<div class="col-md-6">
				<h3 class="dark-grey">Registration</h3>

				<div class="form-group col-lg-12">
					<label>Fullname</label>
					<input type="" name="" class="form-control" id="" value="">
				</div>

				<div class="form-group col-lg-6">
					<label>Gender</label>
          <select name="slc_gender" class="form-control">
            <option value=""></option>
            <option value="1">Male</option>
            <option value="0">Female</option>
          </select>
				</div>

				<div class="form-group col-lg-6">
					<label>Birthdate</label>
					<input type="date" name="dt_birthdate" class="form-control" id="" value="">
				</div>

				<div class="form-group col-lg-6">
					<label>Email Address</label>
					<input type="email" name="txt_email" class="form-control" id="" value="">
				</div>

				<div class="form-group col-lg-6">
					<label>Phone</label>
					<input type="text" name="txt_phone" class="form-control" id="" value="">
				</div>

				<!-- <div class="col-sm-6">
					<input type="checkbox" class="checkbox" />Sigh up for our newsletter
				</div>

				<div class="col-sm-6">
					<input type="checkbox" class="checkbox" />Send notifications to this email
				</div> -->

			</div>

			<div class="col-md-6">
				<h3 class="dark-grey">Terms and Conditions</h3>
				<p>
					By clicking on "Register" you agree to The Company's' Terms and Conditions
				</p>
				<p>
					While rare, prices are subject to change based on exchange rate fluctuations -
					should such a fluctuation happen, we may request an additional payment. You have the option to request a full refund or to pay the new price. (Paragraph 13.5.8)
				</p>
				<p>
					Should there be an error in the description or pricing of a product, we will provide you with a full refund (Paragraph 13.5.6)
				</p>
				<p>
					Acceptance of an order by us is dependent on our suppliers ability to provide the product. (Paragraph 13.5.6)
				</p>

				<button type="submit" class="btn btn-primary">Register</button>
			</div>
		</div>
	</section>
</div>
<?php
  echo $this->load->view('template/bot');
?>
