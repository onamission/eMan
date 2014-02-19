<?php
$this->breadcrumbs=array(
	'Timing Details',
);

$this->menu=array(
	array('label'=>'Create TimingDetails', 'url'=>array('create')),
	array('label'=>'Manage TimingDetails', 'url'=>array('admin')),
);
?>

<h1>Timing Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
