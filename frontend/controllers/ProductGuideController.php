<?php

namespace frontend\controllers;

use Yii;


/**
 * ProductGuideController implements the CRUD actions for ProductGuide model.
 */
class ProductGuideController extends \frontend\controllers\Controller
{
    
    /**
     * Get Image
     */
    public function actionGetImage()
    {
        
        $size = getimagesize(Yii::getAlias('@common/content/images/') . Yii::$app->request->get('id'));
       
        $f = Yii::getAlias('@common/content/images/') . Yii::$app->request->get('id');
        if (is_file($f)) {
            echo file_get_contents($f);
        }
    }
    
    /**
     * Get Image
     */
    public function actionGetLmage()
    {
        $size = getimagesize(Yii::getAlias('@common/content/images/') . Yii::$app->request->get('id'));
        $this->demoImageThumb($size[0], $size[1]);
    }    
        
    public function demoImageThumb($newWidth, $newHeight)
    {
        $imageFile = Yii::getAlias('@frontend/web/img/').'demo.jpg';
        $size = getimagesize($imageFile);
        
        settype($newWidth, 'integer');
        settype($newHeight, 'integer');
        $imageBig = imagecreatefromjpeg($imageFile);
        
        $imageSmall = imagecreate($newWidth, $newHeight);
        $imageSmall = imagecreatetruecolor($newWidth, $newHeight);
        $black = imagecolorallocate($imageSmall, 0, 0, 0);
        imagecolortransparent($imageSmall, $black);
        imagecopyresampled($imageSmall, $imageBig, 0, 0, 0, 0, $newWidth,$newHeight, $size[0],$size[1]);

        imagedestroy($imageBig);
        
        imagejpeg($imageSmall);

        imagedestroy($imageSmall);
    }
    
    /**
     * Finds the ProductGuide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductGuide the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductGuide::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
