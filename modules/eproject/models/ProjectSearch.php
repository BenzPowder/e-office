<?php
/**
 * Created by PhpStorm.
 * User: MainUser
 * Date: 5/10/2560
 * Time: 11:27
 */

namespace app\modules\eproject\models;


use yii\elasticsearch\ActiveRecord;

class ProjectSearch extends ActiveRecord
{
    /**
     * @return array This model's mapping
     */
    public static function mapping()
    {
        return [
            static::type() => [
                'properties' => [
                    'name' => ['type' => 'string'],
                    'author_name' => ['type' => 'string'],
                    'publisher_name' => ['type' => 'string'],
                    'created_at' => ['type' => 'long'],
                    'updated_at' => ['type' => 'long'],
                    'status' => ['type' => 'long'],
                ]
            ],
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping( static::index(), static::type(), static::mapping() );
    }

    /**
     * Create this model's index
     */
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex( static::index(), [
            'settings' => [ /* ... */],
            'mappings' => static::mapping(),
            //'warmers' => [ /* ... */ ],
            //'aliases' => [ /* ... */ ],
            //'creation_date' => '...'
        ] );
    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex( static::index() );
    }

}