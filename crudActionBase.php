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

	/**
	 * @var string View для отображения формы
	 */
	public $view;

	public $onBeforeAction = null;
	public $onAfterAction = null;

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

		// Если модель не найдена, генерим Exception
		if ($this->model === null)
			throw new HttpException(404, 'Model not found');

		return $this->model;
	}
}