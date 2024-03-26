<?php

namespace backend\controllers;

use backend\models\Env;
use backend\models\Officer;
use Yii;
use backend\models\User;
use backend\models\Populate;
use backend\models\Resident;
use backend\models\UserSearch;
use backend\models\UserType;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'ruleConfig' => [
                'class' => \common\components\AccessRule::className()],
                'rules' => \common\components\AccessRule::getRules(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        /* Application Log */
        Yii::$app->application->log($action->id);
        if (!parent::beforeAction($action)) {
            return false;
        }
        // Another code here
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        // Code here
        return $result;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        // Bypass Validation Here
        $model->auth_key = 'AUTH_KEY';
        $model->password_hash = 'PASSWORD_HASH';
        $model->created_at = time();
        $model->updated_at = time();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $image = UploadedFile::getInstance($model, 'image');

            if ($image)
            {
                $file = Yii::$app->params['upload'] . 'user/' . $model->username . '.' . $image->extension;
                $path = Yii::getAlias('@webroot') . $file;
                $image->saveAs($path);
                $model->image = $file;
            }

            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $model->level = md5($model->level);
            // var_dump(md5($model->level));
            // die;
            $model->save();

            $populate = Populate::find()->where(['code' => $model->code])->one();

            if ($populate) {
                $province = $populate->village->location->province_name; // provinsi
                $city = $populate->village->location->city_name; // kota
                $district = $populate->village->location->district_name; // kecamatan
                $village = $populate->village->id; // kelurahan
                $citizen = $populate->citizenAssociation->id; // rw
                $neighborhood = $populate->neighborhoodAssociation->id; // rt
            }

            if ($model->type == UserType::RESIDENT) {
                $resident = new Resident();
                $resident->user_id = $model->id;
                $resident->nik = null;
                $resident->telp = null;
                $resident->identity_card_image = null;
                $resident->home_image = null;
                $resident->birth_place = null;
                $resident->birth_date = null;
                $resident->gender_id = null;
                $resident->education_id = null;
                $resident->education_major_id = null;
                $resident->married_status_id = null;
                $resident->nationality_id = null;
                $resident->religion_id = null;
                $resident->residence_status_id = null;
                $resident->province = $province;
                $resident->city = $city;
                $resident->district = $district;
                $resident->village_id = $village;
                $resident->citizen_association_id = $citizen;
                $resident->neighborhood_association_id = $neighborhood;
                $resident->address = null;
                $resident->family_head_status = null;
                $resident->dependent_number = null;
                $resident->interest = null;
                $resident->registration_date = date('Y-m-d h:i:s');
                $resident->save(false);
            }

            if ($model->type == UserType::BRANCH) {
                $officer = new Officer();
                $officer->user_id = $model->id;
                $officer->nik = null;
                $officer->nip = null;
                $officer->npwp = null;
                $officer->work_location_id = null;
                $officer->officer_status_id = null;
                $officer->division_id = null;
                $officer->position_id = null;
                $officer->salary = null;
                $officer->bank_id = null;
                $officer->number_account = null;
                $officer->shift_attendance_id = null;
                $officer->telp = null;
                $officer->identity_card_image = null;
                $officer->home_image = null;
                $officer->birth_place = null;
                $officer->birth_date = null;
                $officer->gender_id = null;
                $officer->education_id = null;
                $officer->education_major_id = null;
                $officer->married_status_id = null;
                $officer->nationality_id = null;
                $officer->religion_id = null;
                $officer->residence_status_id = null;
                $officer->province = null;
                $officer->city = null;
                $officer->district = null;
                $officer->postcode = null;
                $officer->citizen_association_id = null;
                $officer->neighborhood_association_id = null;
                $officer->address = null;
                $officer->interest = null;
                $officer->registration_date = date('Y-m-d h:i:s');
                $officer->facility_id = null;
                $officer->save(false);
            }

            if ($model->type == UserType::ENV) {
                $env = new Env();
                $env->user_id = $model->id;
                $env->nik = null;
                $env->telp = null;
                $env->province = $province;
                $env->city = $city;
                $env->district = $district;
                $env->village_id = $village;
                $env->citizen_association_id = $citizen;
                $env->neighborhood_association_id = $neighborhood;
                $env->registration_date = date('Y-m-d h:i:s');
                $env->save(false);
            }

            /* Application Log Database */
            $table_name = $model->getTableSchema()->name;
            $table_update = Yii::$app->request->post()[$model->formName()];
            Yii::$app->application->log_update($table_name.'/create', json_encode($table_update));
            
            Yii::$app->getSession()->setFlash('user_update_save', [
                    'type'     => 'success',
                    'duration' => 5000,
                    'title'    => 'System Information',
                    'message'  => 'Data Created !',
                ]
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            if ($model->errors)
            {
                $message = "";
                foreach ($model->errors as $key => $value) {
                    foreach ($value as $key1 => $value2) {
                        $message .= $value2 . "<br>";
                    }
                }
                Yii::$app->getSession()->setFlash('user_create', [
                        'type'     => 'error',
                        'duration' => 5000,
                        'title'  => 'Error',
                        'message'  => $message,
                    ]
                );
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        /* -------------------------------------- START DEMO VERSION ----------------------------------------- */

        if (in_array($id, [1,2,3,4]))
        {
            Yii::$app->getSession()->setFlash('user_update_demo', [
                    'type'     => 'error',
                    'duration' => 5000,
                    'title'    => 'Yii2-Webapps DEMO',
                    'message'  => 'Data Failed to Update',
                ]
            );

            return $this->redirect(['view', 'id' => $id]);
        }

        /* -------------------------------------- END DEMO VERSION ----------------------------------------- */

        $model = $this->findModel($id);

        // Bypass Validation Here
        $model->auth_key = 'AUTH_KEY';
        $model->password_hash = 'PASSWORD_HASH';
        $model->created_at = $model->created_at;
        $model->updated_at = time();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $image = UploadedFile::getInstance($model, 'image');

            if ($image)
            {
                $file = Yii::$app->params['upload'] . 'user/' . $model->username . '.' . $image->extension;
                $path = Yii::getAlias('@webroot') . $file;
                $image->saveAs($path);
                $model->image = $file;
            }
            else
            {
                $path = $this->findModel($id);
                $model->image = $path->image;
            }

            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $model->level = md5($model->level);
            $model->save();

            /* Application Log Database */
            $table_name = $model->getTableSchema()->name;
            $table_update = Yii::$app->request->post()[$model->formName()];
            Yii::$app->application->log_update($table_name.'/update', json_encode($table_update));

            if (Yii::$app->user->identity->id === $model->id)
            {
                /* Feedback Message */
                Yii::$app->getSession()->setFlash('user_update_save', [
                        'type'     => 'success',
                        'duration' => 5000,
                        'title'    => 'System Information',
                        'message'  => 'Password has change, Please Login again !',
                    ]
                );

                return $this->redirect(['site/index']);
            }
            else
            {
                /* Feedback Message */
                Yii::$app->getSession()->setFlash('user_update_save', [
                        'type'     => 'success',
                        'duration' => 5000,
                        'title'    => 'System Information',
                        'message'  => 'Data Updated !',
                    ]
                );
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else
        {
            if ($model->errors)
            {
                $message = "";
                foreach ($model->errors as $key => $value) {
                    foreach ($value as $key1 => $value2) {
                        $message .= $value2 . "<br>";
                    }
                }
                Yii::$app->getSession()->setFlash('user_update', [
                        'type'     => 'error',
                        'duration' => 5000,
                        'title'    => 'Error',
                        'message'  => $message,
                    ]
                );
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        /* -------------------------------------- START DEMO VERSION ----------------------------------------- */

        if (in_array($id, [1,2,3,4,5]))
        {
            Yii::$app->getSession()->setFlash('user_delete_demo', [
                    'type'     => 'error',
                    'duration' => 5000,
                    'title'    => 'Yii2-Webapps DEMO',
                    'message'  => 'Data Failed to Delete',
                ]
            );

            return $this->redirect(['view', 'id' => $id]);
        }

        /* -------------------------------------- END DEMO VERSION ----------------------------------------- */

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
