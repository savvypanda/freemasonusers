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

$fieldsets = $this->form->getFieldsets();
if (isset($fieldsets['core']))   unset($fieldsets['core']);
if (isset($fieldsets['params'])) unset($fieldsets['params']);

foreach ($fieldsets as $group => $fieldset): // Iterate through the form fieldsets
	$fields = $this->form->getFieldset($group);
	if (count($fields)):
?>
<fieldset id="users-profile-custom" class="users-profile-custom-<?php echo $group;?>">
	<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.?>
	<legend><?php echo JText::_($fieldset->label); ?></legend>
	<?php endif;?>
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
<?php endforeach;?>
