<?php

namespace andreykluev\crudactions;

use Yii;

/**
 * Class crudActionCreate
 * @package andreykluev\crudactions
 */
class crudActionCreate extends crudActionBase
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        // Если модель не определена
        if (!$this->model) {
            // Получаем модель для создания
            $this->model = new $this->modelClass;
        }
        // Определяем сценарий валидации
        $this->model->scenario = 'insert';

        // Определяем переданные поля
        $this->model->setAttributes($this->attributes);

        // Загружаем модель
        $isCreate = false;
        if ($this->model->load(Yii::$app->request->post())) {
            // Валидируем модель
            if ($this->model->validate()) {
                // Если определн onBeforeSave, выполняем ПЕРЕД сохранения
                if ($this->onBeforeAction) call_user_func($this->onBeforeAction);

                // Добавляем
                // Валидировать модель не нужно, мы это уже сделали
                $isCreate = $this->model->insert(false);

                // Если определн onAfterSave, выполняем ПОСЛЕ сохранения
                if ($this->onAfterAction) call_user_func($this->onAfterAction, $isCreate);
            }
        }

        $result = [
            'result' => $isCreate,
            'model' => $this->model
        ];

        if ($this->returnType === 'json') {
            return $result;
        } else {
            return $this->controller->render($this->view, $result);
        }
    }
}