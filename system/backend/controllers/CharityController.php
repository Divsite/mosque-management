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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        
    }

    public function actionSelectCharityType($id)
    {
        $charityType = CharityType::findOne(['id' => $id]);

        $result = json_encode(array(
                    'min' => $charityType->min ? $charityType->min : null,
                    'max' => $charityType->max ? $charityType->max : null,
                    'rice' => $charityType->total_rice ? $charityType->total_rice : null,
                    'package' => $charityType->package ? $charityType->package : null,
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
}
