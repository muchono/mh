<?php

namespace backend\controllers;
use common\models\User;

class SubscribersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $groups = User::getSubscribedGroups();
        return $this->render('index', ['groups' => $groups]);
    }

}
