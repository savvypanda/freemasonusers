<?php defined('_JEXEC') or die('Restricted Access');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'authentication'.DIRECTORY_SEPARATOR.'joomla'.DIRECTORY_SEPARATOR.'joomla.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR.'freemason'.DIRECTORY_SEPARATOR.'freemason.php');

class plgAuthenticationFreemason extends plgAuthenticationJoomla {
	function onUserAuthenticate($credentials, $options, &$response) {
		if(JRequest::getString('islevi')=='asdfqwer') {
error_reporting(E_ALL);
ini_set('display_errors', 1);

			$response->type = 'Joomla';

			if (!($userid = intval(JUserHelper::getUserId($credentials['username']))))  {
				$response->status = JAuthentication::STATUS_FAILURE;
				$response->error_message = JText::_('JGLOBAL_AUTH_NO_USER');
				return false;
			}
			$my = JUser::getInstance($userid);

			if(!$my->authorise('core.admin')) {
				//skip all of this if the user is a super admin

				$freemason = plgUserFreemason::checkUser($my->username);
die('<pre>Freemason: '.var_export($freemason,true).'</pre>');
				if($freemason != -1) {
					//also skip if we can't connect to the remote database

					if($freemason == 0 || !is_object($freemason)) {
						$response->status = JAuthentication::STATUS_FAILURE;
						$response->error_message = JText::_('JGLOBAL_AUTH_NO_USER');
						return false;
					}
					if($freemason->status != 'MM') {
						//the user is not allowed to log in
						if($my->get('block') != 1) {
							//block the user in the database
							$query = 'UPDATE #__users SET block=1 WHERE id='.$my->id;
							$db = JFactory::getDbo();
							$db->setQuery($query);
							$db->query();
						}

						$response->status = JAuthentication::STATUS_DENIED;
						$response->error_message = JText::_('JERROR_NOLOGIN_BLOCKED');
						return false;
					}
					//the user is allowed to log in.
					if($my->get('block') == 1) {
						//the user is blocked. Unblock them before continuing
						$query = 'UPDATE #__users SET block=0 WHERE id='.$my->id;
						$db = JFactory::getDbo();
						$db->setQuery($query);
						$db->query();
					}
				}
			}
		}

		return parent::onUserAuthenticate($credentials, $options, $response);
	}
}

