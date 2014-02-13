<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_fmusers
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
?>
<div class="registration-complete<?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>
    
    <h2>Your Account has been successfully activated!</h2>
	<p>You can now log in using the username and password you chose during the registration.</p>
	<p>Remember your username is your Lodge number (3 digits) and Membership (Dues Card) number put together.</p>
	<p><img title="Dues Card Sample" alt="Dues Card Sample" src="images/stories/Dues_card_sample.png" width="300" /></p>
	<p><strong>For example:</strong><br />
		If your Lodge# is: <strong>123</strong><br />
		And your Membership# is: <strong>45678</strong><br />
		Then your username is: <strong>12345678</strong></p>
	<p>&laquo; You can now login using the Member Center login in the left column.</p>
</div>