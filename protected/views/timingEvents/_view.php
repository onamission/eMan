<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Owner')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->event->name), array('timingOwners/view', 'id'=>$data->event->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php  echo CHtml::encode($data->getAttributeLabel('interval')); ?>:</b>
	<?php  echo CHtml::encode($data->interval); ?>
	<br />

	<b><?php  echo CHtml::encode($data->getAttributeLabel('event_status')); ?>:</b>
	<?php  echo CHtml::encode($data->event_status); ?>
	<br />


</div>