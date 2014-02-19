<?php
$this->breadcrumbs=array(
	'Timing Events'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TimingEvents', 'url'=>array('index')),
	array('label'=>'Create TimingEvents', 'url'=>array('create')),
	array('label'=>'Update TimingEvents', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TimingEvents', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TimingEvents', 'url'=>array('admin')),
);
?>

<h1>View TimingEvents #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		// 'ord',
		'interval',
	),
)); ?>
