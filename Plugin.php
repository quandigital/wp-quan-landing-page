<?php

namespace QuanDigital\LandingPage;

use QuanDigital\WpLib\Boilerplate;
use QuanDigital\WpLib\CreateCpt;
use Noodlehaus\Config;

class Plugin extends Boilerplate
{
    protected $postType = 'landing-page';

    public function __construct($file)
    {
        parent::__construct($file);

        $this->createCpt();
        \add_action('init', [$this, 'registerLanguageTaxonomy'], 20);
        \add_action('init', [$this, 'addRewriteRules']);
        \add_filter('post_type_link', [$this, 'filterPostLink'], 10, 2);
        \add_filter('single_template', [$this, 'registerTemplate']);

        \add_action('wp_enqueue_scripts', [$this, 'registerSubmitScript']);
        \add_action('wp_ajax_submitLp', [$this, 'registerAjax']);
        // \add_action('wp_ajax_submitLp', [new LandingPage(\get_the_id()), 'submitForm']);
    }

    public function createCpt()
    {
        new CreateCpt($this->postType, 'Landing Page', 'Landing Pages', false, ['menu_position' => 20, 'supports' => ['title', 'author', 'revisions',],]);
    }

    public function registerTemplate($template)
    {
        if (\get_post_type(\get_the_id()) === $this->postType) {
            $template = __DIR__ . '/template.php';
        }

        return $template;
    }

    public function addRewriteRules()
    {
        $query = new \WP_Query(['post_type' => $this->postType, 'posts_per_page' => -1]);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                if ($query->post->post_type == $this->postType) {
                    \add_rewrite_rule('(.*?)$', 'index.php?' . $query->post->post_type . '=$matches[1]', 'top');
                }
            }
        }
    }
    
    public function filterPostLink($post_link, $post)
    {
        if ($post->post_type === $this->postType && $post->post_status === 'publish') {
            $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
        }
     
        return $post_link;   
    }

    public function registerLanguageTaxonomy()
    {
        \register_taxonomy_for_object_type('language', $this->postType);
    }

    public function registerSubmitScript()
    {
        if (\get_post_type(\get_the_id()) === 'landing-page') {
            $thankYou = new Config(__DIR__ . '/config/lang.json');
            wp_enqueue_script('landing-page', \plugin_dir_url(__FILE__) . 'landing-page.js', array('jquery', 'functions'), '', true);
            wp_localize_script('landing-page', 'thankYou', $thankYou->get((new LandingPage(\get_the_id()))->getLanguage(). '.thankyou'));
        }
    }

    public function registerAjax()
    {
        (new LandingPage(\get_the_id()))->submitForm();
    }
}
