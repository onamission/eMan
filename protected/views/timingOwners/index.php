<?php
/* @var $this TimingOwnersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Timing Owners',
);

$this->menu=array(
	array('label'=>'Create TimingOwners', 'url'=>array('create')),
	array('label'=>'Manage TimingOwners', 'url'=>array('admin')),
);
?>

<h1>Timing Owners</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
