<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'event_id'); ?>
		<?php echo $form->textField($model,'event_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rider_id'); ?>
		<?php echo $form->textField($model,'rider_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'cat_id'); ?>
		<?php //echo $form->textField($model,'cat_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'cls_id'); ?>
		<?php //echo $form->textField($model,'cls_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'finish_time'); ?>
		<?php echo $form->textField($model,'finish_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->