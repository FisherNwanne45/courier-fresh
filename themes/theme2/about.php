<?php
$pageTitle = "About Us";
$pageDescription = "Learn about our mission, network and logistics expertise.";
include __DIR__ . '/header.php';
?>
<main class="main">
      <section class="section">
        <div class="container">
          <div class="box-pageheader-1 text-center"><span class="btn btn-tag wow animate__animated animate__fadeIn">Who We Are</span>
            <h2 class="color-brand-1 mt-15 mb-10 wow animate__animated animate__fadeIn">About Us</h2>
            <p class="font-md color-white wow animate__animated animate__fadeIn">We have been pioneering the industry in Europe for 20 years, and delivering value<br class="d-none d-lg-block">products within given timeframe, every single time.</p>
          </div>
        </div>
      </section>
      <section class="section mt-100 mb-50">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-30">
              <h2 class="color-brand-2 mb-25 wow animate__animated animate__fadeIn">Simplifying complex shipping challenges with innovative solutions</h2>
              <p class="font-md color-grey-900 mb-20 wow animate__animated animate__fadeIn">Logistics companies are essential to the smooth functioning of global supply chains. They offer a range of services such as transportation, warehousing, inventory management, and distribution to businesses across different industries. The role of logistics companies has become increasingly important in recent years due to the growth of e-commerce and global trade.</p>
              <div class="box-button mt-40"><a class="btn btn-brand-1-big hover-up mr-40 wow animate__animated animate__fadeIn" href="index.php#calculate-shipping">Calculate Package</a><a class="btn btn-play popup-youtube hover-up wow animate__animated animate__fadeIn" href="https://www.youtube.com/watch?v=kCGf5uNE13I"><img src="themes/theme2/assets/imgs/template/icons/play.svg" alt="transp"></a></div>
            </div>
            <div class="col-lg-6 position-relative mb-30">
              <div class="row align-items-end">
                <div class="col-lg-5 col-md-5 col-sm-5"><img class="mb-20 wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/page/about/img-about-1-1.png" alt="transp"><img class="wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/page/about/img-about-1-2.png" alt="transp"></div>
                <div class="col-lg-7 col-md-7 col-sm-7"><img class="wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/page/about/img-about-1-3.png" alt="transp"></div>
              </div>
              <div class="quote-center shape-2"></div>
            </div>
          </div>
        </div>
      </section>
      <section class="section mt-50 mb-50">
        <div class="container">
          <div class="row align-items-center item-about-2">
            <div class="col-lg-6"><img class="wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/page/about/img-about-2-1.png" alt="transp"></div>
            <div class="col-lg-6">
              <div class="box-info-aabout-2"><span class="btn btn-tag wow animate__animated animate__fadeIn">Mission</span>
                <h2 class="color-brand-2 mt-15 mb-25 wow animate__animated animate__fadeIn">Globally Connected by Large Network</h2>
                <p class="font-md color-grey-900 mb-20 wow animate__animated animate__fadeIn">At <?= htmlspecialchars($row['name']) ?>, our mission is to provide our clients with exceptional transportation services that meet and exceed their expectations. We aim to be the most reliable, efficient, and cost-effective transportation provider in the industry.</p>
                <div class="box-button mt-40">
                  <div class="row">
                    <div class="col-lg-6 mb-30">
                      <h6 class="chart-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Affordable Cost</h6>
                      <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Transparent, competitive rates with no hidden fees on any shipment.</p>
                    </div>
                    <div class="col-lg-6 mb-30">
                      <h6 class="feature-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Shot Time Delivery</h6>
                      <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Optimized routing gets your shipments where they need to be, faster.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center item-about-2 item-about-2-revert">
            <div class="col-lg-6">
              <div class="box-info-aabout-2"><span class="btn btn-tag wow animate__animated animate__fadeIn">History</span>
                <h2 class="color-brand-2 mt-15 mb-25 wow animate__animated animate__fadeIn">Globally Connected by Large Network</h2>
                <p class="font-md color-grey-900 mb-20 wow animate__animated animate__fadeIn"><?= htmlspecialchars($row['name']) ?> was founded in 2005 by a group of transportation professionals who saw an opportunity to provide a better level of service to businesses. Since our founding, we have grown to become a leading transportation provider, with a presence in over 30 countries around the world.</p>
                <div class="box-button mt-40"><a class="btn btn-brand-2 mr-20 wow animate__animated animate__fadeIn" href="contact.php">Contact Us</a><a class="btn btn-link-medium wow animate__animated animate__fadeIn" href="#">Learn More
                    <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg></a></div>
              </div>
            </div>
            <div class="col-lg-6"><img class="wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/page/about/img-about-2-2.png" alt="transp"></div>
          </div>
          <div class="row align-items-center item-about-2">
            <div class="col-lg-6"><img class="wow animate__animated animate__fadeIn" src="themes/theme2/assets/imgs/page/about/img-about-2-3.png" alt="transp"></div>
            <div class="col-lg-6">
              <div class="box-info-aabout-2"><span class="btn btn-tag wow animate__animated animate__fadeIn">Our Partners</span>
                <h2 class="color-brand-2 mt-15 mb-25 wow animate__animated animate__fadeIn">We have established strong relationships with our partners</h2>
                <p class="font-md color-grey-900 mb-20 wow animate__animated animate__fadeIn">We strive to become pioneers in the field, providing first quality and cost-effective service, and smart solutions to the market. Our 30 years’ experience in the shipping, transport and logistics industry is our strength, which support us to deliver our promises to our customers.</p>
                <div class="box-button mt-40"><a class="btn btn-brand-2 hover-up wow animate__animated animate__fadeIn" href="contact.php">Contact Us</a></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section mt-55 bg-1 position-relative pt-90 pb-90">
        <div class="container">
          <div class="row">
            <div class="col-lg-6"><span class="btn btn-tag wow animate__animated animate__fadeIn">Get in touch</span>
              <h3 class="color-grey-900 mb-20 mt-15 wow animate__animated animate__fadeIn">Proud to Deliver<br class="d-none d-lg-block">Excellence Every Time</h3>
              <p class="font-md color-grey-900 mb-40 wow animate__animated animate__fadeIn">From the first pickup call to final proof of delivery, our operations team keeps your shipment moving and keeps you informed at every step.</p>
              <div class="row">
                <div class="col-lg-6 mb-30">
                  <h6 class="chart-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Boost your sale</h6>
                  <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Reliable delivery times help your business keep customers coming back.</p>
                </div>
                <div class="col-lg-6 mb-30">
                  <h6 class="feature-title font-md-bold color-grey-900 wow animate__animated animate__fadeIn">Introducing New Features</h6>
                  <p class="font-xs color-grey-900 wow animate__animated animate__fadeIn">Real-time tracking and automated status alerts, built into every shipment.</p>
                </div>
              </div>
              <div class="mt-20"><a class="btn btn-brand-2 mr-20 wow animate__animated animate__fadeIn" href="contact.php">Contact Us</a><a class="btn btn-link-medium wow animate__animated animate__fadeIn" href="#">Learn More
                  <svg class="w-6 h-6 icon-16 ml-5" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                  </svg></a></div>
            </div>
          </div>
        </div>
        <div class="box-image-touch box-image-info-2-2"></div>
      </section>
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
      <div class="mt-50"></div>
      <section class="section mt-50">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-8 col-md-8">
              <h2 class="title-favicon color-brand-2 mb-20 title-padding-left wow animate__animated animate__fadeIn">Testimonials</h2>
              <p class="font-lg color-brand-2 pl-55 wow animate__animated animate__fadeIn">Hear from our users who have saved thousands on their<br class="d-none d-lg-block">Startup and SaaS solution spend.</p>
            </div>
            <div class="col-lg-4 col-md-4 text-end">
              <div class="box-button-sliders">
                <div class="swiper-button-prev swiper-button-prev-style-1 swiper-button-prev-customers wow animate__animated animate__fadeIn">
                  <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                  </svg>
                </div>
                <div class="swiper-button-next swiper-button-next-style-1 swiper-button-next-customers wow animate__animated animate__fadeIn">
                  <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-slide-customers overflow-hidden mt-50">
          <div class="box-slide-customers-2">
            <div class="box-swiper">
              <div class="swiper-container swiper-group-4-customers pb-50">
                <div class="swiper-wrapper">
                  <div class="swiper-slide wow animate__animated animate__fadeIn">
                    <div class="card-testimonial-grid">
                      <div class="box-author mb-25"><a href="#"><img src="themes/theme2/assets/imgs/page/homepage1/author.png" alt="transp"></a>
                        <div class="author-info"><a href="#"><span class="font-xl-bold color-brand-2 author-name">Guy Hawkins</span></a><span class="font-sm color-grey-500 department">Bank of America</span></div>
                      </div>
                      <p class="font-md color-grey-700">Access the same project through five different dynamic views: a kanban board, Gantt chart, spreadsheet, calendar or simple task list.</p>
                      <div class="card-bottom-info justify-content-between">
                        <div class="rating text-start"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><br><span class="font-sm color-white">For customer support</span></div><span class="font-xs color-grey-500 rate-post text-end">Rate: 4.95 / 5</span>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide wow animate__animated animate__fadeIn">
                    <div class="card-testimonial-grid">
                      <div class="box-author mb-25"><a href="#"><img src="themes/theme2/assets/imgs/page/homepage1/author2.png" alt="transp"></a>
                        <div class="author-info"><a href="#"><span class="font-xl-bold color-brand-2 author-name">Eleanor Pena</span></a><span class="font-sm color-grey-500 department">Bank of America</span></div>
                      </div>
                      <p class="font-md color-grey-700">Access the same project through five different dynamic views: a kanban board, Gantt chart, spreadsheet, calendar or simple task list.</p>
                      <div class="card-bottom-info justify-content-between">
                        <div class="rating text-start"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><br><span class="font-sm color-white">For customer support</span></div><span class="font-xs color-grey-500 rate-post text-end">Rate: 4.95 / 5</span>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide wow animate__animated animate__fadeIn">
                    <div class="card-testimonial-grid">
                      <div class="box-author mb-25"><a href="#"><img src="themes/theme2/assets/imgs/page/homepage1/author3.png" alt="transp"></a>
                        <div class="author-info"><a href="#"><span class="font-xl-bold color-brand-2 author-name">Cody Fisher</span></a><span class="font-sm color-grey-500 department">Bank of America</span></div>
                      </div>
                      <p class="font-md color-grey-700">Access the same project through five different dynamic views: a kanban board, Gantt chart, spreadsheet, calendar or simple task list.</p>
                      <div class="card-bottom-info justify-content-between">
                        <div class="rating text-start"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><img src="themes/theme2/assets/imgs/template/icons/star.svg" alt="transp"><br><span class="font-sm color-white">For customer support</span></div><span class="font-xs color-grey-500 rate-post text-end">Rate: 4.95 / 5</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section pt-70 pb-70 bg-get-quote">
        <div class="container">
          <div class="box-get-quote">
            <div class="get-quote-left">
              <p class="font-3xl color-white mb-10 wow animate__animated animate__fadeIn">Ready to ship your next order?</p>
              <h2 class="color-brand-1 wow animate__animated animate__fadeIn">Get a Quote for Your Shipment</h2>
            </div>
            <div class="get-quote-right"><a class="btn btn-get-quote wow animate__animated animate__fadeIn" href="contact.php">
                <svg class="mr-10" fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path>
                </svg>GET A QUOTE</a></div>
          </div>
        </div>
      </section>
      <div class="mt-50"></div>
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
