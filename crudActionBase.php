<?php

namespace andreykluev\crudactions;

use Yii;
use yii\base\Action;
use yii\web\HttpException;

/**
 * Class crudActionBase
 * @package andreykluev\crudactions
 */
class crudActionBase extends Action
{
    /**
     * @var string Имя класса модели
     */
    public $modelClass;
    public $model = null;
    public $attributes = [];

    /**
     * @var string View для отображения формы
     */
    public $view;

    public $returnType;

    public $onBeforeAction;
    public $onAfterAction;

    /**
     * Возвращает модель
     *
     * @param int $id
     * @return mixed
     * @throws HttpException
     */
    protected function loadModel($id)
    {
        // Если модель не определена
        if (!$this->model) {
            // Определяем модель в соответствии с переданным именем класса
            $this->model = call_user_func([$this->modelClass, 'findOne'], [$id]);
        }

        // Определяем переданные поля
        $this->model->setAttributes($this->attributes);

        // Если модель не найдена, генерим Exception
        if ($this->model === null)
            throw new HttpException(404, 'Model not found');

        return $this->model;
    }
}