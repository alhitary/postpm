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

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth						$auth			Auth object
	* @param \phpbb\db\driver\driver_interface		$db				Database object
	* @param \phpbb\template\template				$template		Template object
	* @param \phpbb\user							$user			User object
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->auth = $auth;
		$this->template = $template;
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
			'core.page_header'	=> 'page_header',
			'core.permissions'	=> 'permissions',

			'core.ucp_pm_compose_modify_data'	=> 'ucp_pm_compose_modify_data',
		);
	}

	public function page_header($event)
	{
		$this->template->assign_vars(array(
			'S_POST_PM_ADMIN'	=> !$this->auth->acl_get('u_post_pm') && $this->auth->acl_get('u_post_pm_admin') ? true : false,
		));
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_post_pm'] = array('lang' => 'ACL_U_POST_PM', 'cat' => 'pm');
		$permissions['u_post_pm_admin'] = array('lang' => 'ACL_U_POST_PM_ADMIN', 'cat' => 'pm');
		$event['permissions'] = $permissions;
	}

	public function ucp_pm_compose_modify_data($event)
	{
		$action = $event['action'];
		$to_group_id = $event['to_group_id'];

		if ($action == 'post' && (!$this->auth->acl_get('u_post_pm') && !$this->auth->acl_get('u_post_pm_admin')))
		{
			// Throwing an exception is currently not supported in event listeners, so use trigger_error.
			// $helper->error and $helper->message are also not supported.
			trigger_error($this->user->lang('NOT_AUTHORISED'));
		}

		if (!$this->auth->acl_get('u_post_pm') && $this->auth->acl_get('u_post_pm_admin'))
		{
			$to_group_id = 5;
		}

		$event['to_group_id'] = $to_group_id;
	}
}
