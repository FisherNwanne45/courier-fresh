<?php include 'header.php'; ?>

<section class="page-title wrapper clearfix" style="background-image: url(themes/theme1/images/about-page-bg.jpg);">
	<div class="container">
		<div class="row">
			<div class="title-wrap wow fadeIn" data-wow-delay="1s">
				<h1>About Us</h1>
				<div class="breadcrumbs">
					<p>You Are Here :
						<span><a href="index">Home</a></span>
						<span class="arrow"><i class="icon icon-arrow-right"></i></span>
						<span>About Us</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>


<section id="content" class="clearfix">

	<div class="company-info wrapper clearfix">
		<div class="container">
			<div class="row">
				<div class="company-wrap row">
					<div class="company-desc col-md-6 wow fadeIn" style="text-align: justify;">
						<h3 class="title">Company Profile</h3>
						<h3 style="text-align: left;">
							<?php echo $row['name']; ?> is a privately owned, premier international freight forwarder,
							delivery and logistics service provider.
						</h3>
						<p>
							<?php echo $row['name']; ?> has extensive experience handling and delivery sensitive
							domestic and industrial products including consumer technology products like networking
							equipment, desktop and mobile computers, servers, cell phones and more.
						</p>
						<p>
							<?php echo $row['name']; ?> delivers real-time, actionable information reliably and ensures
							optimal efficiency and on-time activities by
							utilizing advanced, custom software systems. Fully EDI capable, <?php echo $row['name']; ?>'
							systems interface with your trading partners
							to provide unprecedented product visibility throughout the entire supply chain.
						</p>
						<p>
							Our global regional hubs offer a wide range of mission-critical technology, logistic, IT and
							security services to clients and its partners overseas. Through our overseas secure services
							to more than 250 diplomatic offices, across 160 countries, we support around 14,000 staff
							globally, as well as many more from other government departments co-located at posts under
							the One HMG ethos. We provide complete confidence that information and goods are where they
							need to be, when they need to be, uncompromised.
						</p>
					</div>
					<div class="company-slider col-md-6 wow fadeIn">
						<ul class="slides">
							<li class="slide-item clearfix">
								<img src="themes/theme1/images/slider/company-slide-1.jpg" alt="" />
							</li>
							<li class="slide-item clearfix">
								<img src="themes/theme1/images/slider/company-slide-2.jpg" alt="" />
							</li>
							<li class="slide-item clearfix">
								<img src="themes/theme1/images/slider/company-slide-3.jpg" alt="" />
							</li>
						</ul>
					</div>
					<div class="company-vision">
						<div class="item col-md-4 wow fadeInUp" data-wow-delay="0.3s">
							<img src="themes/theme1/images/about_our_mission.jpg" alt="" />
							<h4>Our Mission</h4>
							<p>
								Connecting people, businesses and communities to a better future – through logistics.
							</p>
						</div>
						<div class="item col-md-4 wow fadeInUp" data-wow-delay="0.6s">
							<img src="themes/theme1/images/about_our_vision.jpg" alt="" />
							<h4>Our Vision</h4>
							<p>
								To become the world's preferred supply chain logistics company – applying insights,
								service
								quality and innovation to create sustainable growth for business and society.
							</p>
						</div>
						<div class="item col-md-4 wow fadeInUp" data-wow-delay="0.9s">
							<img src="themes/theme1/images/about_core_values.jpg" alt="" />
							<h4>Core Values</h4>
							<p>
								Value Creation – Openness – Integrity – Commitment – Excellence
								– Mutual Respect – Customer Orientation
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="wrapper clearfix" style="padding: 50px 0px 100px 0px;">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h3 class="title">Safety</h3>
					<p>At <?php echo $row['name']; ?>, ensuring the safety of our customers, employees and our
						communities is our priority. We understand the importance of continuous training and are proud
						of our safety knowledge, experienced staff and ability to exceed industry standards year after
						year. We have established and continually maintain excellent motor carrier safety ratings and
						low accident frequencies.</p>
					<p>As a company, we have a solid safety performance history and will continue to be a leader in the
						area of safety and compliance, due to the dedication and professionalism of our cargo handling
						officers, fleet of drivers and vehicle maintenance personnel.</p>
				</div>
				<div class="col-md-6">
					<h3 class="title">Security</h3>
					<p>At <?php echo $row['name']; ?>, we offer industry-leading asset protection and security
						compliance programs.</p>
					<p><?php echo $row['name']; ?> understands that our customers may have important and unique needs
						related to homeland security regulatory compliance, high-risk products, or brand protection. We
						offer consultation and proactive partnership to ensure that our customers’ security needs are
						met.</p>
					<p>By leveraging modern and proven technologies, we provide for the integrity of customer assets
						while in-transit or at one of our facilities.</p>
				</div>
			</div>
		</div>
	</div>

	<div class="testimonial wrapper with-bg">
		<div class="container">
			<div class="row">
				<div class="section-title text-center wow fadeIn">
					<h2>Testimonials</h2>
				</div>
				<div class="owl-carousel wow fadeIn" data-wow-delay="0.5s">
					<div class="testimonial-item">
						<p>
							Given my past experiences with other drayage/logistic companies,
							I can say without exception that the services provided by <?php echo $row['name']; ?>
							greatly exceed the industry standards.
						</p>
						<div class="client-info">

							<div class="client-details">
								<h3>Monique Pete</h3>
								<p>Logistics Manager, Martrax Inc.</p>
							</div>
						</div>
					</div>
					<div class="testimonial-item">
						<p>
							More than once, <?php echo $row['name']; ?> has ‘saved the day’, delivering our cargo
							on time with short notice. They have won my gratitude and my loyalty with their ‘can do’
							approach to helping clients.
						</p>
						<div class="client-info">

							<div class="client-details">
								<h3>Steve Anderson</h3>
								<p>President/Owner, Duplication Factory</p>
							</div>
						</div>
					</div>
					<div class="testimonial-item">
						<p>
							“I am very pleased with the service provided by <?php echo $row['name']; ?>.
							They find good carriers and use them regularly so we get a high level of service.
							Their communication and problem solving are outstanding.”
						</p>
						<div class="client-info">

							<div class="client-details">
								<h3>Cathy Beckman, </h3>
								<p>Logistics Team, Oxea Chemicals</p>
							</div>
						</div>
					</div>
				</div>
				<div class="our-partner">
					<div class="partner-logo col-md-15 wow fadeIn" data-wow-delay="0.3s">
						<img src="themes/theme1/images/content/partner-01.png" alt="" />
					</div>
					<div class="partner-logo col-md-15 wow fadeIn" data-wow-delay="0.6s">
						<img src="themes/theme1/images/content/partner-02.png" alt="" />
					</div>
					<div class="partner-logo col-md-15 wow fadeIn" data-wow-delay="0.9s">
						<img src="themes/theme1/images/content/partner-03.png" alt="" />
					</div>
					<div class="partner-logo col-md-15 wow fadeIn" data-wow-delay="1.2s">
						<img src="themes/theme1/images/content/partner-04.png" alt="" />
					</div>
					<div class="partner-logo col-md-15 wow fadeIn" data-wow-delay="1.5s">
						<img src="themes/theme1/images/content/partner-05.png" alt="" />
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="counter-section wrapper">
		<div class="container">
			<div class="row">
				<div class="counter-wrap row">
					<div class="counter-item col-md-15 wow fadeInUp" data-wow-delay="0.2s">
						<h2 class="counter">31,273</h2>
						<div class="counter-details">
							<p class="heading">Delivered Packages</p>

						</div>
					</div>
					<div class="counter-item col-md-15 wow fadeInUp" data-wow-delay="0.4s">
						<h2 class="counter">473,754</h2>
						<div class="counter-details">
							<p class="heading">KM Per Year</p>

						</div>
					</div>
					<div class="counter-item col-md-15 wow fadeInUp" data-wow-delay="0.6s">
						<h2 class="counter">11</h2>
						<div class="counter-details">
							<p class="heading">Years of Experience</p>

						</div>
					</div>
					<div class="counter-item col-md-15 wow fadeInUp" data-wow-delay="0.8s">
						<h2 class="counter">7714</h2>
						<div class="counter-details">
							<p class="heading">Happy Clients</p>

						</div>
					</div>
					<div class="counter-item col-md-15 wow fadeInUp" data-wow-delay="1s">
						<h2 class="counter">8</h2>
						<div class="counter-details">
							<p class="heading">Awards</p>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>


<?php include 'footer.php'; ?>