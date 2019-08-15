<?php
/**
*
* @package phpBB Extension - CopyPaste
* @copyright (c) 2015 saturn-z
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace saturnZ\CopyPaste\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
/**
* Assign functions defined in this class to event listeners in the core
*
* @return array
* @static
* @access public
*/
	static public function getSubscribedEvents()
	{
		return array(
            'core.user_setup'                        => 'load_language_on_setup',
			'core.posting_modify_message_text'		=> 'posting_modify_message_text',
		);
	}

    public function load_language_on_setup($event)
    {
        $lang_set_ext = $event['lang_set_ext'];
        $lang_set_ext[] = array(
            'ext_name' => 'saturnZ/CopyPaste',
            'lang_set' => 'copypaste_lng',
        );
        $event['lang_set_ext'] = $lang_set_ext;
    }

	public function posting_modify_message_text($event)
	{
		global $user;
		$event['message_parser']->message = preg_replace('/' . $user->lang['COPYRIGHT_NAME'] . $user->lang['COLON'] . ' ' . preg_quote(generate_board_url(), '/') . '\S*(\s|$)/', '', $event['message_parser']->message);
	}

	/** @var \phpbb	emplate	emplate */
	protected $template;

	//** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/**
	* Constructor
	*/
	public function __construct($phpbb_root_path, \phpbb\template\template $template)
	{
		$this->phpbb_root_path = $phpbb_root_path;
		$this->template = $template;
	}
}
