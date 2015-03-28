<?php

namespace bbird\crudactions;

use Yii;
use yii\base\Action;
use yii\web\HttpException;

/**
 * Class crudActionBase
 * @package bbird\crudactions
 */
class crudActionBase extends Action
{
	/**
	 * @var string Имя класса модели
	 */
	public $modelClass;

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
		// Определяем модель в соответствии с переданным именем класса
		$model = call_user_func([$this->modelClass, 'findOne'], [$id]);

		// Если модель не найдена, генерим Exception
		if ($model === null)
			throw new HttpException(404, 'Model not found');

		return $model;
	}
}