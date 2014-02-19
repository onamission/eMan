<?php
$this->breadcrumbs=array(
	'Timing Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TimingDetails', 'url'=>array('index')),
	array('label'=>'Create TimingDetails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('timing-details-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Timing Details</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'timing-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model->with('event'),
	'columns'=>array(
		//'id',
		array('name'=>'event_id'
            ,'filter'=>CHtml::listData(TimingEvents::model()->findAll()
                    , 'id','name' )
            ,'value'=>'$data->event->name'),
array('name'=>'rider_id'
            ,'filter'=>CHtml::listData(TimingRider::model()->findAll()
                    , 'id','name' )
            ,'value'=>'$data->rider->name'),/*
array('name'=>'cat_id'
            ,'filter'=>CHtml::listData(TimingCat::model()->findAll()
                    , 'id','name' )
            ,'value'=>'$data->cat->name'),
array('name'=>'cls_id'
            ,'filter'=>CHtml::listData(TimingCls::model()->findAll()
                    , 'id','name' )
            ,'value'=>'$data->cls->name'),*/
		'finish_time',
            'rider_num',
array(
			'class'=>'CButtonColumn',
		),
	),
));