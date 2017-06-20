<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

?>
<div class="post-view">

    <h1>Subscribers</h1>


    <table id="w0" class="table table-striped table-bordered detail-view">
    <?php foreach (User::$productActivityNames as $k=>$n) {?>
        <tr><th><?=$n?></th>
            <td>Emails:<br/><?=Html::textarea($k, join(', ', User::getValues($groups[$k], 'email')), ['rows' => 5,'cols' => 100]);?>
                <br/><br/>Phones:<br/>
            <?=Html::textarea($k, join(', ', User::getValues($groups[$k], 'phone')), ['rows' => 5,'cols' => 100]);?>
            </td></tr>
    <?php }?>
    </table>

</div>