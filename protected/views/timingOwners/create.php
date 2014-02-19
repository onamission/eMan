<?php
/* @var $this TimingOwnersController */
/* @var $model TimingOwners */

$this->breadcrumbs=array(
	'Timing Owners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TimingOwners', 'url'=>array('index')),
	array('label'=>'Manage TimingOwners', 'url'=>array('admin')),
);
?>

<h1>Create TimingOwners</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>