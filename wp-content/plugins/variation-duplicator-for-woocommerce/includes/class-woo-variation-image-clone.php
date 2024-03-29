<?php

defined( 'ABSPATH' ) or die( 'Keep Silent' );

if ( ! class_exists( 'Woo_Variation_Image_Clone' ) ):

	class Woo_Variation_Image_Clone {

		public static function init() {
			add_action( 'woocommerce_product_after_variable_attributes', array( __CLASS__, 'form' ), 10, 3 );
			add_action( 'woocommerce_save_product_variation', array( __CLASS__, 'prepare' ) );
			add_action( 'woo_variation_duplicator_load_variations', array( __CLASS__, 'notice' ) );
		}

		public static function form( $loop, $variation_data, $variation ) {
			$variation_id = absint( $variation->ID );
			$parent_id    = wp_get_post_parent_id( $variation_id );
			$product      = wc_get_product( $parent_id );
			$child_ids    = $product->get_children();
			$child_ids    = array_diff( $child_ids, [ $variation_id ] );
			$image_id     = isset( $variation_data['_thumbnail_id'] ) ? $variation_data['_thumbnail_id'] : 0;


			$selected_variation          = wc_get_product_object( 'variation', $variation_id );
			$selected_variation_image_id = absint( $selected_variation->get_image_id() );

			include 'html-variation-duplicator-form.php';
		}

		public static function notice() {
			$results = get_transient( 'woo_variation_duplicator_image_cloned' );

			if ( $results ) {
				printf( '<div class="inline notice variation-duplicator-for-woocommerce-notice"><p>%s</p></div>', esc_html__( 'Variation image cloned.', 'variation-duplicator-for-woocommerce' ) );
				delete_transient( 'woo_variation_duplicator_image_cloned' );
			}
		}

		public static function prepare( $variation_id ) {

			if ( ! isset( $_POST['variable_image_duplicate_type'] ) ) {
				return;
			}

			$current_variation     = $variation = wc_get_product_object( 'variation', $variation_id );
			$variation_data        = $variation->get_data();
			$parent_product_id     = $variation->get_parent_id();
			$current_variation_img = absint( $variation_data['image_id'] );
			// $current_variation_img = $current_variation_img > 0 ? $current_variation_img : absint( $current_variation->get_image_id() );

			$clone_type = sanitize_text_field( $_POST['variable_image_duplicate_type'][ $variation_id ] );
			// var_dump($_POST['variable_image_duplicate_type']);
			// To Post Data
			$variable_image_to_post_data = ( isset( $_POST['variable_image_duplicate_to'] ) && isset( $_POST['variable_image_duplicate_to'][ $variation_id ] ) && is_array( $_POST['variable_image_duplicate_to'][ $variation_id ] ) ) ? $_POST['variable_image_duplicate_to'][ $variation_id ] : [];
			$variation_img_to            = array_map( 'absint', $variable_image_to_post_data );

			// From Post Data
			$variable_image_from_post_data = ( isset( $_POST['variable_image_duplicate_from'] ) && isset( $_POST['variable_image_duplicate_from'][ $variation_id ] ) && ! empty( $_POST['variable_image_duplicate_from'][ $variation_id ] ) ) ? $_POST['variable_image_duplicate_from'][ $variation_id ] : 0;
			$variation_img_from            = absint( $variable_image_from_post_data );

			do_action( 'woo_variation_duplicator_prepare', $current_variation, $clone_type, $variation_img_to, $variation_img_from );

			// Set (this) variation image to given variations
			$is_cloned = false;
			if ( 'to' === $clone_type && ! empty( $variation_img_to ) ) {
				foreach ( $variation_img_to as $id ) {

					$selected_variation      = wc_get_product_object( 'variation', $id );
					$selected_variation_data = $selected_variation->get_data();
					$selected_variation_img  = absint( $selected_variation_data['image_id'] );

					if ( empty( $current_variation_img ) || $current_variation_img == $selected_variation_img ) {
						continue;
					}

					$is_cloned = true;

					self::save( $selected_variation, $current_variation_img, $current_variation );
					do_action( 'woo_variation_duplicator_image_saved_to', $selected_variation, $current_variation, $current_variation_img );
				}

				if ( $is_cloned ) {
					set_transient( 'woo_variation_duplicator_image_cloned', 'yes' );
				}
			}

			// Set (this) variation image from given variation or product featured image
			if ( 'from' === $clone_type && ! empty( $variation_img_from ) ) {

				// VARIATION PRODUCT
				if ( 'product_variation' == get_post_type( $variation_img_from ) ) {
					$selected_variation      = wc_get_product_object( 'variation', $variation_img_from );
					$selected_variation_data = $selected_variation->get_data();
					$selected_variation_img  = absint( $selected_variation_data['image_id'] );
					$selected_variation_img  = ( ( $selected_variation_img > 0 ) ? $selected_variation_img : absint( $selected_variation->get_image_id() ) );
				} else {
					$selected_variation     = wc_get_product_object( 'variable', $variation_img_from );
					$selected_variation_img = absint( $selected_variation->get_image_id() );
				}

				if ( empty( $selected_variation_img ) || $current_variation_img == $selected_variation_img ) {
					return;
				}

				self::save( $current_variation, $selected_variation_img, $selected_variation );

				do_action( 'woo_variation_duplicator_image_saved_from', $current_variation, $selected_variation, $selected_variation_img );

				set_transient( 'woo_variation_duplicator_image_cloned', 'yes' );
			}
		}

		public static function save( $variation, $image_id, $selected_variation ) {

			if ( ! is_ajax() ) {
				return;
			}

			$variation->set_props(
				array(
					'image_id' => apply_filters( 'woo_variation_duplicator_image_id', $image_id, $variation, $selected_variation ),
				)
			);

			$variation->save();
		}
	}

	Woo_Variation_Image_Clone::init();
endif;