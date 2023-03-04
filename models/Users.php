<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name Пользователь
 *
 * @property Betting[] $bettings
 * @property Catalog[] $catalogs
 * @property Catalog[] $catalogs0
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Пользователь',
        ];
    }

    /**
     * Gets query for [[Bettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBettings()
    {
        return $this->hasMany(Betting::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Catalogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogs()
    {
        return $this->hasMany(Catalog::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Catalogs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogs0()
    {
        return $this->hasMany(Catalog::class, ['id' => 'catalog_id'])->viaTable('betting', ['user_id' => 'id']);
    }
}
