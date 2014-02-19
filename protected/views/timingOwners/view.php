<?php
/* @var $this TimingOwnersController */
/* @var $model TimingOwners */

$this->breadcrumbs=array(
	'Timing Owners'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TimingOwners', 'url'=>array('index')),
	array('label'=>'Create TimingOwners', 'url'=>array('create')),
	array('label'=>'Update TimingOwners', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TimingOwners', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TimingOwners', 'url'=>array('admin')),
);
?>

<h1>View TimingOwners #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status_id',
		'contact_name',
	),
)); ?>
