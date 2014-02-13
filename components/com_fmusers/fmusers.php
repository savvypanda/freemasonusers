<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_fmusers
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/helpers/route.php';

// Load the com_users language file
JFactory::getLanguage()->load('com_users');

// Launch the controller.
$controller = JControllerLegacy::getInstance('Fmusers');
$controller->execute(JRequest::getCmd('task', 'display'));
$controller->redirect();
