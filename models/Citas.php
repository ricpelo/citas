<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "citas".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $especialista_id
 * @property string $instante
 *
 * @property Especialistas $especialista
 * @property Usuarios $usuario
 */
class Citas extends \yii\db\ActiveRecord
{
    public $especialidad_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'citas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['!usuario_id', 'especialidad_id', 'especialista_id', 'instante'], 'required'],
            [['usuario_id', 'especialista_id'], 'default', 'value' => null],
            [['usuario_id', 'especialista_id'], 'integer'],
            [['instante'], 'safe'],
            [['especialidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidades::class, 'targetAttribute' => ['especialidad_id' => 'id']],
            [['especialidad_id'], 'comprobarEspecialidad', 'skipOnError' => true],
            [['especialista_id'], 'exist', 'skipOnError' => true, 'targetClass' => Especialistas::className(), 'targetAttribute' => ['especialista_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    public function comprobarEspecialidad($attribute, $params)
    {
        /** @var $paciente Citas */
        $paciente = Yii::$app->user->identity;
        if ($paciente->getCitasPendientes()
            ->joinWith('especialista e')
            ->andOnCondition(['e.especialidad_id' => $this->especialidad_id])
            ->exists()) {
            $this->addError($attribute, 'No puede tener dos citas de la misma especialidad.');
        }
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['especialidad_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario',
            'especialidad_id' => 'Especialidad',
            'especialista_id' => 'Especialista',
            'instante' => 'Fecha y hora',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspecialista()
    {
        return $this->hasOne(Especialistas::className(), ['id' => 'especialista_id'])->inverseOf('citas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('citas');
    }
}
