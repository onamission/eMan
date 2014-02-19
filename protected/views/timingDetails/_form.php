<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'timing-details-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php  echo $form->labelEx($model,'event_id'); ?>
		<?php echo $form->dropDownList($model,'event_id', CHtml::listData( TimingEvents::model()->findAll(), 'id', 'name')); ?>
		<?php // echo $form->textField($model,'event_id'); ?>
		<?php  echo $form->error($model,'event_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rider_id'); ?>
		<?php echo $form->dropDownList($model,'rider_id', CHtml::listData( TimingRider::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'rider_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cat_id'); ?>
		<?php echo $form->dropDownList($model,'cat_id', CHtml::listData( TimingCat::model()->findAll(), 'id', 'name')); ?>
		<?php //echo $form->textField($model,'cat_id'); ?>
		<?php echo $form->error($model,'cat_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cls_id'); ?>
		<?php echo $form->dropDownList($model,'cls_id', CHtml::listData( TimingCls::model()->findAll(), 'id', 'name')); ?>
		<?php // echo $form->textField($model,'cls_id'); ?>
		<?php echo $form->error($model,'cls_id'); ?>
	</div>
<?php if ( !$model->isNewRecord ){ ?>
	<div class="row">
		<?php  echo $form->labelEx($model,'finish_time'); ?>
		<?php  echo $form->textField($model,'finish_time'); ?>
		<?php  echo $form->error($model,'finish_time'); ?>
	</div>
<?php } ?>

	<div class="row">
		<?php echo $form->labelEx($model,'rider_num'); ?>
		<?php echo $form->textField($model,'rider_num'); ?>
		<?php echo $form->error($model,'rider_num'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->