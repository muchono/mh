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
        header('Content-type: image/jpeg');
        
        $imageFile = Yii::getAlias('@frontend/web/img/').'demo.jpg';
        $size = getimagesize($imageFile);
        
        $newWidth = $newWidth + 10;
        settype($newWidth, 'integer');
        settype($newHeight, 'integer');
        $imageBig = imagecreatefromjpeg($imageFile);
        
        $imageSmall = imagecreate($newWidth, $newHeight);
        $imageSmall = imagecreatetruecolor($newWidth, $newHeight);
        $black = imagecolorallocate($imageSmall, 0, 0, 0);
        imagecolortransparent($imageSmall, $black);
        imagecopyresampled($imageSmall, $imageBig, 0, 0, 0, 0, $newWidth, $newHeight, $size[0],$size[1]);
        
        // add header
        $stamp = imagecreatefromjpeg(Yii::getAlias('@frontend/web/img/').'demo_logo.jpg');
        imagecopy($imageSmall, $stamp, 15, 10, 0, 0, imagesx($stamp), imagesy($stamp));        

        // add center
        $center = imagecreatefromjpeg(Yii::getAlias('@frontend/web/img/').'demo_demo.jpg');
        //imagecopy($imageSmall, $center, $newWidth/2-158, $newHeight/2-55, 0, 0, imagesx($center), imagesy($center));
        
        // add center
        $center = imagecreatefromjpeg(Yii::getAlias('@frontend/web/img/').'demo_demo.jpg');
        $center_size = $center_new_size = getimagesize(Yii::getAlias('@frontend/web/img/').'demo_demo.jpg');

        if ($newWidth > $newHeight) {
           $k = $newWidth/$size[0];
        } else {
           $k = $newHeight/$size[1];
        }
        $center_new_size[0] = intval($center_size[0] * $k);
        $center_new_size[1] = intval($center_size[1] * $k);
                    
        $center_new = imagecreatetruecolor($center_new_size[0], $center_new_size[1]);
        imagecopyresampled($center_new, $center, 0, 0, 0, 0, $center_new_size[0], $center_new_size[1], $center_size[0],$center_size[1]);
        
        imagecopy($imageSmall, $center_new, $newWidth/2-$center_new_size[0]/2, $newHeight/2-$center_new_size[1]/2, 0, 0, imagesx($center_new), imagesy($center_new));
        
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
