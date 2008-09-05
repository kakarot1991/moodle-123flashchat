<?php
/**
 * This page prints a particular instance of flashchat
 *
 * @author Sander de Boer
 * @version $Id: index.php,v 1.0 2008/09/01 12:00:00 sdboer Exp $
 * @package flashchat
 **/

    require_once("../../config.php");
    require_once("lib.php");

    $id = required_param('id', PARAM_INT);   // course

    if (! $course = get_record("course", "id", $id)) {
        error("Course ID is incorrect");
    }

    require_login($course->id);

    add_to_log($course->id, "flashchat", "view all", "index.php?id=$course->id", "");


/// Get all required stringsflashchat

    $strflashchats = get_string("modulenameplural", "flashchat");
    $strflashchat  = get_string("modulename", "flashchat");


/// Print the header

    $navlinks = array();
    $navlinks[] = array('name' => $strflashchats, 'link' => '', 'type' => 'activity');
    $navigation = build_navigation($navlinks);

    print_header_simple("$strflashchats", "", $navigation, "", "", true, "", navmenu($course));

/// Get all the appropriate data

    if (! $flashchats = get_all_instances_in_course("flashchat", $course)) {
        notice("There are no flashchats", "../../course/view.php?id=$course->id");
        die;
    }

/// Print the list of instances (your module will probably extend this)

    $timenow = time();
    $strname  = get_string("name");
    $strweek  = get_string("week");
    $strtopic  = get_string("topic");

    if ($course->format == "weeks") {
        $table->head  = array ($strweek, $strname);
        $table->align = array ("center", "left");
    } else if ($course->format == "topics") {
        $table->head  = array ($strtopic, $strname);
        $table->align = array ("center", "left", "left", "left");
    } else {
        $table->head  = array ($strname);
        $table->align = array ("left", "left", "left");
    }

    foreach ($flashchats as $flashchat) {
        if (!$flashchat->visible) {
            //Show dimmed if the mod is hidden
            $link = "<a class=\"dimmed\" href=\"view.php?id=$flashchat->coursemodule\">$flashchat->name</a>";
        } else {
            //Show normal if the mod is visible
            $link = "<a href=\"view.php?id=$flashchat->coursemodule\">$flashchat->name</a>";
        }

        if ($course->format == "weeks" or $course->format == "topics") {
            $table->data[] = array ($flashchat->section, $link);
        } else {
            $table->data[] = array ($link);
        }
    }

    echo "<br />";

    print_table($table);

/// Finish the page

    print_footer($course);

?>
