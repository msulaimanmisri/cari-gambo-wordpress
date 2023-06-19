<?php

/**
 * @since 1.0.0
 */

class InstallController
{
    public static function init()
    {
        add_action('admin_menu', [__CLASS__, 'cariGamboMenuDetails']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'cariGamboLoadBootstrap']);
    }

    /**
     * Admin Dashboard Details.
     * This will show at the admin sidebar dashboard
     */
    public static function cariGamboMenuDetails()
    {
        add_menu_page(
            'Cari Gambo',
            'Cari Gambo',
            'manage_options',
            'sm-cari-gambo',
            [__CLASS__, 'showMainPage'],
            'dashicons-images-alt'
        );

        add_submenu_page(
            'sm-cari-gambo',
            'Setting',
            'Setting',
            'manage_options',
            'sm-cari-gambo-setting',
            [__CLASS__, 'showSettingPage'],
        );

        add_submenu_page(
            'sm-cari-gambo',
            'Search Images',
            'Search Images',
            'manage_options',
            'sm-cari-gambo-search-images',
            [__CLASS__, 'showSearchImagesPage'],
        );
    }

    /**
     * Load the Bootstrap CSS & JS within the plugin only
     */
    public static function cariGamboLoadBootstrap($page)
    {
        $screen = get_current_screen();
        if ($screen && $screen->id === 'toplevel_page_sm-cari-gambo' || $screen && $screen->id === 'cari-gambo_page_sm-cari-gambo-setting') {
            wp_enqueue_style('cari-gambo-bs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', '', false, 'all');
            wp_enqueue_style('cari-gambo-icon', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css', '', false, 'all');
            wp_enqueue_script('cari-gambo-bs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', ['jquery'], false, true);
        }
    }

    public static function showMainPage()
    {
        $date = date('Y');
        echo "
        <div class='wrap mt-4 alert alert-warning shadow-sm rounded-3'>
        <h4 class='text-dark'> Welcome to Cari Gambo WordPress</h4>
        <hr>
        <p class='fs-6'>
            This plugin is a time-saver for your development work. Because you can search for any Royalty-Free images from the <a href='https://unsplash.com' target='_blank'>Unsplash Platform</a> .
        </p>

        <p class='fs-6'>
        Lets get started. Choose the menu below.
        </p>

        <div class='row'>
        <div class='col-3'>
        <a href='/wp-admin/admin.php?page=sm-cari-gambo-setting' class='text-decoration-none text-secondary'>
            <div class='card border-0 card-body'>
                <p class='fs-5 mb-0'>
                Set Access Key <i class='bi bi-box-arrow-in-up-right'></i>
                </p>
            </div>
        </a>
        </div>

        <div class='col-3'>
        <a href='' class='text-decoration-none text-secondary'>
                <div class='card border-0 card-body'>
                <p class='fs-5 mb-0'>
                    Search Images <i class='bi bi-box-arrow-in-up-right'></i>
                </p>
                </div>
        </a>
        </div>
        </div>
        </div>

        <div class='footer text-center text-secondary'>
        <p class='font-text'>Develop by Sulaiman Misri. $date. Kuala Lumpur, Malaysia</p>
        </div>
        ";
    }

    public static function showSettingPage()
    {
        echo "
        <div class='wrap mt-4 alert alert-warning shadow-sm rounded-3'>
        <h4 class='text-dark'> Setting Page </h4>
        <hr>
        <p class='fs-6'>
           In order to make this plugin work properly, you need to insert your Unsplash Access Key first
        </p>

        <p class='fs-6'>
            If you don't know how to get the Key, please refer to this link <a href='https://unsplash.com/developers' target='_blank'> Get Unsplash Access Key. </a>
        </p>
        ";
    }
}

InstallController::init();
