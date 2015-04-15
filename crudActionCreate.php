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
		// Получаем модель для создания
		$model = new $this->modelClass;
		$model->scenario = 'insert';

		// Загружаем модель
		if ($model->load(Yii::$app->request->post())) {
			// Валидируем модель
			if ($model->validate()) {
				// Если определн onBeforeSave, выполняем ПЕРЕД сохранения
				if ($this->onBeforeAction) call_user_func($this->onBeforeAction);

				// Добавляем
				$isCreate = $model->save();

				// Если определн onAfterSave, выполняем ПОСЛЕ сохранения
				if ($this->onAfterAction) call_user_func($this->onAfterAction, $isCreate);
			}
		}

		return $this->controller->render($this->view, [
			'model' => $model,
		]);
	}
}