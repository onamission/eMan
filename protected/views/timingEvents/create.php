<?php
$this->breadcrumbs=array(
	'Timing Events'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TimingEvents', 'url'=>array('index')),
	array('label'=>'Manage TimingEvents', 'url'=>array('admin')),
);
?>

<h1>Create TimingEvents</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>