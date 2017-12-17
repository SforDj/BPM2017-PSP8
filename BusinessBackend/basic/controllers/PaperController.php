<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/14
 * Time: 23:27
 */

namespace app\controllers;


use Yii;
use yii\web\Controller;

class PaperController extends Controller
{
    public function actionGetBook()
    {
        $request = Yii::$app->request;
        $id = $request->get("id");
        $post_data = json_encode(array(
            'name'=>"dad"
        ));
        $header = array(
            'Content-Type: application/json',
            'Content-Length:' . strlen($post_data)
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Paper/");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch_to_create, CURLOPT_HEADER, h);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $data;
        $response->send();

    }

}