<?php

use yii\db\Migration;

/**
 * Handles the creation of tables.
 */
class m230302_214322_create_auction_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Пользователь'),
        ]);

        $this->batchInsert('{{%users}}', ['name'],['Ольга', 'Елена', 'Александр', 'Александр']);

        $this->createTable('{{%catalog}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string()->notNull()->comment('Название лота'),
            'price' => $this->decimal(12, 2)->notNull()->comment('Начальная цена'),
            'bet' => $this->decimal(12, 2)->notNull()->comment('Ставка'),
            'date_start' => $this->dateTime()->comment('Дата начала торгов'),
            'date_end' => $this->dateTime()->comment('Дата окончания торгов'),
            'user_id' => $this->integer()->comment('Пользователь, купивший лот'),
            'cost' => $this->decimal(12, 2)->comment('Итоговая стоимость лота'),
        ]);

        $this->addForeignKey(
            'fk_catalog_user_id',
            'catalog',
            'user_id',
            'users',
            'id',
            'restrict',
            'restrict'
        );

        $this->createTable('{{%betting}}', [
            'catalog_id' => $this->bigInteger()->comment('Лот'),
            'user_id' => $this->integer()->comment('Пользователь'),
            'bet' => $this->decimal(12, 2)->notNull()->comment('Ставка'),
            'date' => $this->integer()->comment('Дата и время ставки'),
            'primary key (catalog_id, user_id)',
        ]);

        $this->addForeignKey(
            'fk_betting_catalog_id',
            'betting',
            'catalog_id',
            'catalog',
            'id',
            'restrict',
            'restrict'
        );

        $this->addForeignKey(
            'fk_betting_user_id',
            'betting',
            'user_id',
            'users',
            'id',
            'restrict',
            'restrict'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_catalog_user_id', 'catalog');
        $this->dropForeignKey('fk_betting_catalog_id', 'betting');
        $this->dropForeignKey('fk_betting_user_id', 'betting');
        $this->dropTable('{{%users}}');
        $this->dropTable('{{%catalog}}');
        $this->dropTable('{{%betting}}');
    }
}
