<?php
$this->breadcrumbs=array(
	'Timing Riders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TimingRider', 'url'=>array('index')),
	array('label'=>'Manage TimingRider', 'url'=>array('admin')),
);
?>

<h1>Create TimingRider</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>