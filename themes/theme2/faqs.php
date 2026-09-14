<?php
$pageTitle = "FAQ's";
$pageDescription = "Answers to common shipping and logistics questions.";
include __DIR__ . '/header.php';
?>
<main class="main">
      <section class="section d-block hero-faqs">
        <div class="container position-relative">
          <div class="banner-trackyourparcel"></div>
          <div class="box-info-trackyourparcel">
            <h2 class="color-brand-2 mb-25 wow animate__animated animate__fadeIn">Frequently Asked<br class="d-none d-lg-block">Questions</h2>
            <p class="color-grey-900 font-md wow animate__animated animate__fadeIn">Everything you need to know about the product and billing. Can not find the answer you are looking for? Please Contact our support team.</p>
            <div class="form-trackparcel mb-0">
              <form action="#">
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Enter keyword">
                  <input class="btn btn-brand-1 btn-track" type="submit" value="Find the answer">
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
      <section class="section mt-100">
        <div class="container position-relative">
          <h2 class="title-favicon mb-20 wow animate__animated animate__fadeIn">Popular Topic</h2>
          <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Feeling inquisitive? Have a read through some of our FAQs or contact our supporters for help</p>
          <div class="row mt-50">
            <div class="col-lg-6">
              <div class="item-faqs-2 mb-30"><a href="#">
                  <h6 class="color-brand-2 mb-10 wow animate__animated animate__fadeIn">What is logistic cargo?</h6></a>
                <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Logistic cargo refers to the process of planning, implementing, and controlling the movement of goods and materials from one place to another. This includes everything from transportation, storage, inventory management, and more.</p>
              </div>
              <div class="item-faqs-2 mb-30"><a href="#">
                  <h6 class="color-brand-2 mb-10 wow animate__animated animate__fadeIn">What are the types of logistic cargo?</h6></a>
                <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">There are several types of logistic cargo, including air freight, sea freight, road transport, rail transport, and intermodal transport.</p>
              </div>
              <div class="item-faqs-2 mb-30"><a href="#">
                  <h6 class="color-brand-2 mb-10 wow animate__animated animate__fadeIn">What is the difference between freight and cargo?</h6></a>
                <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Freight refers to the goods being transported, while cargo refers to the actual containers or vessels used to transport the freight.</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="item-faqs-2 mb-30"><a href="#">
                  <h6 class="color-brand-2 mb-10 wow animate__animated animate__fadeIn">What is the difference between LCL and FCL?</h6></a>
                <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Some key factors to consider include the mode of transportation, the type of cargo being transported, the distance and route, the required delivery date, and any regulatory or customs requirements.</p>
              </div>
              <div class="item-faqs-2 mb-30"><a href="#">
                  <h6 class="color-brand-2 mb-10 wow animate__animated animate__fadeIn">How is logistic cargo priced?</h6></a>
                <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">Logistic cargo is typically priced based on the weight and volume of the cargo, as well as the distance and mode of transportation.</p>
              </div>
              <div class="item-faqs-2 mb-30"><a href="#">
                  <h6 class="color-brand-2 mb-10 wow animate__animated animate__fadeIn">What is a logistics provider?</h6></a>
                <p class="font-md color-grey-700 wow animate__animated animate__fadeIn">A logistics provider is a company that specializes in providing logistics services, including transportation, storage, inventory management, and more.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section">
        <div class="container position-relative">
          <div class="box-cover-contactform">
            <div class="row align-items-center">
              <div class="col-xl-8 col-lg-7">
                <div class="box-contactform-left">
                  <h3 class="color-brand-2 mb-15 wow animate__animated animate__fadeIn">Still have question?</h3>
                  <p class="font-md color-grey-900 mb-50 wow animate__animated animate__fadeIn">Can’t find the answer you are looking for? Please chat to our friendly team.</p>
                  <form action="contact.php" method="post">
                    <div class="row wow animate__animated animate__fadeIn">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input class="form-control" type="text" placeholder="Your name *" name="tname" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input class="form-control" type="email" placeholder="Your email *" name="temail" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input class="form-control" type="text" placeholder="Your phone number" name="tphone">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input class="form-control" type="text" placeholder="Subject" name="tsubject">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <textarea class="form-control" placeholder="Message / Note *" rows="8" name="tmessage" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <input class="btn btn-brand-1-big" type="submit" value="Submit Now">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-xl-4 col-lg-5 position-relative">
                <div class="box-contactform-right">
                  <h5 class="color-brand-2 mb-35 wow animate__animated animate__fadeIn">Headquarters</h5>
                  <div class="map-info"><img class="mb-25 wow animate__animated animate__fadeIn" src="resources/img/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height:44px;">
                    <p class="color-grey-700 mb-25 wow animate__animated animate__fadeIn"><?= htmlspecialchars($row['addr']) ?></p>
                    <p class="color-grey-700 mb-10 wow animate__animated animate__fadeIn">
                      <svg class="icon-16 mr-10 color-brand-1" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path>
                      </svg>Phone: <?= htmlspecialchars($row['phone']) ?>
                    </p>
                    <p class="color-grey-700 mb-30 wow animate__animated animate__fadeIn">
                      <svg class="icon-16 mr-10 color-brand-1" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path>
                      </svg>Email: <?= htmlspecialchars($row['email']) ?>
                    </p>
                    <div class="line-border mb-25"></div>
                    <p class="color-grey-700 font-md-bold wow animate__animated animate__fadeIn">Hours: 8:00 - 17:00, Mon - Sat</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="mt-90"></div>
      <section class="section pt-20 pb-120">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6"><span class="btn btn-tag wow animate__animated animate__fadeIn">Get in touch</span>
              <h3 class="color-grey-900 mb-20 mt-15 wow animate__animated animate__fadeIn">Proud to Deliver<br class="d-none d-lg-block">Excellence Every Time</h3>
              <p class="font-md color-grey-900 mb-40 wow animate__animated animate__fadeIn">From the first pickup call to final proof of delivery, our operations team keeps your shipment moving and keeps you informed at every step.</p>
              <div class="mt-20"><a class="btn btn-brand-2 mr-20 wow animate__animated animate__fadeIn" href="contact.php">Contact Us</a><a class="btn btn-link-medium wow animate__animated animate__fadeIn" href="workprocess.php">Learn More
                  <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                  </svg></a></div>
            </div>
            <div class="col-lg-6 position-relative">
              <div class="certified-icon wow animate__animated animate__fadeIn"><img src="themes/theme2/assets/imgs/page/homepage3/certified.png" alt="transp"></div>
              <div class="row">
                <div class="col-md-6 wow animate__animated animate__fadeIn"><img class="mt-90" src="themes/theme2/assets/imgs/page/homepage3/img-info-5.png" alt="transp"></div>
                <div class="col-md-6 wow animate__animated animate__fadeIn"><img src="themes/theme2/assets/imgs/page/homepage3/img-info-5-2.png" alt="transp"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
<?php include __DIR__ . '/footer.php'; ?>
