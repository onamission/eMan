<?php
$this->breadcrumbs=array(
	'Timing Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TimingDetails', 'url'=>array('index')),
	array('label'=>'Create TimingDetails', 'url'=>array('create')),
	array('label'=>'Update TimingDetails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TimingDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TimingDetails', 'url'=>array('admin')),
);
?>

<h1>View TimingDetails #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'event_id',
		'rider_id',
		'cat_id',
		'cls_id',
		'finish_time',
	),
)); ?>