<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas';
$this->params['breadcrumbs'][] = $this->title;

kartik\icons\FontAwesomeAsset::register($this);

?>
<div class="citas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Citas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'usuario.nombre',
            'especialista.nombre',
            [
                'attribute' => 'instante',
                'format' => 'datetime',
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'instante',
                ])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            'Anular',
                            ['citas/delete', 'id' => $key],
                            [
                                'data-method' => 'POST',
                                'data-confirm' => '¿Seguro que desea anular la cita?',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>
