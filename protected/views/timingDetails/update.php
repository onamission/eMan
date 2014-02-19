<?php
$this->breadcrumbs=array(
	'Timing Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TimingDetails', 'url'=>array('index')),
	array('label'=>'Create TimingDetails', 'url'=>array('create')),
	array('label'=>'View TimingDetails', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TimingDetails', 'url'=>array('admin')),
);
?>

<h1>Update TimingDetails <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>