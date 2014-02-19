<?php
$this->breadcrumbs=array(
	'Timing Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TimingDetails', 'url'=>array('index')),
	array('label'=>'Manage TimingDetails', 'url'=>array('admin')),
);
?>

<h1>Create TimingDetails</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>