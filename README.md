# CrudActions - CRUD actions extension for Yii #

## Установка ##

В composer.json:

```
"repositories": [
	{
		"type": "vcs",
		"url": "https://github.com/AndreyKluev/yii2-crud-actions.git"
	}
],
"require": {
	...
	"andreykluev/yii2-crud-actions":"dev-master"
},
```

## Использование ##

``` php
use andreykluev\crudactions\crudActionCreate;
use andreykluev\crudactions\crudActionDelete;
use andreykluev\crudactions\crudActionUpdate;

use common\models\Album;

class CatalogController extends AppController
{

	...

	public function actions()
	{
		return array(
			'insert-album' => [
				'class' => crudActionCreate::className(),
				'modelClass' => Album::className(),
				'view' => 'update-album',
				'onBeforeAction' =>  [$this, 'beforeSaveAlbum'],
				'onAfterAction' =>  [$this, 'afterSaveAlbum'],
			],
			
			'update-album' => [
				'class' => crudActionUpdate::className(),
				'modelClass' => Album::className(),
				'view' => 'update-album',
				'onBeforeAction' =>  [$this, 'beforeSaveAlbum'],
				'onAfterAction' =>  [$this, 'afterSaveAlbum'],
			],
			
			'delete-album' => [
				'class' => crudActionDelete::className(),
				'modelClass' => Album::className(),
				'onBeforeAction' =>  [$this, 'beforeDeleteAlbum'],
				'onAfterAction' =>  [$this, 'afterDeleteAlbum'],
			],

			...
		);
	}

	...
	
	public function beforeSaveAlbum()
	{
		// Ваш код
	}
	
	public function afterSaveAlbum($isSave = false)
	{
		// Ваш код
	}
	
	public function beforeDeleteAlbum()
	{
		// Ваш код
	}
	
	public function afterDeleteAlbum($isDelete = false)
	{
		// Ваш код
	}
```