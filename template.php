<?php

use QuanDigital\LandingPage\LandingPage;

$lp = new LandingPage(get_the_id());
$lp->getTrackingScript();

$intro = $lp->getIntroduction();
$servicesTop = $lp->getServicesTop();
$servicesBottom = $lp->getServicesBottom();
$callout = $lp->getCallout();

get_header();
?>
    <section class="lp-introduction">
        <div class="contents">
            <h1><?= $intro['headline']; ?></h1>
            <h2><?= $intro['subheading']; ?></h2>
            <p><?= $intro['content']; ?></p>
        </div>
        <form id="contact" data-page="<?= get_permalink(); ?>">
            <input type="text" name="name" placeholder="<?= $lp->getFormPlaceholders()['name']; ?>" required>
            <input type="tel" name="phone" placeholder="<?= $lp->getFormPlaceholders()['phone']; ?>" required>
            <input type="email" name="email" placeholder="<?= $lp->getFormPlaceholders()['email']; ?>" required>
            <input type="text" name="company" placeholder="<?= $lp->getFormPlaceholders()['company']; ?>" required>
            <input type="text" name="website" placeholder="<?= $lp->getFormPlaceholders()['website']; ?>" required>
            <?php wp_nonce_field('submit-lp-form'); ?>
            <button type="submit" class="button submit" id="send"><?= $callout['cta']; ?></button>
        </form>    
    </section>

    <section class="lp-services">
        <div class="contents">
            <h2><?= $servicesTop['headline']; ?></h2>
            <div class="service">
                <h3 data-icon="<?= $lp->convertIcon($servicesTop['icon1']); ?>"><?= $servicesTop['headline1']; ?></h3>
                <p><?= $servicesTop['content1']; ?></p>
            </div>    
            <div class="service">
                <h3 data-icon="<?= $lp->convertIcon($servicesTop['icon2']); ?>"><?= $servicesTop['headline2']; ?></h3>
                <p><?= $servicesTop['content2']; ?></p>
            </div>
            <div class="service">
                <h3 data-icon="<?= $lp->convertIcon($servicesTop['icon3']); ?>"><?= $servicesTop['headline3']; ?></h3>
                <p><?= $servicesTop['content3']; ?></p>
            </div>
        </div>
    </section>

    <section class="lp-services">
        <div class="contents">
            <h2><?= $servicesBottom['headline']; ?></h2>
            <div class="service">
                <h3 data-icon="<?= $lp->convertIcon($servicesBottom['icon1']); ?>"><?= $servicesBottom['headline1']; ?></h3>
                <p><?= $servicesBottom['content1']; ?></p>
            </div>    
            <div class="service">
                <h3 data-icon="<?= $lp->convertIcon($servicesBottom['icon2']); ?>"><?= $servicesBottom['headline2']; ?></h3>
                <p><?= $servicesBottom['content2']; ?></p>
            </div>
            <div class="service">
                <h3 data-icon="<?= $lp->convertIcon($servicesBottom['icon3']); ?>"><?= $servicesBottom['headline3']; ?></h3>
                <p><?= $servicesBottom['content3']; ?></p>
            </div>
        </div>
    </section>

    <section class="lp-callout">
        <div class="text"><?= $callout['text']; ?></div>
        <div class="cta">
            <a href="#contact"><?= $callout['cta']; ?></a>
        </div>
    </section>
<?php
get_footer();