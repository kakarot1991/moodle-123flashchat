<?php
 /* This page prints a particular instance of flashchat
 *
 * @author Sander de Boer
 * @version $Id: auth.php,v 1.0 2008/09/01 12:00:00 sdboer Exp $
 * @package flashchat
 **/

    require_once("../../config.php");
    require_once("lib.php");

    $username = required_param('username', PARAM_ALPHANUM);
    $password = required_param('password', PARAM_ALPHANUM);

    $user = get_record('user', 'username', $username);
    if ($user) {
        $check_password = md5(format_string($username) . '_' . format_string($user->password));
	$check_plaintext = md5(format_string($username) . '_' . format_string(md5($password)));
        if ($password == $check_password || $check_plaintext == $check_password) {
	    if (isadmin($user->id)) {
	        echo '5';
	    } else {
                echo '0';
	    }
        } else {
            echo '1';
        }
    } else {
        echo '4';
    }
?>
