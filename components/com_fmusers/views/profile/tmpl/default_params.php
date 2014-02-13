<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_fmusers
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */
defined('_JEXEC') or die;

JLoader::register('JHtmlFmusers', JPATH_COMPONENT . '/helpers/html/users.php');
JHtml::register('fmusers.spacer', array('JHtmlFmusers', 'spacer'));
JHtml::register('fmusers.helpsite', array('JHtmlFmusers', 'helpsite'));
JHtml::register('fmusers.templatestyle', array('JHtmlFmusers', 'templatestyle'));
JHtml::register('fmusers.admin_language', array('JHtmlFmusers', 'admin_language'));
JHtml::register('fmusers.language', array('JHtmlFmusers', 'language'));
JHtml::register('fmusers.editor', array('JHtmlFmusers', 'editor'));

?>
<?php $fields = $this->form->getFieldset('params'); ?>
<?php if (count($fields)): ?>
<fieldset id="users-profile-custom">
	<legend><?php echo JText::_('COM_USERS_SETTINGS_FIELDSET_LABEL'); ?></legend>
	<dl>
	<?php foreach ($fields as $field):
		if (!$field->hidden) :?>
		<dt><?php echo $field->title; ?></dt>
		<dd>
			<?php if (JHtml::isRegistered('fmusers.'.$field->id)):?>
				<?php echo JHtml::_('fmusers.'.$field->id, $field->value);?>
			<?php elseif (JHtml::isRegistered('fmusers.'.$field->fieldname)):?>
				<?php echo JHtml::_('fmusers.'.$field->fieldname, $field->value);?>
			<?php elseif (JHtml::isRegistered('fmusers.'.$field->type)):?>
				<?php echo JHtml::_('fmusers.'.$field->type, $field->value);?>
			<?php else:?>
				<?php echo JHtml::_('fmusers.value', $field->value);?>
			<?php endif;?>
		</dd>
		<?php endif;?>
	<?php endforeach;?>
	</dl>
</fieldset>
<?php endif;?>
