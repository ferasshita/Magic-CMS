<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verify Email</title>
	<?php echo view('includes/head_info'); ?>

	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
		}

		.container {
			width: 90%;
			max-width: 500px;
			margin: 50px auto;
			background-color: #fff;
			padding: 30px;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
			text-align: center;
		}

		form {


		.form-control {
			display: block;
			height: 50px;
			margin-right: 0.5rem;
			text-align: center;
			font-size: 1.25rem;
			min-width: 0;

		&:last-child {
			 margin-right: 0;
		 }
		}
		}

		h1 {
			font-size: 2.5rem;
			margin-bottom: 30px;
			color: #333;
		}

		p {
			font-size: 1.2rem;
			margin-bottom: 30px;
			color: #666;
		}

		form input {
			width: 100%;
			height: 50px;
			padding: 10px;
			margin-bottom: 20px;
			border-radius: 5px;
			border: 1px solid #ccc;
			font-size: 1.2rem;
		}

		form button {
			width: 100%;
			height: 50px;
			background-color: #007bff;
			color: #fff;
			border: none;
			border-radius: 5px;
			font-size: 1.2rem;
			cursor: pointer;
			transition: background-color 0.3s ease;
			margin-bottom: 10px;
		}

		form button:hover {
			background-color: #0069d9;
		}

		@media screen and (max-width: 600px) {
			.container {
				width: 100%;
				padding: 20px;
			}

			h1 {
				font-size: 2rem;
			}

			p {
				font-size: 1rem;
			}
		}

	</style>
</head>
<body>
<div class="container">
	<h1>Verify Your Email Address</h1>
	<p>We sent a verification email to your email address. Please check your inbox and follow the instructions to verify your account.</p>
	<form action="#">
		<h4 class="text-center mb-4">Enter your code</h4>
		<div class="d-flex mb-3">
			<input type="tel" onkeypress="verifi()" style="text-align:center" maxlength="1" pattern="[0-9]" class="form-control">
			<input type="tel" onkeypress="verifi()" style="text-align:center" maxlength="1" pattern="[0-9]" class="form-control">
			<input type="tel" onkeypress="verifi()" style="text-align:center" maxlength="1" pattern="[0-9]" class="form-control">
			<input type="tel" onkeypress="verifi()" style="text-align:center" maxlength="1" pattern="[0-9]" class="form-control">
			<input type="tel" onkeypress="verifi()" style="text-align:center" maxlength="1" pattern="[0-9]" class="form-control">
			<input type="tel" onkeypress="verifi()" style="text-align:center" maxlength="1" pattern="[0-9]" class="form-control">
		</div>
	</form>
	<p>خطا في بريدك الاكتروني أو رقم الهاتف؟ يمكنك تغيره من هنا.</p>
	<form action="" method="post" class="form">
		<div class="form-group">
			<input type="text" name="edit_phone" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['phone']; ?>" aria-describedby="phoneHelp" placeholder="<?php echo langs('phone'); ?>">
			<input type="email" name="edit_email" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['email']; ?>" aria-describedby="emailHelp" placeholder="<?php echo langs('email'); ?>">
		</div>
		<button type="submit" name="resend">اعادة ارسال الرسالة</button>
		<a href="<?php echo base_url();?>Account/logout" target="_blank"><button type="button" style="background: red" name="resend">رجوع</button></a>

	</form>

	<div align="center" style="border-radius: 3px;" bgcolor="#17b3a3">
	</div>



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(document).ready(function() {
		// Auto focus on input field
		$('input[name="verification_code"]').focus();
	});
	const form = document.querySelector('form')
	const inputs = form.querySelectorAll('input')
	const KEYBOARDS = {
		backspace: 8,
		arrowLeft: 37,
		arrowRight: 39,
	}

	function handleInput(e) {
		const input = e.target
		const nextInput = input.nextElementSibling
		if (nextInput && input.value) {
			nextInput.focus()
			if (nextInput.value) {
				nextInput.select()
			}
		}
	}

	function handlePaste(e) {
		e.preventDefault()
		const paste = e.clipboardData.getData('text')
		inputs.forEach((input, i) => {
			input.value = paste[i] || ''
		})
	}

	function handleBackspace(e) {
		const input = e.target
		if (input.value) {
			input.value = ''
			return
		}

		input.previousElementSibling.focus()
	}

	function handleArrowLeft(e) {
		const previousInput = e.target.previousElementSibling
		if (!previousInput) return
		previousInput.focus()
	}

	function handleArrowRight(e) {
		const nextInput = e.target.nextElementSibling
		if (!nextInput) return
		nextInput.focus()
	}

	form.addEventListener('input', handleInput)
	inputs[0].addEventListener('paste', handlePaste)

	inputs.forEach(input => {
		input.addEventListener('focus', e => {
			setTimeout(() => {
				e.target.select()
			}, 0)
		})

		input.addEventListener('keydown', e => {
			switch(e.keyCode) {
				case KEYBOARDS.backspace:
					handleBackspace(e)
					break
				case KEYBOARDS.arrowLeft:
					handleArrowLeft(e)
					break
				case KEYBOARDS.arrowRight:
					handleArrowRight(e)
					break
				default:
			}
		})
	})

</script>
<script>
	function verifi(){
		var cContent = $.trim($('#code').val());
		if (cContent == '') {

		}else{
			$.ajax({
				type: "POST",
				url: "Account/phone_check",
				data: {"cContent":cContent },
				success: function(done){
					if (done == 'yes') {
						setTimeout('window.location.href = "<?php echo base_url();?>Dashboard"; ',1000);
					}
				}
			});
		}

	}
</script>

</body>
</html>
