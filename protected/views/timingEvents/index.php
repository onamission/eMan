<?php
$this->breadcrumbs=array(
	'Timing Events',
);

$this->menu=array(
	array('label'=>'Create TimingEvents', 'url'=>array('create')),
	array('label'=>'Manage TimingEvents', 'url'=>array('admin')),
);
?>

<h1>Timing Events</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
