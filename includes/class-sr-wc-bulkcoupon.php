<?php


if ( !class_exists( 'SR_WC_BulkCoupons' ) ) {
    final class SR_WC_BulkCoupons
    {

        use SRWCBulkTrait;

        private static $instance;


        public static function instance() {
            if ( ! isset( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }


        public function run()
        {

            $this->init();
            // Check if WooCommerce is available and active
            if (!$this->checkForWooCommerce()) {
                add_action( 'admin_notices', 'checkForWooCommerce_show_notice' );
            }

        }


        protected function init()
        {
            add_action( 'admin_enqueue_scripts', function() {
                $screen = get_current_screen();

                add_action( 'admin_notices', function () use ($screen) {
                    echo '<div class="error">';
                    echo ($screen->id);
                    echo '</div>';
                } );


            });
        }


    }
}
