<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 20.08.2015
 * Time: 13:04
 */

namespace yii\userscube\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Response;

use yii\userscube\models\User;


/** Default controller for Usercube module */
class DefaultController extends Controller
{

    /** Redirect to login page or profile management page */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(["/users/login"]);
        } else {
            return $this->redirect(["/users/profile"]);
        }
    }

    /** Login page */
    public function actionLogin()
    {
        return 'Login Page';
    }

    /** Logout */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        // redirect
        $logoutRedirect = Yii::$app->getModule("userscube")->logoutRedirect;
        if ($logoutRedirect === null) {
            return $this->goHome();
        }
        else {
            return $this->redirect($logoutRedirect);
        }
    }

    /** Profile page */
    public function actionProfile()
    {
        return 'Profile Page';
    }


    /** Sign Up page. (Registration) */
    public function actionSignup()
    {
        $user = new User(['scenario' => 'register']);

        // if register action is triggered
        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {

                if ($user->save(false)) {
                    Yii::$app->user->login($user);
                    Yii::$app->session->setFlash('success', 'Register success');

                    return $this->goHome();
                } else {
                    Yii::$app->session->setFlash('danger', 'Register error');
                    return $this->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($user);
            }
        }

        // render view
        return $this->render(
            'signup',
            [
                'user' => $user
            ]
        );
    }


}