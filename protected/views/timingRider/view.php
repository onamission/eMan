<?php
$this->breadcrumbs=array(
	'Timing Riders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TimingRider', 'url'=>array('index')),
	array('label'=>'Create TimingRider', 'url'=>array('create')),
	array('label'=>'Update TimingRider', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TimingRider', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TimingRider', 'url'=>array('admin')),
);
?>

<h1>View TimingRider #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
	),
)); ?>
