// function redirect_page() {

// if (isset($_SERVER['HTTPS']) &&
// ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
// isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
// $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
// $protocol = 'https://';
// }
// else {
// $protocol = 'http://';
// }

// $currenturl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// $currenturl_relative = wp_make_link_relative($currenturl);

// switch ($currenturl_relative) {

// case '[/checkout/]':
// $urlto = home_url('[/cart/]');
// break;

// default:
// return;

// }

// if ($currenturl != $urlto)
// exit( wp_redirect( $urlto ) );

// }