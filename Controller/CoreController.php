<?php

/**
 * @since 1.0.0
 */

class CoreController
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
        // Parents : Cari Gambo
        add_menu_page(
            'Cari Gambo',
            'Cari Gambo',
            'manage_options',
            'sm-cari-gambo',
            [__CLASS__, 'showMainPage'],
            'dashicons-images-alt'
        );

        // Children Search Images
        add_submenu_page(
            'sm-cari-gambo',
            'Search Images',
            'Search Images',
            'manage_options',
            'sm-cari-gambo-search-images',
            [__CLASS__, 'showSearchImagesPage'],
        );

        // Children : Setting
        add_submenu_page(
            'sm-cari-gambo',
            'Setting',
            'Setting',
            'manage_options',
            'sm-cari-gambo-setting',
            [__CLASS__, 'showSettingPage'],
        );

        // Children About
        add_submenu_page(
            'sm-cari-gambo',
            'About',
            'About',
            'manage_options',
            'sm-cari-gambo-about',
            [__CLASS__, 'showAboutPage'],
        );
    }

    /**
     * Load the Bootstrap CSS & JS within the plugin only
     */
    public static function cariGamboLoadBootstrap()
    {
        $screen = get_current_screen();
        if ($screen->id === 'toplevel_page_sm-cari-gambo' || $screen->id === 'cari-gambo_page_sm-cari-gambo-setting' || $screen->id === 'cari-gambo_page_sm-cari-gambo-search-images' || $screen->id === 'cari-gambo_page_sm-cari-gambo-about') {
            wp_enqueue_style('cari-gambo-bs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', '', false, 'all');
            wp_enqueue_style('cari-gambo-icon', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css', '', false, 'all');
            wp_enqueue_script('cari-gambo-bs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', ['jquery'], false, true);
        }
    }

    /**
     * Load Main Page or Splash Page
     */
    public static function showMainPage()
    {
        $date = date('Y');
        echo "
        <div class='wrap mt-4 alert alert-warning shadow-sm rounded-3'>
        <h4 class='text-dark'> Welcome to Cari Gambo For WordPress</h4>
        <hr>
        <p class='fs-6'>
         Image is a crucial things to do in order to make your website very stunning. Using this plugin, 
         you can download any Royalty-Fee by using <a href='https://unsplash.com'>Unsplash.</a>
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
        <a href='/wp-admin/admin.php?page=sm-cari-gambo-search-images' class='text-decoration-none text-secondary'>
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

    /**
     * Load Setting Page
     */
    public static function showSettingPage()
    {
        if (isset($_POST['unsplash-api'])) {
            $api_key = sanitize_text_field($_POST['unsplash-api']);
            update_option('unsplash_api_key', $api_key);
            echo '<div class="wrap mt-5 alert alert-success"><span>API Key saved successfully.</span></div>';
        }

        $unsplashKey = get_option('unsplash_api_key');

        echo '
        <div class="wrap mt-4 alert alert-warning shadow-sm rounded-3">
            <h4 class="text-dark"> Setting Page </h4>
            <hr>
            <p class="fs-6">
            In order to make this plugin work properly, you need to insert your Unsplash Access Key first
            </p>

            <p class="fs-6">
                If you don\'t know how to get the Key, please refer to this link <a href="https://unsplash.com/developers" target="_blank"> Get Unsplash Access Key. </a>
            </p>
        </div>

        <div class="wrap mt-4">
            <form action="" method="POST" class="form-group">
                <label for="unsplash-api" class="form-label">Your Unsplash API / Access Key</label>
                <input type="text" class="form-control mb-3" name="unsplash-api" value="' . esc_attr($unsplashKey) . '">

                <div class="btn-cta">
                    <button class="btn btn-primary px-4 py-2" type="submit"> Save </button>
                </div>
            </form>
        </div>
    ';
    }

    /**
     * Load Search Image
     */
    public static function showSearchImagesPage()
    {
        $per_page = 28;
        $orientation = 'portrait';
        $unsplashKey = get_option('unsplash_api_key');
        $data = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['keyword'])) {
                $keyword = $_POST['keyword'];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.unsplash.com/search/photos?query=$keyword&client_id=$unsplashKey&per_page=$per_page");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                try {
                    $response = curl_exec($ch);
                    $data = $response;
                } catch (Exception $e) {
                    $error = 'Error fetching data. Please try again or please set your Access Key again.';
                }

                curl_close($ch);
            }
        }

        echo "
    <div class='wrap my-4 alert alert-warning shadow-sm rounded-3'>
        <h4 class='text-dark'> Search Image </h4>
        <hr>
        <p class='fs-6'>
            Type any image keyword in the input form below. Then click enter. Your desired image will appear below.
        </p>

        <form action='' method='POST' class='form-group'>
            <input type='text' class='form-control mb-3' name='keyword'>
        </form>
    </div>

    <div class='imageResults wrap'>
        <div class='row'>
    ";

        if (!empty($error)) {
            echo "<div class='container error-div'>";
            echo "<div class='alert alert-danger'><span>$error</span></div>";
            echo "</div>";
        } elseif (!empty($data)) {
            $result = json_decode($data, true);
            if (isset($result['results']) && is_array($result['results'])) {
                foreach ($result['results'] as $photo) {
                    $imageUrl = $photo['urls']['regular'];
                    echo "<div class='col-3 py-2'>";
                    echo "<img src='$imageUrl' alt='unsepelesh-image' class='rounded-3 shadow-sm' style='width: 100%; height: 100%; object-fit: cover; ' loading='lazy'>";
                    echo "</div>";
                }
            } else {
                $error = 'Error fetching data. Please try again or please set your Access Key again.';
                echo "<div class='container error-div'>";
                echo "<div class='alert alert-danger'><span>$error</span></div>";
                echo "</div>";
            }
        }

        echo "
        </div>
    </div>
    ";
    }



    /**
     * Load About Page
     */
    public static function showAboutPage()
    {
        echo "
        <div class='col-4 mx-auto my-5 alert alert-warning shadow-sm rounded-3'>
        <h4 class='text-dark'> Hi there, Sulaiman here. </h4>
        <hr>
        <p class='fs-6'>
         Thank you for install and using this simple plugin. I hope this plugin do help your development easier.
        </p>

        <p class='fs-6'>
        If you wanted to know about me and what I do, please click at the button below.
        </p>

        <div class=''>
        <a target='_blank' href='https://sulaimanmisri.com' class='text-decoration-none text-secondary'>
            <div class='card border-0 card-body'>
                <p class='fs-5 mb-0'>
                View Portfolio <i class='bi bi-box-arrow-in-up-right'></i>
                </p>
            </div>
        </a>
        </div>

        <div class=''>
        <a target='_blank' href='https://bit.ly/daftar-kelas-design' class='text-decoration-none text-secondary'>
                <div class='card border-0 card-body'>
                <p class='fs-5 mb-0'>
                   Learn With Me <i class='bi bi-box-arrow-in-up-right'></i>
                </p>
                </div>
        </a>
        </div>
        </div>
        ";
    }
}

CoreController::init();
