<?php

namespace backend\controllers;

use Yii;
use backend\models\Receiver;
use backend\models\ReceiverSearch;
use backend\models\ReceiverType;
use backend\models\Branch;
use backend\models\Officer;
use backend\models\ReceiverClass;
use backend\models\ReceiverResident;
use backend\models\Resident;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReceiverController implements the CRUD actions for Receiver model.
 */
class ReceiverController extends Controller
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
     * Lists all Receiver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReceiverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Receiver model.
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
     * Creates a new Receiver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Receiver();

        $qty = Yii::$app->request->post('qty');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $villageCharity = Yii::$app->request->post()['Receiver']['village_id']['charity'];
            $citizenCharity = Yii::$app->request->post()['Receiver']['citizens_association_id']['charity'];
            $neighborhoodCharity = Yii::$app->request->post()['Receiver']['neighborhood_association_id']['charity'];
            
            $villageVictim = Yii::$app->request->post()['Receiver']['village_id']['victim'];
            $citizenVictim = Yii::$app->request->post()['Receiver']['citizens_association_id']['victim'];
            $neighborhoodVictim = Yii::$app->request->post()['Receiver']['neighborhood_association_id']['victim'];
            
            $receiverType = ReceiverType::find()->where(['id' => $model->receiver_type_id])->one();
            $branch = Branch::find()->where(['code' => Yii::$app->user->identity->code])->one();
            $registrationYear = date('Y');

            if ($model->receiver_type_id == ReceiverType::ZAKAT) {

                $residentCharity = Yii::$app->request->post()['receiver-resident_id'];
                $officerCharity = Yii::$app->request->post()['receiver-officer_id'];

                $barcodeNumberResult = $receiverType->code .'-'.  
                $branch->code . '-' . 
                $model->generateRunningNumberByBranchAndType($receiverType, $branch);

                $model->barcode_number = $barcodeNumberResult;

                $model->user_id = Yii::$app->user->identity->id;
                $model->branch_code = $branch->code;

                $model->registration_year = $registrationYear;

                $model->village_id = [
                    'charity' => $villageCharity,
                    'victim' => null,
                ];
                $model->citizens_association_id = [
                    'charity' => $citizenCharity,
                    'victim' => null,
                ];
                $model->neighborhood_association_id = [
                    'charity' => $neighborhoodCharity,
                    'victim' => null,
                ];

                $model->status = Receiver::NOT_CLAIM;
                $model->status_update = date('Y-m-d H:i:s');

                $model->save(false);

                if (!empty($residentCharity)) {
                    foreach ($residentCharity as $residentId) {
                        $resident = Resident::findOne($residentId);
                        if ($resident !== null) {
                            $model->link('resident', $resident);
                        }
                    }
                }
                
                if (!empty($officerCharity)) {
                    foreach ($officerCharity as $officerId) {
                        $officer = Officer::findOne($officerId);
                        if ($officer !== null) {
                            $model->link('officer', $officer);
                        }
                    }
                }

            }
            
            
            if ($model->receiver_type_id == ReceiverType::SACRIFICE) {

                // generate barcode function
                for ($x=0; $x < $qty; $x++)
                {
                    $receiver = new Receiver();

                    $barcodeNumberResult = $receiverType->code .'-'.  
                            $branch->code . '-' . 
                            $model->generateRunningNumberByBranchAndType($receiverType, $branch);
                    
                    $receiver->barcode_number = $barcodeNumberResult;
                    $receiver->receiver_type_id = $model->receiver_type_id;
                    $receiver->user_id = Yii::$app->user->identity->id;
                    $receiver->branch_code = $branch->code;
                    $receiver->registration_year = $registrationYear;
                    $receiver->status = Receiver::NOT_CLAIM;
                    $receiver->status_update = date('Y-m-d H:i:s');
                    $receiver->clock = $model->clock;
                    
                    $receiver->village_id = [
                        'charity' => null,
                        'victim' => $villageVictim,
                    ];
                    $receiver->citizens_association_id = [
                        'charity' => null,
                        'victim' => $citizenVictim,
                    ];
                    $receiver->neighborhood_association_id = [
                        'charity' => null,
                        'victim' => $neighborhoodVictim,
                    ];
                    
                    $receiver->save(false);
                }
            }

            
            Yii::$app->getSession()->setFlash(Yii::t('app', 'receiver_success_create'), [
                    'type'     => 'success',
                    'duration' => 5000,
                    'title'    => Yii::t('app', 'system_information'),
                    'message'  => Yii::t('app', 'data_created'),
                ]
            );
            return $this->redirect(['index']);
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
                Yii::$app->getSession()->setFlash('receiver_failed_create', [
                        'type'     => 'error',
                        'duration' => 5000,
                        'title'  => Yii::t('app', 'error'),
                        'message'  => $message,
                    ]
                );
            }
        }

        return $this->render('create', [
            'model' => $model,
            'qty' => $qty,
        ]);
    }

    /**
     * Updates an existing Receiver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Receiver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Receiver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Receiver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Receiver::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionScanner()
    {
        $barcodeNumber = Yii::$app->request->get('number');

        $receiver = Receiver::find()->where(['barcode_number' => $barcodeNumber])->one();

        if ($barcodeNumber !== null && isset($barcodeNumber)) {

            if ($receiver !== null) {

                if ($receiver->status == Receiver::CLAIM) {
                    Yii::$app->getSession()->setFlash('receiver_status_claimed', [
                        'type'     => 'error',
                        'duration' => 5000,
                        'title'    => Yii::t('app', 'error'),
                        'message'  => Yii::t('app', 'sorry_the_coupon_has_already_been_used'),
                    ]);
                    return $this->redirect(['scanner']);
                }

                // claim coupon update status
                $receiver->user_id = Yii::$app->user->identity->id;
                $receiver->status = Receiver::CLAIM;
                $receiver->status_update = date('Y-m-d H:i:s');
                $receiver->save(false);

                // show data
                $receiverData = array(
                    'data' => array (
                        'id'  => $receiver['id'],
                        'barcode_number'  => $receiver['barcode_number'],
                        'name'  => $receiver['name'] ? $receiver['name'] : null,
                        'desc'  => $receiver['desc'] ? $receiver['desc'] : null,
                        'registration_year'  => $receiver['registration_year'] ? $receiver['registration_year'] : null,
                        'status' => $receiver['status'] ? $receiver->getStatus() : null,
                        'status_update' => $receiver['status_update'],
                        'receiver_type_id' => $receiver->receiverType ? $receiver->receiverType->name : null,
                        'receiver_class_id' => $receiver->receiverClass ? $receiver->receiverClass->name : null,
                        'user_id' => $receiver->user ? $receiver->user->name : null,
                        'branch_code' => $receiver->branch ? $receiver->branch->bch_name : null,
                        'citizens_association_id' => $receiver->citizens ? $receiver->citizens->name : null,
                        'neighborhood_association_id' => $receiver->neighborhood ? $receiver->neighborhood->name : null,
                    ),
                );
            }
        }

        return $this->render('scanner', [
            'receiver' => $receiver ? $receiverData : null,
        ]);
    }

    public function actionPrintReceiverBarcode() {
        return $this->render('print_receiver_barcode');
    }

    public function actionEditCouponStatus($id, $status)
    {
        $model = $this->findModel($id); // receiver id

        $model->status = $status;
        
        if ($model->save(false)) {
            Yii::$app->getSession()->setFlash('receiver_status_success', [
                'type'     => 'success',
                'duration' => 5000,
                'title'    => Yii::t('app', 'system_information'),
                'message'  => Yii::t('app', 'coupon_success_claimed'),
            ]);
            return $this->redirect(['index']);
        }
        else
        {
            if ($model->errors)
            {
                $message = "";
                foreach ($model->errors as $key => $value) {
                    foreach ($value as $key1 => $value2) {
                        $message .= $value2;
                    }
                }
                Yii::$app->getSession()->setFlash('receiver_status_failed', [
                        'type'     => 'error',
                        'duration' => 5000,
                        'title'  => Yii::t('app', 'error'),
                        'message'  => $message,
                    ]
                );
            }
        }
    }

    public function actionDeleteAll()
    {
        
        $delete = Receiver::deleteAll();

        if ($delete)
        {
            Yii::$app->getSession()->setFlash(Yii::t('app', 'delete_success'), [
                    'type'     => 'success',
                    'duration' => 5000,
                    'title'    => 'System Information',
                    'message'  => Yii::t('app', 'delete_success'),
                ]
            );
            return $this->redirect(['index']);
        } else {
            Yii::$app->getSession()->setFlash(Yii::t('app', 'data_not_found'), [
                'type'     => 'error',
                'duration' => 5000,
                'title'    => Yii::t('app', 'error'),
                'message'  => Yii::t('app', 'data_not_found'),
            ]
        );
            return $this->redirect(['index']);
        }
    }

    public function actionSelectReceiverClass($id) : String 
    {
        $receiverClass = ReceiverClass::findOne(['id' => $id]);

        $result = json_encode(array(
                    'get_money' => $receiverClass->get_money ? $receiverClass->get_money : null,
                    'get_rice' => $receiverClass->get_rice ? $receiverClass->get_rice : null,
                ));

        return $result;
    }

    public function actionReport()
    {
        
    }

    public function actionAlmsCouponClaim($id, $status, $receiverId)
    {
        $receiver = $this->findModel($receiverId);

        $model = ReceiverResident::findOne($id);

        $model->status = $status;
        $model->status_update = date('Y-m-d h:i:s');
        
        if ($model->save(false)) {
            Yii::$app->getSession()->setFlash('receiver_resident_status_success', [
                'type'     => 'success',
                'duration' => 5000,
                'title'    => Yii::t('app', 'system_information'),
                'message'  => Yii::t('app', 'coupon_success_claimed'),
            ]);
            return $this->redirect(['view', 'id' => $receiver->id]);
        }
        else
        {
            if ($model->errors)
            {
                $message = "";
                foreach ($model->errors as $key => $value) {
                    foreach ($value as $key1 => $value2) {
                        $message .= $value2;
                    }
                }
                Yii::$app->getSession()->setFlash('receiver_resident_status_failed', [
                        'type'     => 'error',
                        'duration' => 5000,
                        'title'  => Yii::t('app', 'error'),
                        'message'  => $message,
                    ]
                );
            }
        }
    }

}
