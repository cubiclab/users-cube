<?php
/**
 * Controller to attache role for user for Yii2
 *
 * @author Elle <elleuz@gmail.com>
 * @version 0.1
 * @package UserController for Yii2
 *
 */

namespace cubiclab\users\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;

use cubiclab\users\models\User;
use cubiclab\users\models\UserSearch;

class UserController extends Controller
{
     public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['POST'],
                    'delete' => ['POST'],
                    'mass-delete' => ['POST'],
                    '*' => ['GET'],
                ],
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

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
/*    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

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
        $this->deleteUser($this->findUser($id));
        return $this->redirect(['index']);
    }

    /** Delete multiple users page. */
    public function actionMassDelete()
    {
        if (($ids = Yii::$app->request->post('ids')) !== null) {
            $models = $this->findUser($ids);
            foreach ($models as $model) {
                $this->deleteUser($model);
            }
            return $this->redirect(['index']);
        } else {
            throw new HttpException(400);
        }
    }

    /**
     * Deside delete user or just set a deleted status
     *
     * @param \cubiclab\users\models\User User
     */
    private function deleteUser($userModel){
        if( $userModel->status == User::STATUS_DELETED ){
            $userModel->delete();
        } else {
            $userModel->status = User::STATUS_DELETED;
            $userModel->save(false); // validation = false
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