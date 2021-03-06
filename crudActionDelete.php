<?php

namespace andreykluev\crudactions;

use Yii;
use yii\base\InvalidParamException;
use yii\web\HttpException;

/**
 * Class crudActionDelete
 * @package andreykluev\crudactions
 */
class crudActionDelete extends crudActionBase
{
    /**
     * @throws HttpException
     * @throws InvalidParamException
     */
    public function run()
    {
        // Если модель не определена
        if (!$this->model) {
            // Если не передан id, генерим Exception
            $id = Yii::$app->request->get('id', 0);
            if ($id === 0)
                throw new HttpException(404, 'Expected get parameter id.');

            // Получаем модель для удаления
            $this->loadModel($id);
        }

        // Если определн onBeforeDelete, выполняем ПЕРЕД удалением
        if ($this->onBeforeAction) call_user_func($this->onBeforeAction);

        $isDelete = $this->model->delete();

        // Если определн onAfterDelete, выполняем ПОСЛЕ удаления
        if ($this->onAfterAction) call_user_func($this->onAfterAction, $isDelete);
    }
}