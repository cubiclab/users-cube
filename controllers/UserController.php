<?php

namespace cubiclab\users\controllers;

use Yii;
use yii\web\Response;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use cubiclab\admin\components\Controller;
use cubiclab\users\models\User;
use cubiclab\users\models\UserSearch;


class UserController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'] = [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['ACPUsersView']
            ]
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['ACPUsersCreate']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['ACPUsersUpdate']
        ];
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['delete', 'mass-delete'],
            'roles' => ['ACPUsersDelete']
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'mass-delete' => ['post', 'delete']
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Users list page.
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $statusArray = User::getStatusArray();
        $roleArray = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusArray' => $statusArray,
            'roleArray' => $roleArray
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        $user_permit = array_keys(Yii::$app->authManager->getRolesByUser($id));
        $user = $this->findUser($id);
        return $this->render('view', [
            'user' => $user,
            'roles' => $roles,
            'user_permit' => $user_permit,
            'moduleName' => Yii::$app->controller->module->id
        ]);
    }

    /** Create user */
    public function actionCreate()
    {
        $user = new User(['scenario' => 'admin-create']);
        $statusArray = User::getStatusArray();
        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');

        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                if ($user->save(false)) {
                    foreach(Yii::$app->request->post('roles') as $role)
                    {
                        $new_role = Yii::$app->authManager->getRole($role);
                        Yii::$app->authManager->assign($new_role, $user->getId());
                    }

                    Yii::$app->session->setFlash('success', Yii::t('userscube', 'USER_CREATE_SUCCESS'));
                    return $this->redirect(['update', 'id' => $user->id]);
                } else {
                    Yii::$app->session->setFlash('danger', Yii::t('userscube', 'USER_CREATE_FAIL'));
                    return $this->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($user);
            }
        }

        return $this->render('create', [
            'user' => $user,
            'roles' => $roles,
            'statusArray' => $statusArray
        ]);
    }



    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
/*    public function actionUpdate($id)
    {
        $user = $this->findUser($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

        //роли
        Yii::$app->authManager->revokeAll($user->getId());
        if(Yii::$app->request->post('roles')){
            foreach(Yii::$app->request->post('roles') as $role)
            {
                $new_role = Yii::$app->authManager->getRole($role);
                Yii::$app->authManager->assign($new_role, $user->getId());
            }
        }
        return $this->redirect(Url::to(["/".Yii::$app->controller->module->id."/user/view", 'id' => $user->getId()]));

    }*/

    /**
     * Delete user.
     * @param integer $id User ID
     * @return mixed View
     */
    public function actionDelete($id)
    {
        $this->findUser($id)->delete();
        return $this->redirect(['index']);
    }

    /** Delete multiple users page. */
    public function actionMassDelete()
    {
        if (($ids = Yii::$app->request->post('ids')) !== null) {
            $models = $this->findUser($ids);
            foreach ($models as $model) {
                $model->delete($model);
            }
            return $this->redirect(['index']);
        } else {
            throw new HttpException(400);
        }
    }

    /**
     * Find User model by ID
     *
     * @param integer|array $id User ID
     *
     * @return \cubiclab\users\models\User User
     * @throws NotFoundHttpException User not found
     */
    private function findUser($id)
    {
        if (is_array($id)) {
            /** @var User $user */
            $model = User::findIdentities($id);
        } else {
            /** @var User $user */
            $model = User::findIdentity($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('User not found');
        }
    }




}