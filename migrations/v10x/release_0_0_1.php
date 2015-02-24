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

class release_0_0_1 extends \phpbb\db\migration\migration
{
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
			array('permission.add', array('u_post_pm', true)),

			// Set permissions
			array('permission.permission_set', array('ROLE_USER_FULL', 'u_post_pm')),
			array('permission.permission_set', array('ROLE_USER_STANDARD', 'u_post_pm')),
		);
	}
}
