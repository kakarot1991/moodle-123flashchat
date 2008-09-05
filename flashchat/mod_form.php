<?php
/**
 * This file defines de main flashchat configuration form
 * It uses the standard core Moodle (>1.8) formslib. For
 * more info about them, please visit:
 * 
 * http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * The form must provide support for, at least these fields:
 *   - name: text element of 64cc max
 *
 * Also, it's usual to use these fields:
 *   - intro: one htmlarea element to describe the activity
 *            (will be showed in the list of activities of
 *             flashchat type (index.php) and in the header 
 *             of the flashchat main page (view.php).
 *   - introformat: The format used to write the contents
 *             of the intro field. It automatically defaults 
 *             to HTML when the htmleditor is used and can be
 *             manually selected if the htmleditor is not used
 *             (standard formats are: MOODLE, HTML, PLAIN, MARKDOWN)
 *             See lib/weblib.php Constants and the format_text()
 *             function for more info
 */

require_once ('moodleform_mod.php');

class mod_flashchat_mod_form extends moodleform_mod {

	function definition() {

		global $COURSE, $CFG;;
		$mform    =& $this->_form;

//-------------------------------------------------------------------------------
    /// Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));
    /// Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('name', 'flashchat'), array('size'=>'64'));
		$mform->setType('name', PARAM_TEXT);
		$mform->addRule('name', null, 'required', null, 'client');
    /// Adding the optional "intro" and "introformat" pair of fields
    	$mform->addElement('htmleditor', 'intro', get_string('intro', 'flashchat'));
		$mform->setType('intro', PARAM_RAW);

//-------------------------------------------------------------------------------
    /// Adding the rest of flashchat settings, spreeading all them into this fieldset
    /// or adding more fieldsets ('header' elements) if needed for better logic
        $mform->addElement('header', 'flashchatfieldset', get_string('flashchatfieldset', 'flashchat'));
        $mform->addElement('text', 'init_host', get_string('init_host', 'flashchat'), array('size'=>'64'));
                $mform->setType('init_host', PARAM_TEXT);
                $mform->addRule('init_host', null, 'required', null, 'client');

        $mform->addElement('text', 'init_port', get_string('init_port', 'flashchat'), 'maxlength="5" size="5"');
                $mform->setType('init_port', PARAM_INT);
                $mform->addRule('init_port', null, 'required', null, 'client');

        $mform->addElement('text', 'init_host_s', get_string('init_host_s', 'flashchat'), array('size'=>'64'));
                $mform->setType('init_host_s', PARAM_TEXT);

        $mform->addElement('text', 'init_port_s', get_string('init_port_s', 'flashchat'), 'maxlength="5" size="5"');
                $mform->setType('init_port_s', PARAM_INT);

	$mform->addElement('text', 'init_group', get_string('init_group', 'flashchat'), array('size'=>'64'));
                $mform->setType('init_group', PARAM_TEXT);
		$mform->addRule('init_group', null, 'required', null, 'client');

        $mform->addElement('text', 'init_room', get_string('init_room', 'flashchat'), array('size'=>'64'));
                $mform->setType('init_room', PARAM_TEXT);

        $mform->addElement('text', 'width', get_string('width', 'flashchat'), 'maxlength="5" size="5"');
                $mform->setType('width', PARAM_INT);
		$mform->setDefault('width', '634');
                $mform->addRule('width', null, 'numeric', null, 'client');

        $mform->addElement('text', 'height', get_string('height', 'flashchat'), 'maxlength="5" size="5"');
                $mform->setType('height', PARAM_INT);
		$mform->setDefault('height', '476');
                $mform->addRule('height', null, 'numeric', null, 'client');

        $mform->addElement('static', 'auth-url', get_string('auth-url', 'flashchat'), $CFG->wwwroot . '/mod/flashchat/auth.php?username=%username%&amp;amp;password=%password%');

//-------------------------------------------------------------------------------
        // add standard elements, common to all modules
		$this->standard_coursemodule_elements();
//-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();

	}
}

?>
