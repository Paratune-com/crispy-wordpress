<?php
/**
 * Rewrites hardcoded production URLs in final HTML for local dev.
 *
 * Elementor and post content often store absolute https://crispychicken.rest/… in `src`
 * while WordPress regenerates `srcset` from the current site URL, so images break locally.
 *
 * Active only when CRISPY_LOCAL_REWRITE_PRODUCTION_DOMAIN is true (see wp-config-local.php).
 */
if ( ! defined( 'CRISPY_LOCAL_REWRITE_PRODUCTION_DOMAIN' ) || ! CRISPY_LOCAL_REWRITE_PRODUCTION_DOMAIN ) {
	return;
}

add_action(
	'template_redirect',
	static function () {
		if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return;
		}
		if ( function_exists( 'wp_is_json_request' ) && wp_is_json_request() ) {
			return;
		}

		$local = untrailingslashit( home_url() );
		$host  = wp_parse_url( $local, PHP_URL_HOST );
		$port  = wp_parse_url( $local, PHP_URL_PORT );
		$local_pr = '//' . $host . ( $port ? ':' . $port : '' );

		ob_start(
			static function ( $html ) use ( $local, $local_pr ) {
				return str_replace(
					array(
						'https://crispychicken.rest',
						'http://crispychicken.rest',
						'//crispychicken.rest',
					),
					array( $local, $local, $local_pr ),
					$html
				);
			}
		);
	},
	-9999
);
