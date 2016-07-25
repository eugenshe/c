<?php
    use mdbApi\ApiRequest\DiscoverRequest;
?>

<?php echo CHtml::dropDownList('type', $type, [
    DiscoverRequest::DISCOVER_POPULAR      => 'Popular',
    DiscoverRequest::DISCOVER_RELEASE_DATE => 'Release Date'
]); ?>

<?php

$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'itemGrid',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'name'  => 'ID',
            'value' => '$data["id"]'
        ],
        [
            'name'  => 'Title',
            'value' => '$data["title"]'
        ],
        [
            'name'  => 'Release Date',
            'value' => '$data["release_date"]'
        ],
        array
        (
            'class'=>'CButtonColumn',
            'viewButtonUrl' => 'Yii::app()->createUrl("/movie/view", array("id" => $data["id"]))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/movie/delete", array("id" => $data["id"]))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/movie/update", array("id" => $data["id"]))',
        ),

    ]
]);

Yii::app()->clientScript->registerScript('filter', "
$('#type').change(function(){
    $.fn.yiiGridView.update('itemGrid', {
        data: $(this).serialize()
    });
    return false;
});
");
