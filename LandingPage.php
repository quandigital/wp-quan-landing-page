<?php

namespace QuanDigital\LandingPage;

use QuanDigital\WpLib\Helpers;
use Noodlehaus\Config; 

class LandingPage 
{
    private $postId;

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    function cleanTrackingScript()
    {
        add_filter('acf/format_value/name=quan_lp_custom_tracking_code', function($value) {
            if (!is_admin()) {
                $value = preg_replace('%</?(p|br)\s?/?>%', '', $value);
            }
            return $value;
        });
    }

    function getTrackingScript()
    {
        $this->cleanTrackingScript();
        $tracking = get_field('quan_lp_custom_tracking_code');
        \add_action('wp_footer', function() use ($tracking) {
            echo $tracking;
        });
    }

    function getLanguage()
    {
        $langObj = \wp_get_post_terms($this->postId, 'language')[0];
        return $langObj->slug;
    }

    function getIntroduction()
    {
        return [
            'headline' => \get_field('quan_lp_intro_headline', $this->postId),
            'subheading' => \get_field('quan_lp_intro_subheading', $this->postId),
            'content' => \get_field('quan_lp_intro_content', $this->postId),
        ];
    }

    function getFormPlaceholders()
    {
        $placeholders = new Config(__DIR__ . '/config/lang.json');
        return $placeholders->get($this->getLanguage());
    }

    function getServicesTop()
    {
        return [
            'headline' => \get_field('quan_lp_services_top_headline', $this->postId),
            'icon1' => \get_field('quan_lp_services_top_icon_1', $this->postId),
            'icon2' => \get_field('quan_lp_services_top_icon_2', $this->postId),
            'icon3' => \get_field('quan_lp_services_top_icon_3', $this->postId),
            'headline1' => \get_field('quan_lp_services_top_headline_1', $this->postId),
            'headline2' => \get_field('quan_lp_services_top_headline_2', $this->postId),
            'headline3' => \get_field('quan_lp_services_top_headline_3', $this->postId),
            'content1' => \get_field('quan_lp_services_top_content_1', $this->postId),
            'content2' => \get_field('quan_lp_services_top_content_2', $this->postId),
            'content3' => \get_field('quan_lp_services_top_content_3', $this->postId),
        ];   
    }

    function getServicesBottom()
    {
        return [
            'headline' => \get_field('quan_lp_services_bottom_headline', $this->postId),
            'icon1' => \get_field('quan_lp_services_bottom_icon_1', $this->postId),
            'icon2' => \get_field('quan_lp_services_bottom_icon_2', $this->postId),
            'icon3' => \get_field('quan_lp_services_bottom_icon_3', $this->postId),
            'headline1' => \get_field('quan_lp_services_bottom_headline_1', $this->postId),
            'headline2' => \get_field('quan_lp_services_bottom_headline_2', $this->postId),
            'headline3' => \get_field('quan_lp_services_bottom_headline_3', $this->postId),
            'content1' => \get_field('quan_lp_services_bottom_content_1', $this->postId),
            'content2' => \get_field('quan_lp_services_bottom_content_2', $this->postId),
            'content3' => \get_field('quan_lp_services_bottom_content_3', $this->postId),
        ];       
    }

    function getCallout()
    {
        return [
            'text' => \get_field('quan_lp_callout_text', $this->postId),
            'cta' => \get_field('quan_lp_callout_cta', $this->postId),
        ];
    }

    public function convertIcon($icon)
    {
        $icons = new Config(__DIR__ . '/config/icons.json');
        return '&#' . hexdec('f' . $icons->get($icon)) . ';';
    }

    public function submitForm()
    {
        if (\wp_verify_nonce($_POST['security'], 'submit-lp-form')) {
            echo wp_mail( 
                \get_field('quan_lp_form_email', $this->postId), 
                'New Message from ' . $this->processFormFields($_POST)['name'], 
                $this->buildMessageBody($_POST),
                ['Content-Type: text/html; charset=UTF-8']
            );
            wp_die();
        }
    }

    private function processFormFields($post)
    {
        return [
            'email' => isset($post['email']) ? filter_var($post['email'], FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL) : 'false',
            'phone' => isset($post['phone']) ? filter_var($post['phone'], FILTER_SANITIZE_NUMBER_INT) : 'false',
            'name' => isset($post['name']) ? filter_var($post['name'], FILTER_SANITIZE_STRING) : 'false',
            'company' => isset($post['company']) ? filter_var($post['company'], FILTER_SANITIZE_STRING) : 'false',
            'website' => isset($post['website']) ? filter_var($post['website'], FILTER_SANITIZE_STRING) : 'false',
            'url' => isset($post['url']) ? filter_var($post['url'], FILTER_SANITIZE_STRING) : 'false',
        ];
    }

    private function buildMessageBody($post)
    {
        $fields = $this->processFormFields($post);
        return sprintf('<div class="emailbody"><table><tr><td>Name:</td><td>%s</td></tr><tr><td>Email:</td><td>%s</td></tr><tr><td>Phone:</td><td>%s</td></tr><tr><td>Company:</td><td>%s</td></tr><tr><td>Website:</td><td>%s</td></tr><tr><td>Sent from:</td><td>%s</td></tr></table></div>', $fields['name'], $fields['email'], $fields['phone'], $fields['company'], $fields['website'], $fields['url']);
    }
}
