<?php
$this->breadcrumbs=array(
	'Timing Riders',
);

$this->menu=array(
	array('label'=>'Create TimingRider', 'url'=>array('create')),
	array('label'=>'Manage TimingRider', 'url'=>array('admin')),
);
?>

<h1>Timing Riders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
