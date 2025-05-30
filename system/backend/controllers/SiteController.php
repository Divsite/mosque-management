<?php
namespace backend\controllers;
use backend\models\Receiver;
use backend\models\User;
use backend\models\VolunteerProfile;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['registration'],
                'rules' => [
                    [
                        'actions' => ['registration'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $receivers = Receiver::find()->all();
        $details = [];

        foreach ($receivers as $coupon) {

            $key = ($coupon->is_committee == 1) ? 'Panitia' : $coupon->neighborhood->name;

            if (!isset($details[$key])) {
                $details[$key] = [
                    'claimed' => 0,
                    'not_claimed' => 0,
                    'total' => 0,
                ];
            }

            if ($coupon->status == Receiver::CLAIM) {
                $details[$key]['claimed']++;
            } elseif ($coupon->status == Receiver::NOT_CLAIM) {
                $details[$key]['not_claimed']++;
            }

            $details[$key]['total']++;
        }

        $statistics = [
            Yii::t('app', 'all_total_qurban_coupon') => array_sum(array_column($details, 'total')),
            Yii::t('app', 'total_claim_qurban_coupon') => array_sum(array_column($details, 'claimed')),
            Yii::t('app', 'total_not_claim_qurban_coupon') => array_sum(array_column($details, 'not_claimed')),
        ];

        $statStyles = [
            Yii::t('app', 'total_claim_qurban_coupon') => ['color' => 'bg-gradient-green', 'icon' => 'fa-check-circle'],
            Yii::t('app', 'total_not_claim_qurban_coupon') => ['color' => 'bg-gradient-yellow', 'icon' => 'fa-clock'],
            Yii::t('app', 'all_total_qurban_coupon') => ['color' => 'bg-gradient-blue', 'icon' => 'fa-calculator'],
        ];

        return $this->render('index', [
            'statistics' => $statistics,
            'details' => $details,
            'statStyles' => $statStyles
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        Yii::$app->cache->flush();
        
        if (!Yii::$app->user->isGuest) 
        {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {
            return $this->goBack();
        } 
        else 
        {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegistration()
    {
        $model = new User();

        $profile = new VolunteerProfile();

        // Bypass Validation Here
        $model->auth_key = 'AUTH_KEY';
        $model->password_hash = 'PASSWORD_HASH';
        $model->created_at = time();
        $model->updated_at = time();
        $model->type = 'B';
        $model->code = 'BCH002';
        $model->level = '2b6cc9c30eaad9c109091ea928529cbd';

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
            
            $model->save();
            
            $profile->user_id = $model->id;
            $profile->save();
            
            /* Application Log Database */
            $table_name = $model->getTableSchema()->name;
            $table_update = Yii::$app->request->post()[$model->formName()];
            Yii::$app->application->log_update($table_name.'/create', json_encode($table_update));
            
            Yii::$app->getSession()->setFlash('registration_created', [
                    'type'     => 'success',
                    'duration' => 5000,
                    'title'    => 'System Information',
                    'message'  => 'Data Created !',
                ]
            );
            return $this->redirect(['login']);
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

        return $this->render('registration', [
            'model' => $model,
            'profile' => $profile
        ]);
    }
}
