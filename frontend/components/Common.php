<?php

namespace frontend\components;

use yii\base\Component;
use yii\helpers\Url;

class Common extends Component{

    const EVENT_NOTIFY = 'notify_admin';

    public function sendMail($email,$subject,$body,$name=''){
        /*\Yii::$app->mail->compose()
            ->setFrom([ \Yii::$app->params['supportEmail'] => \Yii::$app->name])
            ->setTo([$email => $name])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();*/

        $this->trigger(self::EVENT_NOTIFY);
    }

    public function notifyAdmin($event){

        print "Notify Admin";
    }
    
     public static function getImageAdvert($data,$general = true,$original = false){

        $image = [];
        $base = Url::base();
        if($original){

            $image[] = $base.'uploads/adverts/'.$data['idadvert'].'/general/'.$data['general_image'];
        }
        else{
            $image[] = $base.'uploads/adverts/'.$data['idadvert'].'/general/small_'.$data['general_image'];
        }

        return $image;
    }
 }
