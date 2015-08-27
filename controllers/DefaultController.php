<?php
/**
 * Created by PhpStorm.
 * User: pt1c
 * Date: 20.08.2015
 * Time: 13:04
 */

namespace cubiclab\users\controllers;


use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Response;

use cubiclab\users\models\User;
use cubiclab\users\traits\ModuleTrait;
use cubiclab\users\models\forms\SigninForm;

/** Default controller for Usercube module */
class DefaultController extends Controller
{

    use ModuleTrait;

    /** Redirect to login page or profile management page */
    public function actionIndex()
    {
        // render debug page
        return $this->render('debug_lnks');
    }

    /** Profile page */
    public function actionProfile()
    {
        return 'Profile Page';
    }


    /** Sign Up page. (Registration) */
    public function actionSignup()
    {
        $this->layout = '@vendor/cubiclab/admin-cube/views/layouts/signin';

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

    /** Sign In page. (Login) */
    public function actionSignin(){
        $this->layout = '@vendor/cubiclab/admin-cube/views/layouts/signin';

        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var \cubiclab\users\models\forms\SigninForm $model */
        $model = new SigninForm();
        if ($model->load(Yii::$app->request->post()) && $model->login($this->module->loginDuration)) {
            $loginRedirect = $this->module->loginRedirect;
            if ($loginRedirect === null) {
                return $this->goHome();
            } else {
                return $this->goBack($this->module->loginRedirect);
            }
        }

        // render view
        return $this->render(
            'signin',
            [
                'model' => $model,
            ]
        );
    }

    /** Sign Out page. (Logout) */
    public function actionSignout() {
        Yii::$app->user->logout();
        // redirect
        $logoutRedirect = $this->module->logoutRedirect;
        if ($logoutRedirect === null) {
            return $this->goHome();
        } else {
            return $this->redirect($logoutRedirect);
        }
    }


}