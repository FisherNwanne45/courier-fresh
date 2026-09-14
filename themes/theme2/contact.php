<?php
$pageTitle = "Contact Us";
$pageDescription = "Get in touch with our logistics team.";

// Needs $row (site settings) and sendMailSMTP() -- both come from config.php,
// which header.php requires below. Load it directly here too so this form
// can be processed before the page head is emitted.
require_once __DIR__ . '/../../resources/config.php';

$contactMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tname'])) {
    $cName = trim($_POST['tname'] ?? '');
    $cEmail = trim($_POST['temail'] ?? '');
    $cPhone = trim($_POST['tphone'] ?? '');
    $cSubject = trim($_POST['tsubject'] ?? '');
    $cMessage = trim($_POST['tmessage'] ?? '');

    if ($cName === '' || !filter_var($cEmail, FILTER_VALIDATE_EMAIL) || $cMessage === '') {
        $contactMessage = '<div class="alert alert-danger">Please fill in your name, a valid email address, and a message.</div>';
    } else {
        $subjectLine = 'New website enquiry' . ($cSubject !== '' ? ': ' . $cSubject : '');
        $htmlBody = '<p><strong>From:</strong> ' . htmlspecialchars($cName) . ' &lt;' . htmlspecialchars($cEmail) . '&gt;</p>'
            . ($cPhone !== '' ? '<p><strong>Phone:</strong> ' . htmlspecialchars($cPhone) . '</p>' : '')
            . '<p><strong>Message:</strong></p><p>' . nl2br(htmlspecialchars($cMessage)) . '</p>';
        $textBody = "From: {$cName} <{$cEmail}>\n" . ($cPhone !== '' ? "Phone: {$cPhone}\n" : '') . "\nMessage:\n{$cMessage}";

        $result = sendMailSMTP($row['email'], $row['name'], $subjectLine, $htmlBody, $textBody);

        $contactMessage = $result['success']
            ? '<div class="alert alert-success">Thanks, ' . htmlspecialchars($cName) . ' -- your message has been sent. We\'ll get back to you soon.</div>'
            : '<div class="alert alert-danger">Sorry, your message could not be sent right now. Please try again later or email us directly at ' . htmlspecialchars($row['email']) . '.</div>';
    }
}

include __DIR__ . '/header.php';
?>
<main class="main">
      <section class="section">
        <div class="container position-relative">
          <div class="box-cover-contactform">
            <div class="row align-items-center">
              <div class="col-xl-8 col-lg-7">
                <div class="box-contactform-left">
                  <h3 class="color-brand-2 mb-15 wow animate__animated animate__fadeIn">Still have question?</h3>
                  <p class="font-md color-grey-900 mb-50 wow animate__animated animate__fadeIn">Can’t find the answer you are looking for? Please chat to our friendly team.</p>
                  <?= $contactMessage ?>
                  <form method="post" action="contact.php">
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
      <section class="section mt-100">
        <div class="container">
          <h2 class="color-brand-2 mb-20 wow animate__animated animate__fadeIn">We have branches in many<br class="d-none d-lg-block">regions of the world</h2>
          <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 mb-30">
              <p class="font-md color-gray-700 wow animate__animated animate__fadeIn">We has experience in handling the formalities and documentation required for your imports and exports. We work with all international station to guarantee that your load will safely reach without any delays.</p>
            </div>
            <div class="col-lg-6 col-md-6 mb-30 text-md-end text-start"><a class="btn btn-brand-1 hover-up wow animate__animated animate__fadeIn" href="contact.php">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path>
                </svg>Get a quote</a></div>
          </div>
          <?php
          // Branches are admin-configurable in Site Settings -- the primary
          // office (addr/phone/email) is always shown; branches 2-4
          // (addr2/phone2/email2 .. addr4/phone4/email4) only appear once an
          // admin fills them in. Cards share the row's width evenly, so
          // fewer branches span wider instead of leaving empty columns.
          $branches = [
              ['label' => $row['name'], 'addr' => $row['addr'], 'phone' => $row['phone'], 'email' => $row['email']],
          ];
          foreach ([2, 3, 4] as $n) {
              if (!empty($row['addr' . $n]) || !empty($row['phone' . $n]) || !empty($row['email' . $n])) {
                  $branches[] = [
                      'label' => !empty($row['branch' . $n . '_name']) ? $row['branch' . $n . '_name'] : ($row['name'] . ' Branch ' . ($n - 1)),
                      'addr' => $row['addr' . $n],
                      'phone' => $row['phone' . $n],
                      'email' => $row['email' . $n],
                  ];
              }
          }
          $branchColClass = count($branches) === 1 ? 'col-lg-12' : 'col-lg-6';
          ?>
          <div class="row mt-50">
            <?php foreach ($branches as $branch): ?>
                <div class="<?= $branchColClass ?> mb-30">
                  <div class="cardService" style="position:static;">
                    <div class="cardInfo wow animate__animated animate__fadeIn" style="position:static; box-shadow:0 1px 3px rgba(1,9,20,.08); border:1px solid #eee;">
                      <h6 class="color-brand-2 mb-15"><?= htmlspecialchars($branch['label']) ?></h6>
                      <?php if (!empty($branch['addr'])): ?>
                        <p class="font-xs color-grey-900 mb-10"><strong class="color-brand-2">Address:</strong> <?= htmlspecialchars($branch['addr']) ?></p>
                      <?php endif; ?>
                      <?php if (!empty($branch['phone'])): ?>
                        <p class="font-xs color-grey-900 mb-10"><strong class="color-brand-2">Phone Number:</strong> <?= htmlspecialchars($branch['phone']) ?></p>
                      <?php endif; ?>
                      <?php if (!empty($branch['email'])): ?>
                        <p class="font-xs color-grey-900"><strong class="color-brand-2">Email:</strong> <?= htmlspecialchars($branch['email']) ?></p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
      <div class="mt-20"></div>
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
