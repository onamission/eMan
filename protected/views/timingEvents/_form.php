<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'timing-events-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'owner_id', array( 'value'=>1 ) ); ?>
		<?php echo $form->labelEx($model,'eventDate'); ?>
		<?php echo $form->textField($model,'eventDate'); ?>
		<?php echo $form->error($model,'eventDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startTime'); ?>
		<?php echo $form->textField($model,'startTime'); ?>
		<?php echo $form->error($model,'startTime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'interval'); ?>
		<?php echo $form->textField($model,'interval'); ?>
		<?php echo $form->error($model,'interval'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->