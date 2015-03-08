<?php
/**
*
* Extension PostPM Package.
*
* @copyright (c) 2015 kinerity <http://www.acsyste.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace kinerity\postpm\migrations\v10x;

class release_0_0_2 extends \phpbb\db\migration\migration
{
	/**
	* Assign migration file dependencies for this migration
	*
	* @return array Array of migration files
	* @static
	* @access public
	*/
	static public function depends_on()
	{
		return array('\kinerity\postpm\migrations\v10x\release_0_0_1');
	}

	/**
	* Add or update data in the database
	*
	* @return array Array of table data
	* @access public
	*/
	public function update_data()
	{
		return array(
			// Add permissions
			array('permission.add', array('u_post_pm_admin', true)),

			// Set permissions
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_post_pm_admin')),
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_post_pm_admin')),
		);
	}
}
