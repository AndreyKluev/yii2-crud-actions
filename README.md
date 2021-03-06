# CrudActions - CRUD actions extension for Yii #

## Установка ##

В composer.json:

```
"require": {
	...
	"andreykluev/yii2-crud-actions": "dev-master"
},
```

## Варианты использования ##

``` php
use andreykluev\crudactions\crudActionCreate;
use andreykluev\crudactions\crudActionDelete;
use andreykluev\crudactions\crudActionUpdate;

use common\models\Product;

class CatalogController extends AppController
{

	...

	public function actions()
	{
		return array(
			'insert' => [
				'class' => crudActionCreate::className(),
				'model' => new Product(),
				'view' => 'update-album',
				'onBeforeAction' =>  [$this, 'beforeSaveProduct'],
				'onAfterAction' =>  [$this, 'afterSaveProduct'],
			],
			
			'update' => [
				'class' => crudActionUpdate::className(),
				'modelClass' => Product::className(),
                'attributes' => [
                    'id_user' => Yii::$app->user->identity->getId(),
                    'id_album' => Yii::$app->request->get('idAlbum', 0),
                ],
				'view' => 'update-album',
				'onBeforeAction' =>  [$this, 'beforeSaveProduct'],
				'onAfterAction' =>  [$this, 'afterSaveProduct'],
			],
			
			'delete' => [
				'class' => crudActionDelete::className(),
				'modelClass' => Product::className(),
				'onBeforeAction' =>  [$this, 'beforeDeleteProduct'],
				'onAfterAction' =>  [$this, 'afterDeleteProduct'],
			],

			...
		);
	}

	...
	
	public function beforeSaveProduct()
	{
		// Ваш код
	}
	
	public function afterSaveProduct($isSave = false)
	{
		// Ваш код
	}
	
	public function beforeDeleteProduct()
	{
		// Ваш код
	}
	
	public function afterDeleteProduct($isDelete = false)
	{
		// Ваш код
	}
```