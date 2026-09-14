<?php include 'header.php'; ?>

<section id="send" class="page-title wrapper clearfix" style="background-image: url(themes/theme1/images/about-page-bg.jpg);">
	<div class="container">
		<div class="row">
			<div class="title-wrap wow fadeIn" data-wow-delay="1s">
				<h1>Contact</h1>
				<div class="breadcrumbs">
					<p>You Are Here :
						<span><a href="index">Home</a></span>
						<span class="arrow"><i class="icon icon-arrow-right"></i></span>
						<span>Contact</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
<style>
	.checkmark__circle {
		stroke-dasharray: 166;
		stroke-dashoffset: 166;
		stroke-width: 2;
		stroke-miterlimit: 10;
		stroke: #7ac142;
		fill: none;
		animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
	}

	.checkmark {
		width: 56px;
		height: 56px;
		border-radius: 50%;
		display: block;
		stroke-width: 2;
		stroke: #fff;
		stroke-miterlimit: 10;
		margin: 10% auto;
		box-shadow: inset 0px 0px 0px #7ac142;
		animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
	}

	.checkmark__check {
		transform-origin: 50% 50%;
		stroke-dasharray: 48;
		stroke-dashoffset: 48;
		animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
	}

	@keyframes stroke {
		100% {
			stroke-dashoffset: 0;
		}
	}

	@keyframes scale {

		0%,
		100% {
			transform: none;
		}

		50% {
			transform: scale3d(1.1, 1.1, 1);
		}
	}

	@keyframes fill {
		100% {
			box-shadow: inset 0px 0px 0px 30px #7ac142;
		}
	}
</style>

<section id="content" class="clearfix">

	<div class="contact-page wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<style>
						#jvectormap svg {
							height: 320px;
						}
					</style>
					<div class="col-md-12 text-center">
						<?php


						if ($_POST) {
							$adminmail = "";
							-$fname            = "";
							-$phone       	= "";
							-$subject       	= "";
							-$message = "";





							if (isset($_POST['fname'])) {
								$fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
							}

							if (isset($_POST['email'])) {
								$email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
								$email = filter_var($email, FILTER_VALIDATE_EMAIL);
							}
							if (isset($_POST['phone'])) {
								$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
							}

							if (isset($_POST['subject'])) {
								$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
							}


							if (isset($_POST['message'])) {
								$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
							}

							if (isset($_POST['adminmail'])) {
								$adminmail = filter_var($_POST['adminmail'], FILTER_SANITIZE_STRING);
							}

							$recipient = "$adminmail";


							$headers  = 'MIME-Version: 1.0' . "\r\n"
								. 'Content-type: text/html; charset=utf-8' . "\r\n"
								. 'From: ' . $email . "\r\n";

							$email_content = "<html><body>";
							$email_content .= "<table style='font-family: Arial;'><tbody><tr>
    <td style='background: #eee; padding: 10px;'>Name</td><td style='background: #fda; padding: 10px;'>$fname</td></tr>";

							$email_content .= "<tr><td style='background: #eee; padding: 10px;'> Email</td><td style='background: #fda; padding: 10px;'>$email</td></tr>";



							$email_content .= "<tr><td style='background: #eee; padding: 10px;'>Phone</td><td style='background: #fda; padding: 10px;'>$phone</td></tr>";


							$email_content .= "<tr><td style='background: #eee; padding: 10px;'>Subject</td><td style='background: #fda; padding: 10px;'>$subject</td></tr>";

							$email_content .= "<tr><td style='background: #eee; padding: 10px;'>Message</td><td style='background: #fda; padding: 10px;'>$message</td></tr>";


							$email_content .= '</body></html>';



							if (mail($recipient, "New Contact Message from Client", $email_content, $headers)) {
								echo '  <p class="block-title__tagline">We will keep in touch you</p><!-- /.block-title__tagline -->
                    <h2 class="block-title__title">Message Sent </h2>
                        
                   <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                             <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>  
';
							} else {
								echo '<p>We are sorry, but the Application failed. </p>';
							}
						} else {
							echo '<p>Something went wrong</p>';
						}

						?>


					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="contact-page wrapper bg-color">
		<div class="container">
			<div class="row">
				<div class="contact-wrap row">
					<div class="contact-details col-md-4" style="font-size: 15px;">
						<div class="address wow fadeInLeft" data-wow-delay="0.3s">
							<h4 class="title">reach us</h4>
							<p class="pb-4"><strong><i class="fa fa-phone"></i></a></li></strong> :
								<?php echo $row['phone']; ?> </p>
							<p class="pb-4"><strong><i class="fa fa-envelope"></i></a></li></strong> :
								<?php echo $row['email']; ?></p>
							<p class="pb-4"><i class="fa fa-envelope"></i></a></li> :
								booking@<?php echo $row['urlh']; ?></p>
							<p class="pb-4"><strong><i class="fa fa-map-marker"></i></a></li></strong> :
								<?php echo $row['addr']; ?></p>
						</div>

						<div class="address wow fadeInLeft" data-wow-delay="0.3s">
							<h4 class="title">UK Address</h4>
							<p class="pb-4"><strong><i class="fa fa-phone"></i></a></li></strong> : +44 7451273439</p>
							<p class="pb-4"><i class="fa fa-envelope"></i></a></li> :
								customercare@<?php echo $row['urlh']; ?></p>
							<p class="pb-4"><strong><i class="fa fa-map-marker"></i></a></li></strong> : 141 Tempo Road,
								Enniskillen, BT74 4RH, Northern Ireland, United Kingdom</p>
						</div>
					</div>
					<div class="contact-form col-md-8">
						<form method="post" action="#" class="row">
							<p class="name col-md-6">
								<label for="name">Name</label>
								<input id="fname" name="fname" type="text" value="" placeholder="Name"
									required="required">
							</p>
							<p class="email col-md-6">
								<label for="email">Email</label>
								<input id="email" name="email" type="text" value="" placeholder="Email"
									required="required">
							</p>
							<p class="telephone col-md-6">
								<label for="phone">Phone Number</label>
								<input id="phone" name="phone" type="text" value="" placeholder="Phone Number"
									required="required">
							</p>
							<p class="subject col-md-6">
								<label for="subject">Subject</label>
								<input id="subject" name="subject" type="text" value="" placeholder="Subject"
									required="required">
							</p>
							<p class="message col-md-12">
								<label for="message">Message</label>
								<textarea id="message" name="message" cols="45" rows="7"
									placeholder="Write your message here" required="required"></textarea>
							</p>
							<p class="col-md-12">
								<input type="hidden" name="action" value="SEND" />
								<button name="submit" type="submit" id="submit"
									class="btn btn-primary button-normal">Send Message</button>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


</section>


<?php include 'footer.php'; ?>