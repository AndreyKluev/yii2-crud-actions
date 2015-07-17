<?php

namespace andreykluev\crudactions;

use Yii;
use yii\web\HttpException;

/**
 * Class crudActionUpdate
 * @package andreykluev\crudactions
 */
class crudActionUpdate extends crudActionBase
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        // Если модель не определена
        if (!$this->model) {
            // Если не передан id, генерим Exception
            $id = Yii::$app->request->get('id', 0);
            if ($id === 0)
                throw new HttpException(404, 'Expected get parameter id.');

            // Получаем модель для редактирования
            $this->loadModel($id);
        }
        $this->model->scenario = 'update';

        // Загружаем модель
        $isUpdate = false;
        if ($this->model->load(Yii::$app->request->post())) {
            // Валидируем модель
            if ($this->model->validate()) {
                // Если определн onBeforeSave, выполняем ПЕРЕД сохранения
                if ($this->onBeforeAction) call_user_func($this->onBeforeAction);

                // Сохраняем
                // Валидировать модель не нужно, мы это уже сделали
                $isUpdate = $this->model->update(false);

                // Если определн onAfterSave, выполняем ПОСЛЕ сохранения
                if ($this->onAfterAction) call_user_func($this->onAfterAction, $isUpdate);
            }
        }

        $result = [
            'result' => $isUpdate,
            'model' => $this->model
        ];

        if ($this->returnType === 'json') {
            return $result;
        } else {
            return $this->controller->render($this->view, $result);
        }
    }
}