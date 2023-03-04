<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "catalog".
 *
 * @property int $id
 * @property string $name Название лота
 * @property float $price Начальная цена
 * @property float $bet Ставка
 * @property int $add_time Добавочное время
 * @property int|null $date_start Дата начала торгов
 * @property int|null $date_end Дата окончания торгов
 * @property int|null $user_id Пользователь, купивший лот
 * @property float|null $cost Итоговая стоимость лота
 *
 * @property Betting[] $bettings
 * @property Users $user
 */
class Catalog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'bet', 'add_time'], 'required'],
            [['price', 'bet', 'cost'], 'number'],
            [['add_time', 'date_start', 'date_end', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название лота',
            'price' => 'Начальная цена',
            'bet' => 'Ставка',
            'add_time' => 'Добавочное время',
            'date_start' => 'Дата начала торгов',
            'date_end' => 'Дата окончания торгов',
            'user_id' => 'Пользователь, купивший лот',
            'cost' => 'Итоговая стоимость лота',
        ];
    }

    /**
     * Gets query for [[Bettings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBettings()
    {
        return $this->hasMany(Betting::class, ['catalog_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function isStart(): bool
    {
        return $this->date_start < time();
    }

    public function isFinished(): bool
    {
        return $this->date_end <= time();
    }
}
