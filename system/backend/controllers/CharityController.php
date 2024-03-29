<?php

namespace backend\controllers;

use Yii;
use backend\models\Charity;
use backend\models\CharityInfaq;
use backend\models\CharityManually;
use backend\models\CharitySearch;
use backend\models\CharitySodaqoh;
use backend\models\CharityType;
use backend\models\CharityWaqaf;
use backend\models\CharityZakatFidyah;
use backend\models\CharityZakatFitrah;
use backend\models\CharityZakatFitrahPackage;
use backend\models\CharityZakatMal;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CharityController implements the CRUD actions for Charity model.
 */
class CharityController extends Controller
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
     * Lists all Charity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CharitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Charity model.
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
     * Creates a new Charity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Charity();

        $charityManually = new CharityManually();

        $charityZakatFitrah = new CharityZakatFitrah();
        $charityZakatFidyah = new CharityZakatFidyah();
        $charityInfaq = new CharityInfaq();
        $charitySodaqoh = new CharitySodaqoh();
        $charityZakatMal = new CharityZakatMal();
        $charityWaqaf = new CharityWaqaf();
        
        // store
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                
                // MANUAL
                if ($model->type == Charity::CHARITY_TYPE_MANUALLY) {
                    $model->branch_code = Yii::$app->user->identity->code;
                    $model->year = date('Y');
                    $model->created_at = date('Y-m-d h:i:s');
                    $model->updated_at = date('Y-m-d h:i:s');
                    $model->created_by = Yii::$app->user->identity->id;
                    $model->updated_by = Yii::$app->user->identity->id;
                    $model->save();

                    if ($charityManually->load(Yii::$app->request->post()) && $charityManually->validate()) {
                        $charityManually->charity_id = $model->id;
                        $charityManually->payment_date = date('Y-m-d h:i:s');
                        $charityManually->save();

                        Yii::$app->getSession()->setFlash('successfully_added_form_manual', [
                                'type'     => 'success',
                                'duration' => 5000,
                                'title'    => Yii::t('app', 'system_information'),
                                'message'  => 'successfully_added_form_manual',
                            ]
                        );
                    } else {
                        $message = "";
                        foreach ($charityManually->errors as $key => $value) {
                            foreach ($value as $key1 => $value2) {
                                $message .= $value2 . "<br>";
                            }
                        }
                        Yii::$app->getSession()->setFlash('failed_to_add_form_manual', [
                                'type'     => 'error',
                                'duration' => 5000,
                                'title'    => Yii::t('app', 'error'),
                                'message'  => $message,
                            ]
                        );

                        throw new \Exception("failed_to_add_form_manual");
                    }
                }

                // AUTOMATIC
                if ($model->type == Charity::CHARITY_TYPE_AUTOMATIC) {
                    $model->branch_code = Yii::$app->user->identity->code;
                    $model->year = date('Y');
                    $model->created_at = date('Y-m-d h:i:s');
                    $model->updated_at = date('Y-m-d h:i:s');
                    $model->created_by = Yii::$app->user->identity->id;
                    $model->updated_by = Yii::$app->user->identity->id;
                    $model->save();

                    if ($charityZakatFitrah->load(Yii::$app->request->post()) && $charityZakatFitrah->validate()) {
                        $charityZakatFitrah->charity_id = $model->id;
                        // echo "<pre>";
                        // var_dump($charityZakatFitrah);
                        // die;
                        $charityZakatFitrah->payment_date = date('Y-m-d h:i:s');
                        $charityZakatFitrah->save();

                        Yii::$app->getSession()->setFlash('successfully_added_zakat_fitrah_form', [
                                'type'     => 'success',
                                'duration' => 5000,
                                'title'    => Yii::t('app', 'system_information'),
                                'message'  => 'successfully_added_zakat_fitrah_form',
                            ]
                        );
                    } else {
                        $message = "";
                        foreach ($charityZakatFitrah->errors as $key => $value) {
                            foreach ($value as $key1 => $value2) {
                                $message .= $value2 . "<br>";
                            }
                        }
                        Yii::$app->getSession()->setFlash('failed_to_add_zakat_fitrah_form', [
                                'type'     => 'error',
                                'duration' => 5000,
                                'title'    => Yii::t('app', 'error'),
                                'message'  => $message,
                            ]
                        );

                        throw new \Exception("failed_to_add_zakat_fitrah_form");
                    }
                }

                $transaction->commit();
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
                    Yii::$app->getSession()->setFlash('failed_to_save_charity', [
                            'type'     => 'error',
                            'duration' => 5000,
                            'title'  => Yii::t('app', 'error'),
                            'message'  => $message,
                        ]
                    );

                    throw new \Exception("failed_to_save_charity");
                }
            } 
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Transaction failed: " . $e->getMessage());
        }
        
        return $this->render('create', [
            'model' => $model,
            'charityManually' => $charityManually,
            'charityZakatFitrah' => $charityZakatFitrah,
            'charityZakatFidyah' => $charityZakatFidyah,
            'charityInfaq' => $charityInfaq,
            'charitySodaqoh' => $charitySodaqoh,
            'charityZakatMal' => $charityZakatMal,
            'charityWaqaf' => $charityWaqaf,
        ]);
    }

    /**
     * Updates an existing Charity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $charityManually = $model->charityManually;

        $charityZakatFitrah = $model->charityZakatFitrah;
        $charityZakatFidyah = $model->charityZakatFidyah;
        $charityInfaq = $model->charityInfaq;
        $charitySodaqoh = $model->charitySodaqoh;
        $charityZakatMal = $model->charityZakatMal;
        $charityWaqaf = $model->charityWaqaf;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'charityManually' => $charityManually,
            'charityZakatFitrah' => $charityZakatFitrah,
            'charityZakatFidyah' => $charityZakatFidyah,
            'charityInfaq' => $charityInfaq,
            'charitySodaqoh' => $charitySodaqoh,
            'charityZakatMal' => $charityZakatMal,
            'charityWaqaf' => $charityWaqaf,
        ]);
    }

    /**
     * Deletes an existing Charity model.
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
     * Finds the Charity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Charity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Charity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionReport()
    {
        $charityType = CharityType::find()
            ->with('charitySource')
            ->where([
                'branch_code' => Yii::$app->user->identity->code,
                'is_active' => CharityType::ACTIVE,
            ]);

        $charityManually = Charity::find()
            ->with(['charityType', 'charityManually'])
            ->where([
                'branch_code' => Yii::$app->user->identity->code,
                'type' => Charity::CHARITY_TYPE_MANUALLY,
            ])
            ->groupBy('type_charity_id');
        
        $charityAutomatic = Charity::find()
            ->with([
                'charityType', 
                'charityZakatFitrah', 
                'charityZakatFidyah',
                'charityInfaq',
                'charitySodaqoh',
                'charityZakatMal',
                'charityWaqaf',
            ])
            ->where([
                'branch_code' => Yii::$app->user->identity->code,
                'type' => Charity::CHARITY_TYPE_AUTOMATIC,
            ])
            ->groupBy('type_charity_id');

        if (Yii::$app->request->post('registration_year')) {
            $charityType->andWhere(['registration_year' => Yii::$app->request->post('registration_year')]);
            $charityManually->andWhere(['year' => Yii::$app->request->post('registration_year')]);
            $charityAutomatic->andWhere(['year' => Yii::$app->request->post('registration_year')]);
        }

        $summaryCharityType = new ActiveDataProvider([
            'query' => $charityType,
        ]);
        
        $summaryCharityManually = new ActiveDataProvider([
            'query' => $charityManually
        ]);
        
        $summaryCharityAutomatic = new ActiveDataProvider([
            'query' => $charityAutomatic
        ]);

        $charityDailyManually = Charity::find()
            ->joinWith('charityManually')
            ->where([
                'branch_code' => Yii::$app->user->identity->code,
                'type' => Charity::CHARITY_TYPE_MANUALLY,
            ]);

        $paymentDate = Yii::$app->request->post('payment_date');

        if (Yii::$app->request->post('type_charity_id') && $paymentDate) {
            $charityDailyManually->andWhere([
                'type_charity_id' => Yii::$app->request->post('type_charity_id'),
                'charity_manually.payment_date' => Yii::$app->request->post('payment_date')
            ]);
        }

        // echo "<pre>";
        // var_dump($charityDailyManually);
        // die;
        
        $summaryCharityDailyManually = new ActiveDataProvider([
            'query' => $charityDailyManually,
        ]);

        return $this->render('report', [
            'summaryCharityType' => $summaryCharityType,
            'summaryCharityManually' => $summaryCharityManually,
            'summaryCharityAutomatic' => $summaryCharityAutomatic,
            'summaryCharityDailyManually' => $summaryCharityDailyManually,
        ]);
    }

    public function actionSelectCharityType($id)
    {
        $charityType = CharityType::findOne(['id' => $id]);

        $result = json_encode(array(
                    'min' => $charityType->min ? Yii::$app->formatter->asCurrency($charityType->min, 'IDR') : '-',
                    'max' => $charityType->max ? Yii::$app->formatter->asCurrency($charityType->max, 'IDR') : '-',
                    'rice' => $charityType->total_rice ? $charityType->total_rice : '-',
                    'package' => $charityType->package ? $charityType->package : '-',
                ));

        return $result;
    }

    public function actionPackageCalculation($id, $type_charity_id)
    {
        $charityZakatFitrahPackage = CharityZakatFitrahPackage::findOne($id);

        $charityType = CharityType::findOne($type_charity_id);

        $paymentTotalPackage = $charityZakatFitrahPackage->value * $charityType->package;

        $result = json_encode(array(
            'payment_total_package' => $paymentTotalPackage ? $paymentTotalPackage : '0',
        ));

        return $result;
    }

    public function actionPrintInvoice($id)
    {
        $model = TbInvoice::findOne($id);

        $allServices = TbInvoiceService::find()
                    ->where(['id_tb_invoice' => $model->id])
                    ->orderBy(['qty' => SORT_DESC])
                    ->all();

        $sum = TbInvoiceService::find()->where(['id_tb_invoice' => $model->id])->sum('amount');

        $content = $this->renderPartial('/tb-invoice/print/invoice', [
                'model' => $model,
                'allServices' => $allServices,
                'sum' => $sum,
                ]);
        
        $cssInline = <<< CSS
        .table1 {
            font-family: sans-serif;
            /* font-weight:normal; */
            color: #232323;
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000000;
            font-weight: bold;
        }
        .table1, th, td {
            border: 1px solid #000000;
            padding: 3px 2px;
        }
        .table1 tr:hover {
            background-color: #f5f5f5;
        }
        CSS;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'marginLeft' => 5,
            'marginRight' => 5,
            'marginTop' => 4,
            'format' => [210,297],
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssInline' => $cssInline,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => ['title' => 'Invoice Order'],
            'methods' => [
                'SetHeader'=> [null],
                'SetFooter'=> [null]
            ]
        ]);

        $date = date('d-m-Y His');
        $pdf->filename = "Invoice - ".$date.".pdf";
        return $pdf->render();
    }
}
