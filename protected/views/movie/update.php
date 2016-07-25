<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'movie-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php echo CHtml::activeFileField($model, 'image'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title', array('size'=>60, 'maxlength'=>128)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'organicTitle'); ?>
        <?php echo $form->textField($model,'organicTitle', array('size'=>60, 'maxlength'=>128)); ?>
        <?php echo $form->error($model,'organicTitle'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'releaseDate'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model' => $model,
            'attribute' => 'releaseDate',
            'value' => $model->releaseDate,
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));?>
        <?php echo $form->error($model,'releaseDate'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'runtime'); ?>
        <?php echo $form->textArea($model,'runtime'); ?>
        <?php echo $form->error($model,'runtime'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'overview'); ?>
        <?php echo $form->textArea($model,'overview', array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'overview'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->