<?php
/**
*
* Extension PostPM Package.
*
* @copyright (c) 2015 kinerity <http://www.acsyste.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace kinerity\postpm\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth				$auth			Auth object
	* @param \phpbb\user					$user			User object
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\user $user)
	{
		$this->auth = $auth;
		$this->user = $user;
	}

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
			'core.permissions'	=> 'permissions',

			'core.ucp_pm_compose_modify_data'	=> 'ucp_pm_compose_modify_data',
		);
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_post_pm'] = array('lang' => 'ACL_U_POST_PM', 'cat' => 'pm');
		$event['permissions'] = $permissions;
	}

	public function ucp_pm_compose_modify_data($event)
	{
		$action = $event['action'];

		if ($action == 'post' && !$this->auth->acl_get('u_post_pm'))
		{
			// Throwing an exception is currently not supported in event listeners, so use trigger_error.
			// $helper->error and $helper->message are also not supported.
			trigger_error($this->user->lang('NOT_AUTHORISED'));
		}
	}
}
