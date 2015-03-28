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
		// Если не передан id, генерим Exception
		$id = Yii::$app->request->get('id', 0);
		if ($id === 0)
			throw new HttpException(404, 'Expected get parameter id.');

		// Получаем модель для редактирования
		$model = $this->loadModel($id);
		$model->scenario = 'update';

		// Загружаем модель
		if ($model->load(Yii::$app->request->post())) {
			// Валидируем модель
			if ($model->validate()) {
				// Если определн onBeforeSave, выполняем ПЕРЕД сохранения
				if ($this->onBeforeAction) call_user_func($this->onBeforeAction);

				// Если определн onAfterSave, выполняем ПОСЛЕ сохранения
				if ($this->onAfterAction) call_user_func($this->onAfterAction, $model->save());
			}
		}

		return $this->controller->render($this->view, [
			'model' => $model,
		]);
	}
}