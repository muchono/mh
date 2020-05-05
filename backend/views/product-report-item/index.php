<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\UserAffiliate;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
?>
<div class="product-report-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php 
    echo $this->render('_error_report', ['dataProvider' => $dataProvider]);
/*    
    Tabs::widget([
        'items' => [
            [
                'label' => 'Reports List',
                'content' => $this->render('_error_report', ['dataProvider' => $dataProvider]),
                'active' => true
            ],
            [
                'label' => 'Affiliates (> '.UserAffiliate::MIN_TO_PAY.'$:  '.$aff_count.' users)',
                'content' => $this->render('_affiliates', ['affiliates' => $affiliates]),
            ]
        ],
    ]);
 * 
 */
    ?>      
</div>
