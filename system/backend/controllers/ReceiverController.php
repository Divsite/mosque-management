<?php

namespace backend\controllers;

use Yii;
use backend\models\Receiver;
use backend\models\ReceiverSearch;
use backend\models\ReceiverType;
use backend\models\Branch;
use backend\models\NeighborhoodAssociation;
use backend\models\Officer;
use backend\models\Populate;
use backend\models\ReceiverClass;
use backend\models\ReceiverDocumentationImage;
use backend\models\ReceiverExpense;
use backend\models\ReceiverExpenseDetail;
use backend\models\ReceiverExpenseHandleCreatedUpdated;
use backend\models\ReceiverExpenseSearch;
use backend\models\ReceiverOfficer;
use backend\models\ReceiverOperationalType;
use backend\models\ReceiverResident;
use backend\models\Resident;
use backend\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

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

                $model->status = Receiver::PENDING_STATUS;
                $model->status_update = date('Y-m-d H:i:s');

                $model->save(false);

                if (!empty($residentCharity)) {
                    foreach ($residentCharity as $residentId) {
                        $resident = Resident::findOne($residentId);
                        if ($resident !== null) {
                            $model->link('linkedResidents', $resident);
                        }
                    }
                }
                
                if (!empty($officerCharity)) {
                    foreach ($officerCharity as $officerId) {
                        $officer = Officer::findOne($officerId);
                        if ($officer !== null) {
                            $model->link('linkedOfficers', $officer);
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
                        $message .= $value2;
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
                    'get_money' => $receiverClass->get_money ? Yii::$app->formatter->asCurrency($receiverClass->get_money, 'IDR') : null,
                    'get_rice' => $receiverClass->get_rice ? $receiverClass->get_rice . ' Liter' : null,
                ));

        return $result;
    }

    public function actionReport()
    {
        /**
        * LAPORAN ZAKAT
        */
        $receiver = Receiver::find()
            ->with(['receiverType', 'receiverClass', 'receiverResidents'])
            ->where([
                'branch_code' => Yii::$app->user->identity->code,
                'status' => Receiver::DONE_STATUS,
                'receiver_type_id' => ReceiverType::ZAKAT,
            ])
            ->groupBy('receiver_class_id');

        $receiverExpense = ReceiverExpense::find()
            ->with(['operationalType', 'receiverType'])
            ->where([
                'branch_code' => Yii::$app->user->identity->code,
                'receiver_type_id' => ReceiverType::ZAKAT,
            ])
            ->groupBy('receiver_operational_code');
        
        if (Yii::$app->request->post('registration_year')) {
            $receiver->andWhere(['registration_year' => Yii::$app->request->post('registration_year')]);
            $receiverExpense->andWhere(['registration_year' => Yii::$app->request->post('registration_year')]);
        }

        // echo "<pre>";
        //     var_dump(Yii::$app->request->post('registration_year'));
        //     die;

        $summaryDistributionExpense = new ActiveDataProvider([
            'query' => $receiver,
        ]);

        $summaryGeneralExpense = new ActiveDataProvider([
            'query' => $receiverExpense,
        ]);

        /**
         * LAPORAN QURBAN
         */

        $neighBorhoods = NeighborhoodAssociation::find()->all();

        $totalCouponQurbanByClass = [];

        $no = 1;

        foreach ($neighBorhoods as $neighborhood) {
            
            $totalQurbanCoupon = Receiver::find()
                ->where([
                    'branch_code' => Yii::$app->user->identity->code,
                    'neighborhood_association_id' => $neighborhood->id,
                ])
                ->count();

            $totalClaimQurbanCoupon = Receiver::find()
                ->where([
                    'branch_code' => Yii::$app->user->identity->code,
                    'neighborhood_association_id' => $neighborhood->id,
                    'status' => Receiver::CLAIM
                ])
                ->count();

            $totalNotClaimQurbanCoupon = Receiver::find()
                ->where([
                    'branch_code' => Yii::$app->user->identity->code,
                    'neighborhood_association_id' => $neighborhood->id,
                    'status' => Receiver::NOT_CLAIM
                ])
                ->count();

            $totalCouponQurbanByClass[] = [
                'no' => $no++,
                'name' => $neighborhood->name,
                'total_qurban_coupon' => $totalQurbanCoupon,
                'total_claim_qurban_coupon' => $totalClaimQurbanCoupon,
                'total_not_claim_qurban_coupon' => $totalNotClaimQurbanCoupon,
            ];
        }

        return $this->render('report', [
            'summaryDistributionExpense' => $summaryDistributionExpense,
            'summaryGeneralExpense' => $summaryGeneralExpense,
            'neighBorhoods' => $neighBorhoods,
            'totalCouponQurbanByClass' => $totalCouponQurbanByClass,
        ]);
    }
    
    public function actionExpenseIndex()
    {
        $searchModel = new ReceiverExpenseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/receiver-expense/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionExpenseCreate()
    {
        $model = new ReceiverExpense;

        $detailExpenses = [new ReceiverExpenseDetail];

        if ($model->load(Yii::$app->request->post())) {
            
            $model->branch_code = Yii::$app->user->identity->code;
            $model->registration_year = date('Y');
            $model->created_at = date('Y-m-d h:i:s');
            $model->updated_at = date('Y-m-d h:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->updated_by = Yii::$app->user->identity->id;

            // receiver expense detail validation
            $detailExpenses = ReceiverExpenseHandleCreatedUpdated::createMultiple(ReceiverExpenseDetail::classname());
            
            foreach ($detailExpenses as $key => $value) {
                $detailExpenses[$key]->scenario = ReceiverExpenseDetail::SCENARIO_CREATE;
            }

            ReceiverExpenseHandleCreatedUpdated::loadMultiple($detailExpenses, Yii::$app->request->post());

            // ajax validation case if used ajax
            if (Yii::$app->request->isAjax) {
                // json format converting
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($detailExpenses),
                    ActiveForm::validate($model)
                );
            }

            // multiple validation
            $valid = $model->validate();
            $valid = ReceiverExpenseHandleCreatedUpdated::validateMultiple($detailExpenses) && $valid;
            
            // multiple store with validation
            if ($valid) {
                
                // yii function for transaction process
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($detailExpenses as $item) {
                            
                            $item->receiver_expense_id = $model->id;

                            if ($model->receiver_operational_code == ReceiverOperationalType::OFFICER) {
                                $item->name = null;

                                $receiverOfficer = ReceiverOfficer::find()
                                    ->joinWith('receiver')
                                    ->where([
                                        'officer_id' => $item->officer_id,
                                        'receiver.receiver_class_id' => $item->receiver_class_id
                                    ])
                                    ->one();

                                if ($receiverOfficer) {
                                    $receiverOfficer->is_paid = ReceiverOfficer::IS_PAID_YES;
                                    $receiverOfficer->save(false);
                                }

                            } else {
                                $item->officer_id = null;
                                $item->receiver_class_id = null;
                            }

                            if ($item->qty !== null && is_numeric($item->qty) &&
                                $item->price !== null && is_numeric($item->price)) {
                                $item->amount = $item->qty * $item->price;
                                $model->amount += $item->amount;
                                $model->save(false);
                            }

                            $item->created_at = date('Y-m-d h:i:s');
                            $item->updated_at = date('Y-m-d h:i:s');
                            $item->created_by = Yii::$app->user->identity->id;
                            $item->updated_by = Yii::$app->user->identity->id;

                            // failed store
                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    // success store
                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('receiver_expense_create_success', [
                            'type'     => 'success',
                            'duration' => 5000,
                            'title'    => Yii::t('app', 'system_information'),
                            'message'  => Yii::t('app', 'expense_has_been_successfully_created'),
                        ]);

                        return $this->redirect(['expense-index']);
                    }
                    
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } else {
                if ($model->errors)
                {
                    $message = "";
                    foreach ($model->errors as $key => $value) {
                        foreach ($value as $key1 => $value2) {
                            $message .= $value2;
                        }
                    }
                    Yii::$app->getSession()->setFlash('receiver_expense_status_failed', [
                            'type'     => 'error',
                            'duration' => 5000,
                            'title'  => Yii::t('app', 'error'),
                            'message'  => $message,
                        ]
                    );
                    return $this->redirect(['expense-index']);
                }

                foreach ($detailExpenses as $omg => $detailExpense) {
                    if ($detailExpense->errors)
                    {
                        $message = "";
                        foreach ($detailExpense->errors as $key => $value) {
                            foreach ($value as $key1 => $value2) {
                                $message .= $value2;
                            }
                        }
                        Yii::$app->getSession()->setFlash('receiver_expense_detail_status_failed', [
                                'type'     => 'error',
                                'duration' => 5000,
                                'title'  => Yii::t('app', 'error'),
                                'message'  => $message,
                            ]
                        );
                        return $this->redirect(['expense-index']);
                    }
                }
            }
        } else {
            return $this->renderAjax('/receiver-expense/create', [
                'model' => $model,
                'detailExpenses' => (empty($detailExpenses)) ? [new ReceiverExpenseDetail] : $detailExpenses
            ]);
        }
    }

    public function actionExpenseUpdate($id)
    {
        $model = $this->findModelExpense($id);

        $model->scenario = ReceiverExpense::SCENARIO_UPDATE;

        $detailExpenses = $model->receiverExpenseDetails;

        foreach ($detailExpenses as $key => $value) {
            $detailExpenses[$key]->scenario = ReceiverExpenseDetail::SCENARIO_UPDATE;
        }

        if ($model->load(Yii::$app->request->post())) {
            
            $model->branch_code = Yii::$app->user->identity->code;
            $model->registration_year = date('Y');
            $model->updated_at = date('Y-m-d h:i:s');
            $model->updated_by = Yii::$app->user->identity->id;

            // receiver expense detail validation
            $oldIDs = ArrayHelper::map($detailExpenses, 'id', 'id');
            $detailExpenses = ReceiverExpenseHandleCreatedUpdated::createMultiple(ReceiverExpenseDetail::classname(), $detailExpenses);
            ReceiverExpenseHandleCreatedUpdated::loadMultiple($detailExpenses, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($detailExpenses, 'id', 'id')));

            // ajax validation case if used ajax
            if (Yii::$app->request->isAjax) {
                // json format converting
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($detailExpenses),
                    ActiveForm::validate($model)
                );
            }

            // multiple validation
            $valid = $model->validate();
            $valid = ReceiverExpenseHandleCreatedUpdated::validateMultiple($detailExpenses) && $valid;
            
            // multiple store with validation
            if ($valid) {
                
                // yii function for transaction process
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        $totalAmount = 0;
                        foreach ($detailExpenses as $index => $item) {
                            
                            $item->receiver_expense_id = $model->id;

                            if ($model->receiver_operational_code == ReceiverOperationalType::OFFICER) {
                                $item->name = null;

                                $receiverOfficer = ReceiverOfficer::find()
                                    ->joinWith('receiver')
                                    ->where([
                                        'officer_id' => $item->officer_id,
                                        'receiver.receiver_class_id' => $item->receiver_class_id
                                    ])
                                    ->one();

                                if ($receiverOfficer) {
                                    $receiverOfficer->is_paid = ReceiverOfficer::IS_PAID_YES;
                                    $receiverOfficer->save(false);
                                }

                            } else {
                                $item->officer_id = null;
                                $item->receiver_class_id = null;
                            }

                            if ($item->qty !== null && is_numeric($item->qty) &&
                                $item->price !== null && is_numeric($item->price)) {
                                $item->amount = $item->qty * $item->price;
                                $totalAmount += $item->qty * $item->price;
                                $model->amount = $totalAmount;
                                $model->save(false);
                            }

                            $item->updated_at = date('Y-m-d h:i:s');
                            $item->updated_by = Yii::$app->user->identity->id;

                            if (! empty($deletedIDs)) {
                                ReceiverExpenseDetail::deleteAll(['id' => $deletedIDs]);
                            }
                            $model->refresh();

                            // failed store
                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    // success store
                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->getSession()->setFlash('receiver_expense_update_success', [
                            'type'     => 'success',
                            'duration' => 5000,
                            'title'    => Yii::t('app', 'system_information'),
                            'message'  => Yii::t('app', 'expense_has_been_successfully_updated'),
                        ]);

                        return $this->redirect(['expense-index']);
                    }
                    
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
            else {
                if ($model->errors)
                {
                    
                    $message = "";
                    foreach ($model->errors as $key => $value) {
                        foreach ($value as $key1 => $value2) {
                            $message .= $value2;
                        }
                    }
                    Yii::$app->getSession()->setFlash('receiver_expense_status_failed', [
                            'type'     => 'error',
                            'duration' => 5000,
                            'title'  => Yii::t('app', 'error'),
                            'message'  => $message,
                        ]
                    );
                    return $this->redirect(['expense-index']);
                }

                foreach ($detailExpenses as $omg => $detailExpense) {
                    if ($detailExpense->errors)
                    {
                        $message = "";
                        foreach ($detailExpense->errors as $key => $value) {
                            foreach ($value as $key1 => $value2) {
                                $message .= $value2;
                            }
                        }
                        Yii::$app->getSession()->setFlash('receiver_expense_detail_status_failed', [
                                'type'     => 'error',
                                'duration' => 5000,
                                'title'  => Yii::t('app', 'error'),
                                'message'  => $message,
                            ]
                        );
                        return $this->redirect(['expense-index']);
                    }
                }
            }
        } else {
            return $this->renderAjax('/receiver-expense/update', [
                'model' => $model,
                'detailExpenses' => (empty($detailExpenses)) ? [new ReceiverExpenseDetail] : $detailExpenses
            ]);
        }
    }

    public function actionExpenseDelete($id)
    {
        $this->findModelExpense($id)->delete();

        return $this->redirect(['expense-index']);
    }

    protected function findModelExpense($id)
    {
        if (($model = ReceiverExpense::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function actionIncomeIndex()
    {
        return $this->render('expense');
    }

    public function actionAlmsCouponClaim($id, $status, $receiverId)
    {
        $receiver = $this->findModel($receiverId);

        $model = ReceiverResident::findOne($id);

        $receiverDocumentationImage = new ReceiverDocumentationImage();
        
        if ($receiverDocumentationImage->load(Yii::$app->request->post()) && $receiverDocumentationImage->validate() ||
            $model->resident->load(Yii::$app->request->post() && $model->resident->validate()))
        {
            $model->status = $status;
            $model->status_update = date('Y-m-d h:i:s');
            $model->save(false);

            $allShared = ReceiverResident::find()->where(['receiver_id' => $receiverId, 'status' => ReceiverResident::SHARED])->count();
            $totalResidents = ReceiverResident::find()->where(['receiver_id' => $receiverId])->count();

            if ($allShared == $totalResidents) {
                $pendingResidents = ReceiverResident::find()->where(['receiver_id' => $receiverId, 'status' => ReceiverResident::NOT_YET_SHARED])->count();
                if ($pendingResidents == 0) {
                    $receiver->status = Receiver::DONE_STATUS;
                    $receiver->save(false);
                }
            }

            $this->receiverDocumentationImage($receiver, $receiverDocumentationImage);
            $this->residentIdentityHomeImage($model);

            Yii::$app->getSession()->setFlash('receiver_resident_status_success', [
                'type'     => 'success',
                'duration' => 5000,
                'title'    => Yii::t('app', 'system_information'),
                'message'  => Yii::t('app', 'zakat_was_successfully_distributed'),
            ]);
            return $this->redirect(['view', 'id' => $receiver->id]);
        }
        else
        {
            if ($receiverDocumentationImage->errors)
            {
                $message = "";
                foreach ($receiverDocumentationImage->errors as $key => $value) {
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
            
            if ($model->resident->errors)
            {
                $message = "";
                foreach ($model->resident->errors as $key => $value) {
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

        return $this->render('alms-coupon-claim', [
            'receiverDocumentationImage' => $receiverDocumentationImage,
            'receiver' => $receiver,
            'model' => $model,
        ]);
    }

    public function actionCreateReceiverComplaint($id, $receiverId)
    {
        $receiver = $this->findModel($receiverId);
        $model = ReceiverResident::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->getSession()->setFlash('receiver_complaint_status_success', [
                'type'     => 'success',
                'duration' => 5000,
                'title'    => Yii::t('app', 'system_information'),
                'message'  => Yii::t('app', 'complaint_has_been_successfully'),
            ]);

            $model->status = ReceiverResident::NOT_SHARED;
            $model->status_update = date('Y-m-d h:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $receiver->id]);
        } else {
            if ($model->errors)
            {
                $message = "";
                foreach ($model->errors as $key => $value) {
                    foreach ($value as $key1 => $value2) {
                        $message .= $value2 . "<br>";
                    }
                }
                Yii::$app->getSession()->setFlash('complaint_failed', [
                        'type'     => 'error',
                        'duration' => 5000,
                        'title'  => Yii::t('app', 'error'),
                        'message'  => $message,
                    ]
                );
            }
        }

        return $this->render('/receiver-resident/create', [
            'model' => $model,
        ]);
    }

    public function actionViewReceiverComplaint($id)
    {
        $model = ReceiverResident::findOne($id);

        return $this->renderAjax('/receiver-resident/view', [
            'model' => $model,
        ]);
    }

    public function actionUpdateOfficerCitizen($id)
    {
        $model = $this->findModel($id);

        // get all resident by populate to display on form select
        $populate = Populate::find()->where([
            'village_id' => $model->village_id,
            'citizen_association_id' => $model->citizens_association_id,
            'neighborhood_association_id' => $model->neighborhood_association_id
        ])->one();

        $allResidents = User::findResidentsByCode($populate->code);
        $residentDatas = [];
        foreach ($allResidents as $resident) {
            $residentDatas[$resident->id] = $resident->name;
        }

        // get existing resident data to display value already exist on form select
        $existResidents = [];
        foreach ($model->receiverResidents as $data) {
            $residentId = $data->resident_id;
            
            $residentUser = User::find()->joinWith('residents')->where(['resident.id' => $residentId])->one();
            
            if ($residentUser) {
                $existResidents[$residentUser->id] = $residentUser->name;
            }
        }
        $selectedResidents = array_keys($existResidents);

        // get all officer datas
        $allOfficers = User::find()->where(['level' => Yii::$app->user->identity->level])->all();
        $officerDatas = [];
        foreach ($allOfficers as $officer) {
            $officerDatas[$officer->id] = $officer->name;
        }

        // get existing officer
        $existOfficers = [];
        foreach ($model->receiverOfficers as $data) {
            $officerId = $data->officer_id;
            
            $officerUser = User::find()->joinWith('officers')->where(['officer.id' => $officerId])->one();
            
            if ($officerUser) {
                $existOfficers[$officerUser->id] = $officerUser->name;
            }
        }
        $selectedOfficers = array_keys($existOfficers);

        // update action
        if (Yii::$app->request->post()) {
            $residentCharity = Yii::$app->request->post()['receiver-resident_id'];
            $officerCharity = Yii::$app->request->post()['receiver-officer_id'];
    
            $model->unlinkAll('linkedResidents', true);
            if (!empty($residentCharity)) {
                foreach ($residentCharity as $residentId) {
                    $resident = Resident::find()->where(['user_id' => $residentId])->one();
                    if ($resident !== null) {
                        $model->link('linkedResidents', $resident);
                    }
                }
            }

            $model->unlinkAll('linkedOfficers', true);
            if (!empty($officerCharity)) {
                foreach ($officerCharity as $officerId) {
                    $officer = Officer::find()->where(['user_id' => $officerId])->one();
                    if ($officer !== null) {
                        $model->link('linkedOfficers', $officer);
                    }
                }
            }

            Yii::$app->getSession()->setFlash('update_officer_and_citizen_status_success', [
                'type'     => 'success',
                'duration' => 5000,
                'title'    => Yii::t('app', 'system_information'),
                'message'  => Yii::t('app', 'update_officer_and_citizen_has_been_successfully'),
            ]);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update-officer-citizen', [
            'model' => $model,
            'residentDatas' => $residentDatas,
            'selectedResidents' => $selectedResidents,
            'officerDatas' => $officerDatas,
            'selectedOfficers' => $selectedOfficers,
        ]);
    }

    protected function receiverDocumentationImage($receiver, $receiverDocumentationImage)
    {
        $receiverDocumentationImage->url = UploadedFile::getInstances($receiverDocumentationImage, 'url');
        if ($receiverDocumentationImage->url)
        {
            foreach ($receiverDocumentationImage->url as $key => $image) {
                $docImage = new ReceiverDocumentationImage();
                $docImage->receiver_id = $receiver->id;
                
                $file = Yii::$app->params['upload'] . 'receiver-documentation-image/' . $image->baseName . '.' . $image->extension;
                $path = Yii::getAlias('@webroot') . $file;
                $image->saveAs($path);

                $docImage->name = $image->baseName;
                $docImage->type = $image->type;
                $docImage->size = $image->size;
                $docImage->extension = $image->extension;
                $docImage->description = null;
                $docImage->url = $file;
                $docImage->created_by = Yii::$app->user->identity->id;
                $docImage->updated_by = null;
                $docImage->created_at = date('Y-m-d H:i:s');
                $docImage->updated_at = null;
                $docImage->save(false);
            }
        }
    }
    
    protected function residentIdentityHomeImage($model)
    {
        $image = UploadedFile::getInstances($model->resident, 'home_image');

        if ($image)
        {
            foreach ($image as $uploadFile) {
                $file = Yii::$app->params['upload'] . 'resident-home-image/' . $uploadFile->baseName . '.' . $uploadFile->extension;
                $path = Yii::getAlias('@webroot') . $file;
                $uploadFile->saveAs($path);
                $model->resident->home_image = $file;
                $model->resident->save(false);
            }
        }
    }

    public function actionViewReceiverDistribution($id, $residentId)
    {
        $model = Receiver::findOne($id);
        $receiverResident = ReceiverResident::findOne($residentId);

        return $this->renderAjax('/receiver-documentation-image/view', [
            'model' => $model,
            'receiverResident' => $receiverResident,
        ]);
    }
}
