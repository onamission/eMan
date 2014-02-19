<?php
$this->breadcrumbs=array(
	'Timing Events'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TimingEvents', 'url'=>array('index')),
	array('label'=>'Create TimingEvents', 'url'=>array('create')),
	array('label'=>'View TimingEvents', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TimingEvents', 'url'=>array('admin')),
);
?>

<h1>Update TimingEvents <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>