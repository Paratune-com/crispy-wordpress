<?php
/**
 * Router for PHP built-in server: php -S 127.0.0.1:8888 local-router.php
 *
 * Decodes percent-encoded paths so uploads with Unicode names (e.g. en-dash in "Artboard-–-3.png")
 * resolve to real files; otherwise is_file() fails and WordPress returns 404.
 */
$uri_path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
if ( ! is_string( $uri_path ) || $uri_path === '' ) {
	require __DIR__ . '/index.php';
	return;
}

$uri_path = rawurldecode( $uri_path );

if ( str_contains( $uri_path, "\0" ) || str_contains( $uri_path, '..' ) ) {
	require __DIR__ . '/index.php';
	return;
}

$doc_root = realpath( __DIR__ );
if ( ! $doc_root ) {
	require __DIR__ . '/index.php';
	return;
}

$full = realpath( $doc_root . $uri_path );
if ( $full && str_starts_with( $full, $doc_root . DIRECTORY_SEPARATOR ) && is_file( $full ) ) {
	return false;
}

require __DIR__ . '/index.php';
