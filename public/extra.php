<?php

function allmethod() {
	echo 'icon';
}

if ( ! isset( $_POST ) || ! isset( $_POST['security'] ) ) {
	wp_send_json_error( 'Invalid data / security token sent.' );
	wp_die();
} else {

}
