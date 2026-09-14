<?php include 'header.php'; ?>

<section class="page-title wrapper clearfix" style="background-image: url(themes/theme1/images/about-page-bg.jpg);">
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
                        <h4 class="single_title">OUR GLOBAL NETWORK</h4>

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
                            <?php if (!empty($row['phone'])): ?>
                            <p class="pb-4"><strong><i class="fa fa-phone"></i></a></li></strong> :
                                <?php echo $row['phone']; ?> </p>
                            <?php endif; ?>
                            <?php if (!empty($row['email'])): ?>
                            <p class="pb-4"><strong><i class="fa fa-envelope"></i></a></li></strong> :
                                <?php echo $row['email']; ?></p>
                            <?php endif; ?>
                            <?php if (!empty($row['addr'])): ?>
                            <p class="pb-4"><strong><i class="fa fa-map-marker"></i></a></li></strong> :
                                <?php echo $row['addr']; ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($row['phone2']) || !empty($row['email2']) || !empty($row['addr2'])): ?>
                        <div class="address wow fadeInLeft" data-wow-delay="0.3s">
                            <h4 class="title"><?php echo !empty($row['branch2_name']) ? htmlspecialchars($row['branch2_name']) : 'BRANCH Address'; ?></h4>

                            <?php if (!empty($row['phone2'])): ?>
                            <p class="pb-4">
                                <strong><i class="fa fa-phone"></i></strong> :
                                <?php echo htmlspecialchars($row['phone2']); ?>
                            </p>
                            <?php endif; ?>

                            <?php if (!empty($row['email2'])): ?>
                            <p class="pb-4"><i class="fa fa-envelope"></i> :
                                <?php echo htmlspecialchars($row['email2']); ?>
                            </p>
                            <?php endif; ?>

                            <?php if (!empty($row['addr2'])): ?>
                            <p class="pb-4"><strong><i class="fa fa-map-marker"></i></strong> :
                                <?php echo htmlspecialchars($row['addr2']); ?>
                            </p>
                            <?php endif; ?>

                        </div>
                        <?php endif; ?>

                        <?php foreach ([3, 4] as $n): ?>
                        <?php if (!empty($row['phone' . $n]) || !empty($row['email' . $n]) || !empty($row['addr' . $n])): ?>
                        <div class="address wow fadeInLeft" data-wow-delay="0.3s">
                            <h4 class="title"><?php echo !empty($row['branch' . $n . '_name']) ? htmlspecialchars($row['branch' . $n . '_name']) : 'BRANCH Address'; ?></h4>

                            <?php if (!empty($row['phone' . $n])): ?>
                            <p class="pb-4">
                                <strong><i class="fa fa-phone"></i></strong> :
                                <?php echo htmlspecialchars($row['phone' . $n]); ?>
                            </p>
                            <?php endif; ?>

                            <?php if (!empty($row['email' . $n])): ?>
                            <p class="pb-4"><i class="fa fa-envelope"></i> :
                                <?php echo htmlspecialchars($row['email' . $n]); ?>
                            </p>
                            <?php endif; ?>

                            <?php if (!empty($row['addr' . $n])): ?>
                            <p class="pb-4"><strong><i class="fa fa-map-marker"></i></strong> :
                                <?php echo htmlspecialchars($row['addr' . $n]); ?>
                            </p>
                            <?php endif; ?>

                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                    <div class="contact-form col-md-8">
                        <form method="post" action="contacts.php#send" class="row">
                            <input type="hidden" name="adminmail" id="adminmail" value="<?php echo $row['email']; ?>">
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