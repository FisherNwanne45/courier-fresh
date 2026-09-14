<?php
$pageTitle = "Track Your Parcel";
$pageDescription = "Track the status of your shipment.";
include __DIR__ . '/header.php';
?>
<main class="main">
      <section class="section d-block">
        <div class="container position-relative">
          <div class="banner-trackyourparcel"></div>
          <div class="box-info-trackyourparcel">
            <h2 class="color-brand-2 mb-25 wow animate__animated animate__fadeIn">Package tracking is easy<br class="d-none d-lg-block">with your tracking number</h2>
            <p class="color-grey-900 font-md wow animate__animated animate__fadeIn">Enter the tracking number provided when your shipment was booked to see its<br class="d-none d-lg-block">live status with <?= htmlspecialchars($row['name']) ?>.</p>
            <div class="form-trackparcel wow animate__animated animate__fadeIn">
              <form action="resources/track-result.php" method="post" name="form" id="form">
                <div class="form-group">
                  <input required type="text" name="search" id="search" class="form-control" placeholder="Your tracking number" value="">
                  <input value="cid" type="hidden" name="dropdown">
                  <input class="btn btn-brand-1 btn-track" type="submit" name="Submit" value="Track Package">
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
      <section class="section pt-85">
        <div class="container">
          <div class="row mt-50 align-items-center">
            <div class="col-lg-6 mb-30">
              <h6 class="color-brand-2 mb-15 wow animate__animated animate__fadeIn">Real-time visibility</h6>
              <h2 class="color-brand-2 mb-25 wow animate__animated animate__fadeIn">Track every step of the journey</h2>
              <div class="row">
                <div class="col-lg-9">
                  <p class="font-md color-grey-900 wow animate__animated animate__fadeIn">Our tracking system is updated as your shipment moves, so you always have the most up-to-date information on its progress -- from pickup, through customs, to final delivery. We also email you automatically whenever your shipment's status changes.</p>
                </div>
              </div>
              <div class="row mt-50">
                <div class="col-lg-6 mb-30">
                  <h6 class="chart-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Boost your sale</h6>
                  <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Reliable delivery times help your business keep customers coming back.</p>
                </div>
                <div class="col-lg-6 mb-30">
                  <h6 class="chart-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Boost your sale</h6>
                  <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Reliable delivery times help your business keep customers coming back.</p>
                </div>
                <div class="col-lg-6 mb-30">
                  <h6 class="feature2-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Introducing New Features</h6>
                  <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Real-time tracking and automated status alerts, built into every shipment.</p>
                </div>
                <div class="col-lg-6 mb-30">
                  <h6 class="feature3-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Introducing New Features</h6>
                  <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Real-time tracking and automated status alerts, built into every shipment.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-30">
              <div class="box-image-how"><img class="w-100 wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/page/trackyourparcel/img-info-7.png" alt="transp">
                <div class="box-info-bottom-img">
                  <div class="image-play wow animate__animated animate__fadeIn"><img class="mb-15" src="themes/theme2/assets/imgs/template/icons/play.svg" alt="transp"></div>
                  <div class="info-play wow animate__animated animate__fadeIn">
                    <h4 class="color-white mb-15">We have 25 years experience in this passion</h4>
                    <p class="font-sm color-white">We combine two decades of freight-forwarding experience with a hands-on operations team, so every shipment is tracked from pickup to final delivery.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="mt-90"></div>
      <div class="section bg-2 pt-65 pb-35">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-5 mb-30 text-center text-lg-start wow animate__animated animate__fadeIn">
              <p class="font-2xl-bold color-brand-2">Ready to <span class="color-brand-1">ship</span> with us?</p>
            </div>
            <div class="col-lg-7 mb-30 text-center text-lg-end wow animate__animated animate__fadeIn">
              <a class="btn btn-brand-1-big hover-up mr-15" href="contact.php">Get a Quote</a>
              <a class="btn btn-brand-2 hover-up" href="tracking.php">Track a Shipment</a>
            </div>
          </div>
        </div>
      </div>
      <section class="section pt-100">
        <div class="container">
          <div class="text-center"><span class="btn btn-tag color-grey-900 wow animate__animated animate__fadeIn">Our Features</span>
            <h2 class="color-brand-2 mb-15 mt-20 wow animate__animated animate__fadeIn">Why choose us</h2>
          </div>
          <div class="row mt-60">
            <div class="col-xl-3 col-lg-3 col-md-6 wow animate__animated animate__fadeIn">
              <div class="item-reason">
                <div class="card-offer cardServiceStyle3 hover-up">
                  <div class="card-image"><img src="themes/theme2/assets/imgs/page/homepage4/container.png" alt="transp"></div>
                  <div class="card-info">
                    <h5 class="color-brand-2 mb-15">Over 1200 couriers</h5>
                    <p class="font-sm color-grey-900">A vetted network of couriers and carriers spanning air, sea and road.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 wow animate__animated animate__fadeIn">
              <div class="item-reason">
                <div class="card-offer cardServiceStyle3 hover-up">
                  <div class="card-image"><img src="themes/theme2/assets/imgs/page/homepage4/24-hours.png" alt="transp"></div>
                  <div class="card-info">
                    <h5 class="color-brand-2 mb-15">Automatic courier</h5>
                    <p class="font-sm color-grey-900">Shipments are automatically routed to the fastest available courier.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 wow animate__animated animate__fadeIn">
              <div class="item-reason">
                <div class="card-offer cardServiceStyle3 hover-up">
                  <div class="card-image"><img src="themes/theme2/assets/imgs/page/homepage4/stopwatch.png" alt="transp"></div>
                  <div class="card-info">
                    <h5 class="color-brand-2 mb-15">Real-time alert</h5>
                    <p class="font-sm color-grey-900">Get instant status updates the moment your shipment's status changes.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 wow animate__animated animate__fadeIn">
              <div class="item-reason">
                <div class="card-offer cardServiceStyle3 hover-up">
                  <div class="card-image"><img src="themes/theme2/assets/imgs/page/homepage4/pallet.png" alt="transp"></div>
                  <div class="card-info">
                    <h5 class="color-brand-2 mb-15">Email alerts</h5>
                    <p class="font-sm color-grey-900">Automatic email notifications keep senders and receivers in the loop.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="mt-50"></div>
      <section class="section pt-80 mb-70 bg-faqs">
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <div class="box-faqs-left">
                <h2 class="title-favicon mb-20 wow animate__animated animate__fadeIn">FAQs</h2>
                <p class="font-md color-grey-700 mb-50 wow animate__animated animate__fadeIn">Feeling inquisitive? Have a read through some of our FAQs or contact our supporters for help</p>
                <div class="box-gallery-faqs">
                  <div class="image-top wow animate__animated animate__fadeIn"><img src="themes/theme2/assets/imgs/page/trackyourparcel/img-faqs1.png" alt="transp"></div>
                  <div class="image-bottom wow animate__animated animate__fadeIn">
                    <div class="image-faq-1"><img src="themes/theme2/assets/imgs/page/trackyourparcel/img-faqs2.png" alt="transp"></div>
                    <div class="image-faq-2"><img src="themes/theme2/assets/imgs/page/trackyourparcel/img-faqs3.png" alt="transp"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="box-accordion">
                <div class="accordion" id="accordionFAQ">
                  <div class="accordion-item wow animate__animated animate__fadeIn">
                    <h5 class="accordion-header" id="headingTwo">
                      <button class="accordion-button text-heading-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">How do I request a shipping quote?</button>
                    </h5>
                    <div class="accordion-collapse collapse show" id="collapseTwo" aria-labelledby="headingTwo" data-bs-parent="#accordionFAQ">
                      <div class="accordion-body">Contact our team with your shipment's origin, destination, weight and dimensions, and we'll send a detailed quote within one business day.</div>
                    </div>
                  </div>
                  <div class="accordion-item wow animate__animated animate__fadeIn">
                    <h5 class="accordion-header" id="headingThree">
                      <button class="accordion-button text-heading-5 collapsed text-heading-5 type=" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Can I change my shipment after it's booked?</button>
                    </h5>
                    <div class="accordion-collapse collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionFAQ">
                      <div class="accordion-body">Yes -- contact our support team as soon as possible with your tracking number. We can amend most shipments up until they've been collected.</div>
                    </div>
                  </div>
                  <div class="accordion-item wow animate__animated animate__fadeIn">
                    <h5 class="accordion-header" id="headingFour">
                      <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Do you handle customs clearance?</button>
                    </h5>
                    <div class="accordion-collapse collapse" id="collapseFour" aria-labelledby="headingFour" data-bs-parent="#accordionFAQ">
                      <div class="accordion-body">Yes, our team manages customs documentation and clearance for international shipments so you don't have to.</div>
                    </div>
                  </div>
                  <div class="accordion-item wow animate__animated animate__fadeIn">
                    <h5 class="accordion-header" id="headingFive">
                      <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">What are the delivery types you use?</button>
                    </h5>
                    <div class="accordion-collapse collapse" id="collapseFive" aria-labelledby="headingFive" data-bs-parent="#accordionFAQ">
                      <div class="accordion-body">We offer express, standard and economy delivery across air, sea and road freight, tailored to your timeline and budget.</div>
                    </div>
                  </div>
                  <div class="accordion-item wow animate__animated animate__fadeIn">
                    <h5 class="accordion-header" id="headingSix">
                      <button class="accordion-button text-heading-5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">How do I pay for a shipment?</button>
                    </h5>
                    <div class="accordion-collapse collapse" id="collapseSix" aria-labelledby="headingSix" data-bs-parent="#accordionFAQ">
                      <div class="accordion-body">We accept bank transfer and major cards. An invoice is issued once your shipment is booked and confirmed.</div>
                    </div>
                  </div>
                </div>
                <div class="line-border mt-50 mb-50"></div>
                <h3 class="color-brand-2 wow animate__animated animate__fadeIn">Need more help?</h3>
                <div class="mt-20"><a class="btn btn-brand-1-big mr-20 wow animate__animated animate__fadeIn" href="contact.php">Contact Us</a><a class="btn btn-link-medium wow animate__animated animate__fadeIn" href="#">Learn More
                    <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg></a></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section mt-100">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-50">
              <div class="box-info-6 box-info-8"><span class="btn btn-tag wow animate__animated animate__fadeIn">Who We Are?</span>
                <h2 class="color-grey-900 mb-20 mt-15 wow animate__animated animate__fadeIn">We are the world's leading shipping service provider</h2>
                <p class="font-md color-grey-900 mb-35 wow animate__animated animate__fadeIn">Over the years, we have worked together to expand our network of partners to deliver reliability and consistency. We’ve also made significant strides to tightly integrate technology with our processes, giving our clients greater visibility into every engagement.</p>
                <div class="row">
                  <div class="col-lg-6 mb-30">
                    <h6 class="chart-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Boost your sale</h6>
                    <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Reliable delivery times help your business keep customers coming back.</p>
                  </div>
                  <div class="col-lg-6 mb-30">
                    <h6 class="chart-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Boost your sale</h6>
                    <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Reliable delivery times help your business keep customers coming back.</p>
                  </div>
                  <div class="col-lg-6 mb-30">
                    <h6 class="feature2-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Introducing New Features</h6>
                    <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Real-time tracking and automated status alerts, built into every shipment.</p>
                  </div>
                  <div class="col-lg-6 mb-30">
                    <h6 class="feature3-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Introducing New Features</h6>
                    <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Real-time tracking and automated status alerts, built into every shipment.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-50">
              <div class="box-image-why box-image-why-info-8"><img class="wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/page/homepage3/img-info-6.png" alt="transp">
                <div class="box-button-play"><a class="btn btn-play popup-youtube hover-up wow animate__animated animate__fadeIn" href="https://www.youtube.com/watch?v=kCGf5uNE13I"><img class="wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/template/icons/play.svg" alt="transp"><span class="color-white wow animate__animated animate__fadeIn">How it work ?<br>Watch video tour</span></a></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="mt-90"></div>
      <div class="section bg-map d-block">
        <div class="container">
          <div class="box-newsletter">
            <h3 class="color-brand-2 mb-20 wow animate__animated animate__fadeIn">Get in Touch</h3>
            <div class="row">
              <div class="col-lg-5 mb-30">
                <div class="form-newsletter wow animate__animated animate__fadeIn">
                  <form action="contact.php" method="post">
                    <div class="row">
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
                      <div class="col-md-12">
                        <div class="form-group">
                          <input class="form-control" type="text" placeholder="Subject" name="tsubject">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <textarea class="form-control" placeholder="Message / Note *" rows="5" name="tmessage" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <input class="btn btn-brand-1-big" type="submit" value="Submit Now">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-lg-7 mb-30">
                <div class="d-flex box-newsletter-right">
                  <div class="box-map-2 wow animate__animated animate__fadeIn">
                    <iframe src="https://www.google.com/maps?q=<?= urlencode($row['addr']) ?>&amp;output=embed" height="242" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                  <ul class="list-info-footer">
                    <li class="wow animate__animated animate__fadeIn">
                      <div class="cardImage"><span class="icon-brand-1"><img src="themes/theme2/assets/imgs/page/homepage2/address.svg" alt="transp"></span></div>
                      <div class="cardInfo">
                        <h6 class="font-sm-bold color-grey-900">Address</h6>
                        <p class="font-sm color-grey-900"><?= htmlspecialchars($row['addr']) ?></p>
                      </div>
                    </li>
                    <li class="wow animate__animated animate__fadeIn">
                      <div class="cardImage"><span class="icon-brand-1"><img src="themes/theme2/assets/imgs/page/homepage2/email.svg" alt="transp"></span></div>
                      <div class="cardInfo">
                        <h6 class="font-sm-bold color-grey-900">Email</h6>
                        <p class="font-sm color-grey-900"><?= htmlspecialchars($row['email']) ?></p>
                      </div>
                    </li>
                    <li class="wow animate__animated animate__fadeIn">
                      <div class="cardImage"><span class="icon-brand-1"><img src="themes/theme2/assets/imgs/page/homepage2/phone.svg" alt="transp"></span></div>
                      <div class="cardInfo">
                        <h6 class="font-sm-bold color-grey-900">Telephone</h6>
                        <p class="font-sm color-grey-900"><?= htmlspecialchars($row['phone']) ?></p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
<?php include __DIR__ . '/footer.php'; ?>
