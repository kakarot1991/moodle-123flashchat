<?php
/**
 * This page prints a particular instance of flashchat
 *
 * @author Sander de Boer
 * @version $Id: view.php,v 1.0 2008/09/01 12:00:00 sdboer Exp $
 * @package flashchat
 **/

    require_once("../../config.php");
    require_once("lib.php");

    $id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
    $a  = optional_param('a', 0, PARAM_INT);  // flashchat ID

    if ($id) {
        if (! $cm = get_record("course_modules", "id", $id)) {
            error("Course Module ID was incorrect");
        }

        if (! $course = get_record("course", "id", $cm->course)) {
            error("Course is misconfigured");
        }

        if (! $flashchat = get_record("flashchat", "id", $cm->instance)) {
            error("Course module is incorrect");
        }

    } else {
        if (! $flashchat = get_record("flashchat", "id", $a)) {
            error("Course module is incorrect");
        }
        if (! $course = get_record("course", "id", $flashchat->course)) {
            error("Course is misconfigured");
        }
        if (! $cm = get_coursemodule_from_instance("flashchat", $flashchat->id, $course->id)) {
            error("Course Module ID was incorrect");
        }
    }

    require_login($course->id);

    add_to_log($course->id, "flashchat", "view", "view.php?id=$cm->id", "$flashchat->id");

/// Print the page header
    $strflashchats = get_string("modulenameplural", "flashchat");
    $strflashchat  = get_string("modulename", "flashchat");

    $navlinks = array();
    $navlinks[] = array('name' => $strflashchats, 'link' => "index.php?id=$course->id", 'type' => 'activity');
    $navlinks[] = array('name' => format_string($flashchat->name), 'link' => '', 'type' => 'activityinstance');

    $navigation = build_navigation($navlinks);

    print_header_simple(format_string($flashchat->name), "", $navigation, "", "", true,
                  update_module_button($cm->id, $course->id, $strflashchat), navmenu($course, $cm));

/// Print the main part of the page
if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/mod/flashchat/client')) {

    $password = md5(format_string($USER->username) . '_' . format_string($USER->password)); // we don't want to use the real md5 password
    $init_room = format_string($flashchat->init_room);

    echo "<center> \n";
    echo "<h2>" . format_string($flashchat->name) . "</h2> \n";
    echo "<script langauge=\"javascript\" src=\"client/123flashchat.js\"></script> \n";
    echo "<script language=\"javascript\"> \n";
    echo "  var init_host='" . format_string($flashchat->init_host) . "'; \n";
    echo "  var init_port='" . format_string($flashchat->init_port) . "'; \n";
    if ($flashchat->init_host_s != '') {
      echo "  var init_host_s='" . format_string($flashchat->init_host_s) . "'; \n";
    }
    if ($flashchat->init_port_s != 0) {
      echo "  var init_port_s='" . format_string($flashchat->init_port_s) . "'; \n";
    }
    echo "  var init_group='" . format_string($flashchat->init_group) . "'; \n";
    echo "  var init_user='" . format_string($USER->username) . "'; \n";
    echo "  var init_password='" . $password . "'; \n";
    if ($init_room != '') {
        echo "  var init_room='" . format_string($flashchat->init_room) . "'; \n";
    }
    echo "  openSWF('client/123flashchat.swf','" . format_string($flashchat->width) . "','" .  format_string($flashchat->width) . "'); \n";
    echo "</script> \n";
    echo "</center> \n";
} else {
  echo "<h2>Please install the 123flashclient directory 'client' into " . $_SERVER["DOCUMENT_ROOT"] . "/mod/flashchat/</h2> \n";
}

/// Finish the page
    print_footer($course);
?>
