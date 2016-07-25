<?php /** @var MovieModel $model */ ?>
<div class="rating-container" data-id="<?php echo $model->movieId; ?>" data-rate="<?php echo $rating ?>">
    <?php for ($i = 1; $i <= 10; $i++) : ?>
        <?php $class = 'rating-' . $i; ?>
        <input type="radio" name="example" class="rating <?php echo $class; ?>" value="<?php echo $i; ?>" />
    <?php endfor; ?>
</div>


<?php
$this->widget('zii.widgets.CDetailView', [
    'data' => $model,
    'attributes' => [
        [
            'label' => 'Poster',
            'type'  =>'raw',
            'value' => CHtml::image($model->getUrl())
        ],
        'movieId',
        'title',
        'organicTitle',
        'runtime',
        'releaseDate',
        [
            'label' =>'Genre',
            'type'  =>'raw',
            'value' => $model->getGenres()
        ],
    ],
]);

Yii::app()->clientScript->registerScript('register_script_name', "
$('.myCheckbox').prop('checked', true);
    var rating = $('.rating-container').data('rate');
    if (!rating == 0) {
        $('a[title='+ rating +']').trigger('click');
    }
");

