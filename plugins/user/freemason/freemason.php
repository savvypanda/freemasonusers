<?php defined('_JEXEC') or die;
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR.'joomla'.DIRECTORY_SEPARATOR.'joomla.php');

class plgUserFreemason extends plgUserJoomla {
	public function onUserBeforeSave($oldUser, $isNew, $newUser) {
		if(false && $isNew) {
			$freemason = self::checkUser($newUser['username']);
			if(!is_object($freemason) || $freemason->status != 'MM') return false;
		}
	}

	public function onUserLogin($user, $options = array()) {
		if(JRequest::getString('islevi')=='asdfqwer') {
			$my = $this->_getUser($user, $options);
			if($my instanceof Exception) {
				return false;
			}
			if(!$my->authorise('core.admin')) {
				//skip all of this if the user is a super admin
				$freemason = self::checkUser($user['username']);
die('<pre>Freemason: '.var_export($freemason,true).'</pre>');
				if($freemason != -1) {
					//also skip if we can't connect to the remote database
					if($freemason == 0 || !is_object($freemason)) {
						//the user does not exist
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

						JError::raiseError('401',JText::_('JERROR_NOLOGIN_BLOCKED'));
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

		return parent::onUserLogin($user, $options);
	}

	/*
	 * static function checkUser
	 *
	 * @param userstring The Freemason Member ID to verify
	 *
	 * @return int|object -1 if there is an error connecting to the server, 0 if the user does not exist, or the user object if they exist
	 */
	public static function checkUser($userstring) {
		if(!$userstring || !is_string($userstring) || strlen($userstring) < 8 || strlen($userstring) > 10) return 0;
		$userstring = str_pad($userstring,10,"0",STR_PAD_LEFT);
		$lodgeno = substr($userstring, 0, 5);
		$memberno = substr($userstring, 5);
		try {
			$params = new JParameter(JPluginHelper::getPlugin('user','freemason')->params);
			$db_server = $params->get('remote_db_address');
			$db_port = $params->get('remote_db_port');
			$db_database = $params->get('remote_db_database');
			$db_username = $params->get('remote_db_username');
			$db_password = $params->get('remote_db_password');
			$db_procedure = $params->get('remote_db_procedure');

			/*
			$servername = $db_port?$db_server.','.$db_port:$db_server;
			$credentials = array('Database'=>$db_database,'UID'=>$db_username,'PWD'=>$db_password, 'LoginTimeout'=>30, 'Encrypt'=>1);
			 if(!($conn = sqlsrv_connect($servername, $credentials))) {
				return -1;
			}
			*/

			/*
			$conn = new PDO("sqlsrv:server=$db_server,$db_port;Database=$db_database",$db_username,$db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $conn->prepare("CALL $db_procedure(?, ?)");
			$stmt->bindParam(1, $lodgeno, PDO::PARAM_STR, 5);
			$stmt->bindParam(2, $memberno, PDO::PARAM_STR, 5);
			$stmt->execute();

			$remote_user = $stmt->fetch(PDO::FETCH_OBJ);
			*/

			$conn = mssql_connect($db_server.($db_port?':'.$db_port:''), $db_username, $db_password);
			if(!$conn) {
die('<pre>Unable to connect to server</pre>');
				return -1;
			}
			mssql_select_db($db_database, $conn);

			$stmt = mssql_init($db_procedure, $conn);
			mssql_bind($stmt, '@lodge', $lodgeno, SQLCHAR, false, false, 5);
			mssql_bind($stmt, '@member', $memberno, SQLCHAR, false, false, 5);
			$result = mssql_execute($stmt);
			$remote_user = mssql_fetch_object($result);

			if(!$remote_user) return 0;
			mssql_free_statement($stmt);
			return $remote_user;
		} catch (Exception $e) {
die('<pre>Error: '.print_r($e).'</pre>');
			return -1;
		}
	}
}
