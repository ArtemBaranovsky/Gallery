<?php 
use kartik\detail\DetailView; 
$this ->title = 'View Book' ; 
// $model->name; 
$this ->params[ 'breadcrumbs' ][] = [ 'label' => 'Books' , 'url' => [ 'index' ]]; $this ->params[ 'breadcrumbs' ][] = $this ->title; 
// setup your attributes 
$attributes = [ 
	[
		'attribute' => 'book_code' , 
		'format' => 'raw' , 
		'value' => '<kbd>' . $model ->book_code. '</kbd>' , 'displayOnly' => true 
	], 
	'attribute' => 'book_name' , 
	[ 
		'attribute' => 'color' , 
		'format' => 'raw' , 
		'value' => "<span class='badge' style='background-color: {$model->color}'> </span> " . "<code>{$model->color}</code>", 
		'type' =>DetailView::INPUT_COLOR, 'inputWidth' => '40%' 
	],
	[ 
		'attribute' => 'publish_date' , 
		'format' => 'date' , 
		'type' =>DetailView::INPUT_DATE, 
		'widgetOptions' =>[ 'pluginOptions' =>[ 'format' => 'yyyy-mm-dd' ] ], 
		'inputWidth' => '40%' 
	],
	[ 	
		'attribute' => 'status' , 
		'label' => 'Available?' , 
		'format' => 'raw' , 
		'value' => $model ->status ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>' ,
		'type' =>DetailView::INPUT_SWITCH, 
		'widgetOptions' =>[ 'pluginOptions' =>[ 'onText' => 'Yes' , 'offText' => 'No' , ] ]
	], 
	[ 
		'attribute' => 'sale_amount' , 
		'label' => 'Sale Amount ($)' , 
		'format' => 'double' , 
		'inputWidth' => '40%' 
	], 
	[ 
		'attribute' => 'author_id' , 
		'format' => 'raw' , 
		'value' =>Html::a( 'John Steinbeck' , '#' , [ 'class' => 'kv-author-link' ]), 
		'type' =>DetailView::INPUT_SELECT2, 
		'widgetOptions' =>[ 'data' =>ArrayHelper::map(Author::find()->orderBy( 'name' )->asArray()->all(), 'id' , 'name' ), 
		'options' =>[ 'placeholder' => 'Select ...' ], 
		'pluginOptions' =>[ 'allowClear' => true ]
	],
		'inputWidth' => '40%' 
	], 
	[ 
		'attribute' => 'synopsis' , 
		'format' => 'raw' , 
		'value' => '<span class="text-justify"><em>' . $model ->synopsis . '</em></span>' , 
		'type' =>DetailView::INPUT_TEXTAREA, 
		'options' =>[ 'rows' => 4 ] 
	] 
];
echo DetailView::widget(
	[ 
		'model' => $model , 
		'attributes' => $attributes , 
		'deleteOptions' =>[ 
			'url' =>[ 'delete' , 'id' => $model ->id], 
			'data' =>[ 'confirm' =>Yii::t( 'app' , 'Are you sure you want to delete this record?' ), 
			'method' => 'post' , 
		], 
	] 
	]
	);

