<?php

use kartik\datecontrol\DateControl;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $this yii\web\View */
/** @var $model app\models\Citas */

$this->title = 'Create Citas';
$this->params['breadcrumbs'][] = ['label' => 'Citas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$url = Url::to(['citas/especialistas']);
$js = <<<EOT
$('#citas-especialidad_id').on('change', function (ev) {
    var el = $(this);
    var especialidad_id = el.val();
    $.ajax({
        method: 'GET',
        url: '$url',
        data: {
            especialidad_id: especialidad_id
        },
        success: function (data, code, jqXHR) {
            var sel = $('#citas-especialista_id');
            sel.empty();
            for (var i in data) {
                sel.append(`<option value="\${i}">\${data[i]}</option>`);
                // var option = document.createElement('option');
                // option.value = i;
                // option.innerHTML = data[i];
                // sel.append(option);
            }
        }   
    });
});
EOT;
$this->registerJs($js);
$js = <<<EOT
$('#citas-create').yiiActiveForm('validateAttribute', 'citas-especialidad_id');
EOT;
$this->registerJs($js, View::POS_LOAD);

kartik\icons\FontAwesomeAsset::register($this);

?>
<div class="citas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="citas-form">

    <?php $form = ActiveForm::begin([
        'id' => 'citas-create',
        'enableAjaxValidation' => true,
    ]); ?>

        <?= $form->field($model, 'especialidad_id')->dropDownList($especialidades) ?>
        <?= $form->field($model, 'especialista_id')->dropDownList($especialistas) ?>
        <?= $form->field($model, 'instante')
                ->widget(DateControl::classname(), [
                    'type' => DateControl::FORMAT_DATETIME,
                    'displayFormat' => 'php:d-m-Y H:i',
                ]
            ); ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    </div>

</div>
