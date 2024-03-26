<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use backend\models\UserType;
use backend\models\UserLevel;
use backend\models\Branch;
use backend\models\CitizensAssociation;
use backend\models\Customer;
use backend\models\NeighborhoodAssociation;
use backend\models\Populate;
use backend\models\Resident;

class ReffController extends \yii\web\Controller
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
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUserType($code)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $callback = [
            'status' => false, 
            'message' => 'Unknown Error'
        ];

        if ($code)
        {
            $callback['status']  = true;
            $callback['message'] = 'Success';

            $user_level = UserLevel::find()->where(['type' => $code])->asArray()->all();

            switch ($code) 
            {
                case 'B':
                    $data_code = Branch::find()
                                ->with('branchCategory')
                                ->asArray()
                                ->all();
                    break;

                case 'P':
                    $data_code = Customer::find()->asArray()->all();
                    break;
                
                case 'W':
                    $data_code = Populate::find()
                                ->with('village', 'citizenAssociation', 'neighborhoodAssociation')
                                ->asArray()
                                ->all();
                    break;
                
                case 'L':
                    $data_code = Populate::find()
                                ->with('village', 'citizenAssociation', 'neighborhoodAssociation')
                                ->asArray()
                                ->all();
                    break;

                default:
                    $data_code = [];
                    break;
            }
            $callback['data_level'] = $user_level;
            $callback['data_code']  = $data_code;
        }

        return $callback;
    }

    public function actionCitizens($id)
    {
        $citizens  = "<option value=''>-</option>";
        $neighborhood  = "<option value=''>-</option>";
        $resident  = "<option value=''>-</option>";

        $model = CitizensAssociation::find()->where(['village_id' => $id])->asArray()->all();
        foreach ($model as $key => $value) 
        {
            $citizens.= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }

        return json_encode(array(
            'citizens' => $citizens,
            'neighborhood' => $neighborhood,
            'resident' => $resident,
            )
        );
    }
    
    public function actionNeighborhood($id)
    {
        $neighborhood  = "<option value=''>-</option>";
        $resident  = "<option value=''>-</option>";

        $model = NeighborhoodAssociation::find()->where(['citizens_association_id' => $id])->asArray()->all();
        foreach ($model as $key => $value) 
        {
            $neighborhood.= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }

        return json_encode(array(
            'neighborhood' => $neighborhood,
            'resident' => $resident,
            )
        );
    }
    
    public function actionResident($neighborhood, $citizen, $village)
    {
        $resident  = "<option value=''>-</option>";

        $currentYear = date('Y');

        $residentOnyear = (new \yii\db\Query())
            ->select('resident_id')
            ->from('receiver_resident')
            ->leftJoin('receiver', 'receiver_resident.receiver_id = receiver.id')
            ->where(['receiver.registration_year' => $currentYear]);

        $model = Resident::find()
                ->where(['village_id' => $village])
                ->andWhere(['citizen_association_id' => $citizen])
                ->andWhere(['neighborhood_association_id' => $neighborhood])
                ->andWhere(['NOT IN', 'id', $residentOnyear])
                ->with('user')
                ->asArray()
                ->all();

        foreach ($model as $key => $value) 
        {
            $resident.= '<option value="' . $value['id'] . '">' . $value['user']['name'] . '</option>';
        }

        return json_encode(array(
            'resident' => $resident,
            )
        );
    }

    public function actionLocation($type, $name)
    {
	    $province = "<option value=''>-</option>";
	    $city     = "<option value=''>-</option>";
	    $district = "<option value=''>-</option>";

    	if ($type === 'P')
    	{
	    	$model = MrLocation::find()->where(['province_name' => $name])->groupBy(['city_name'])->asArray()->all();
	    	
	    	foreach ($model as $key => $value) 
	    	{
	    		$city.= '<option value="' . $value['city_name'] . '">' . $value['city_name'] . '</option>';
	    	}
    	}
    	else if ($type === 'C')
    	{
	    	$model = MrLocation::find()->where(['city_name' => $name])->groupBy(['district_name'])->asArray()->all();
	    	
	    	foreach ($model as $key => $value) 
	    	{
	    		$district.= '<option value="' . $value['district_name'] . '">' . $value['district_name'] . '</option>';
	    	}

    	}
    	else if ($type === 'D')
    	{

    	}

    	return json_encode(array(
    			'province' => $province,
    			'city' => $city,
    			'district' => $district,
    		)
    	);
    }

    public function actionUserLevel($code, $type)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $callback = [
            'status' => false, 
            'message' => 'Unknown Error'
        ];

        if ($code)
        {
            $callback['status']  = true;
            $callback['message'] = 'Success';

            switch ($type) {
                case 'B':
                    $dataLevel = UserLevel::find()
                        // ->where(['partner_code' => $code])
                        ->where(['type' => UserType::BRANCH])
                        ->asArray()
                        ->all();
                    break;
                case 'W':
                    $dataLevel = UserLevel::find()
                        ->where(['type' => UserType::RESIDENT])
                        ->one();
                    break;
                case 'L':
                    $dataLevel = UserLevel::find()
                        ->where(['type' => UserType::ENV])
                        ->asArray()
                        ->all();
                    break;
                case 'D':
                    $dataLevel = UserLevel::find()
                        ->where(['type' => UserType::DIVSITE])
                        ->asArray()
                        ->all();
                    break;
                default:
                    $dataLevel = [];
                    break;
            }
            
            $callback['data_level']  = $dataLevel;
        }

        return $callback;
    }

}
