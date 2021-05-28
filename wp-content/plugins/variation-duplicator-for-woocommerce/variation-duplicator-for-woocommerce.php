<?php
/**
 * Plugin Name: Duplicate Variations for WooCommerce
 * Plugin URI: https://wordpress.org/plugins/variation-duplicator-for-woocommerce/
 * Description: Duplicate WooCommerce variable product variations with its all available properties including Variation Price, Variation Image, and SKU in just a single click.
 * Author: Emran Ahmed
 * Domain Path: /languages
 * Version: 1.0.4
 * Requires at least: 5.2
 * Tested up to: 5.7
 * Requires PHP: 7.0
 * WC requires at least: 4.5
 * WC tested up to: 5.2
 * Text Domain: variation-duplicator-for-woocommerce
 * Author URI: https://getwooplugins.com/
 */

defined( 'ABSPATH' ) or die( 'Keep Silent' );

if ( ! class_exists( 'Variation_Duplicator_For_Woocommerce' ) ):

	class Variation_Duplicator_For_Woocommerce {

		protected $_version = '1.0.4';

		protected static $_instance = null;

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function __construct() {
			$this->constants();
			$this->language();
			$this->includes();
			$this->hooks();
			do_action( 'woo_variation_duplicator_loaded', $this );
		}

		public function hooks() {

			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
			if ( $this->is_wc_active() ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			}
		}

		public function plugin_row_meta( $links, $file ) {
			if ( $file === $this->basename() ) {

				$report_url = esc_url( 'https://getwooplugins.com/tickets/' );

				$documentation_url = esc_url( 'https://getwooplugins.com/documentation/variation-duplicator-for-woocommerce/' );

				$row_meta['documentation'] = '<a target="_blank" href="' . esc_url( $documentation_url ) . '" title="' . esc_attr( esc_html__( 'Read Documentation', 'variation-duplicator-for-woocommerce' ) ) . '">' . esc_html__( 'Read Documentation', 'variation-duplicator-for-woocommerce' ) . '</a>';
				$row_meta['issues']        = sprintf( '%2$s <a target="_blank" href="%1$s">%3$s</a>', esc_url( $report_url ), esc_html__( 'Facing issue?', 'variation-duplicator-for-woocommerce' ), '<span style="color: red">' . esc_html__( 'Please open a ticket.', 'variation-duplicator-for-woocommerce' ) . '</span>' );

				return array_merge( $links, $row_meta );
			}

			return (array) $links;
		}

		public function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		public function constants() {
			$this->define( 'WOO_VD_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
			$this->define( 'WOO_VD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'WOO_VD_VERSION', $this->version() );
			$this->define( 'WOO_VD_PLUGIN_INCLUDE_PATH', trailingslashit( plugin_dir_path( __FILE__ ) . 'includes' ) );
			$this->define( 'WOO_VD_PLUGIN_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
			$this->define( 'WOO_VD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'WOO_VD_PLUGIN_FILE', __FILE__ );
			$this->define( 'WOO_VD_IMAGES_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'images' ) );
			$this->define( 'WOO_VD_ASSETS_URI', trailingslashit( plugin_dir_url( __FILE__ ) . 'assets' ) );
		}

		public function includes() {
			if ( $this->is_wc_active() ) {
				require_once $this->include_path( 'class-woo-variation-image-clone.php' );
				require_once $this->include_path( 'class-woo-variation-clone.php' );
			}
		}

		public function language() {
			load_plugin_textdomain( 'variation-duplicator-for-woocommerce', false, trailingslashit( $this->basename() ) . 'languages' );
		}

		public function include_path( $file ) {
			$file = ltrim( $file, '/' );

			return WOO_VD_PLUGIN_INCLUDE_PATH . $file;
		}

		public function is_wc_active() {
			return class_exists( 'WooCommerce' );
		}

		public function basename() {
			return WOO_VD_PLUGIN_BASENAME;
		}

		public function get_theme_name() {
			return wp_get_theme()->get( 'Name' );
		}

		public function get_theme_dir() {
			return strtolower( basename( get_template_directory() ) );
		}

		public function get_parent_theme_name() {
			return wp_get_theme( get_template() )->get( 'Name' );
		}

		public function get_parent_theme_dir() {
			return strtolower( basename( get_stylesheet_directory() ) );
		}

		public function get_theme_version() {
			return wp_get_theme()->get( 'Version' );
		}

		public function dirname() {
			return WOO_VD_PLUGIN_DIRNAME;
		}

		public function version() {
			return esc_attr( $this->_version );
		}

		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		public function plugin_uri() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		public function images_uri( $file ) {
			$file = ltrim( $file, '/' );

			return WOO_VD_IMAGES_URI . $file;
		}

		public function assets_uri( $file ) {
			$file = ltrim( $file, '/' );

			return WOO_VD_ASSETS_URI . $file;
		}

		public function admin_enqueue_scripts() {

			$screen    = get_current_screen();
			$screen_id = $screen ? $screen->id : '';
			$suffix    = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			if ( in_array( $screen_id, array( 'product' ) ) ) {

				wp_enqueue_style( 'variation-duplicator-for-woocommerce', esc_url( $this->assets_uri( "/css/variation-duplicator-for-woocommerce{$suffix}.css" ) ), false, $this->version() );

				wp_enqueue_script( 'variation-duplicator-for-woocommerce', esc_url( $this->assets_uri( "/js/variation-duplicator-for-woocommerce{$suffix}.js" ) ), array(
					'jquery',
					'wp-util'
				), $this->version(), true );

				$clone_limit = absint( apply_filters( 'woo_variation_duplicator_clone_limit', 9 ) );
				$translation = array(
					'limitText' => sprintf( esc_html__( "Set how many times each variation should clone. \nDefault value is 1. Limit is %d.", 'variation-duplicator-for-woocommerce' ), $clone_limit ),
					'limit'     => $clone_limit,
				);

				wp_localize_script( 'variation-duplicator-for-woocommerce', 'WooVariationDuplicator', $translation );
			}
		}
	}

	function variation_duplicator_for_woocommerce() {
		return Variation_Duplicator_For_Woocommerce::instance();
	}

	add_action( 'woocommerce_init', 'variation_duplicator_for_woocommerce' );

endif;