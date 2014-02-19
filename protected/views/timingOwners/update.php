<?php
/* @var $this TimingOwnersController */
/* @var $model TimingOwners */

$this->breadcrumbs=array(
	'Timing Owners'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TimingOwners', 'url'=>array('index')),
	array('label'=>'Create TimingOwners', 'url'=>array('create')),
	array('label'=>'View TimingOwners', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TimingOwners', 'url'=>array('admin')),
);
?>

<h1>Update TimingOwners <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>