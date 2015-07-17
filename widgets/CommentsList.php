<?php

namespace yeesoft\comments\widgets;

use yii\data\ActiveDataProvider;
use yeesoft\comments\Module;
use yeesoft\comments\models\Comment;

/**
 * Widget for displaying comments
 */
class CommentsList extends \yii\base\Widget
{
    public $comment;
    public $model;
    public $model_id;
    public $parent_id;
    public $nested_level = 1;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $order_direction = ($this->parent_id) ? Module::getInstance()->nestedOrderDirection
                : Module::getInstance()->orderDirection;

        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()->where([
                'model' => $this->model,
                'model_id' => $this->model_id,
                'parent_id' => $this->parent_id,
                'status' => Comment::STATUS_PUBLISHED,
            ])->orderBy(['id' => $order_direction]),
        ]);

        return $this->render('list',
                [
                'dataProvider' => $dataProvider,
                'comment' => $this->comment,
                'nested_level' => $this->nested_level,
        ]);
    }

}