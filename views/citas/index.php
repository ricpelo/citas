<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas';
$this->params['breadcrumbs'][] = $this->title;
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
            'instante:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
