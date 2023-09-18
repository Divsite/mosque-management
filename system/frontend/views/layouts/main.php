<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$this->title = Yii::t('app', 'mosque_hub'); 
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    
    <?php
    
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-primary navbar-fixed-top',
        ],
    ]);

    $guestMode = Yii::$app->user->isGuest;
    
    // get menu data
    $userMenus = \backend\models\UserMenu::find()
        ->where(['module' => Yii::$app->controller->module->id, 'id_sub' => 0, 'guest' => ($guestMode ? 0 : 1)])
        ->orderBy(['seq' => SORT_ASC, 'id' => SORT_DESC])
        ->asArray()
        ->all();
    
    // general menus 
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];

    if (count($userMenus) > 0)
    {
        foreach ($userMenus as $userMenu) {
            if ($userMenu['id_sub'] == 0) {
                $url       = sprintf('%s/%s', $userMenu['url_controller'], $userMenu['url_view']);
                $url_      = array();
                $url_array = array($url);

                if (strpos($userMenu['url_parameter'], ',')) {

                    $url_parameters = explode(',', $userMenu['url_parameter']);

                    $url_param_array = [];

                    foreach ($url_parameters as $key2 => $url_parameter) {

                        if (strpos($url_parameter, '=')) {

                            $param = explode('=', $url_parameter);

                            $url_param_array[trim($param[0])] = trim($param[1]);
                        }
                        
                    }

                    $url_ = array_merge($url_array, $url_param_array);

                } else {

                    $url_param_array = [];

                    if (strpos($userMenu['url_parameter'], '=')) {

                        $param = explode('=', $userMenu['url_parameter']);

                        $url_param_array[trim($param[0])] = trim($param[1]);

                    }

                    $url_ = array_merge($url_array, $url_param_array);

                }
                
                switch ($userMenu['class']) 
                {
                    case 'L':
                        $menuItems[] = [
                            'label' => $userMenu['name'],
                            'url' => $url_
                        ];
                    break;
                    case 'S':
                        /* ------------------------------------------ MENU LEVEL 2 ------------------------------------------ */
                        
                        $userMenus2 = \backend\models\UserMenu::find()
                        ->where(['module' => Yii::$app->controller->module->id, 'id_sub' => $userMenu['id'], 'guest' => ($guestMode ? 0 : 1)])
                        ->orderBy(['seq' => SORT_ASC, 'id' => SORT_DESC])
                        ->asArray()
                        ->all();
                        
                        $menuItems2 = array();

                        if (count($userMenus2) > 0)
                        {
                            foreach ($userMenus2 as $key2 => $userMenu2)
                            {
                                if ($userMenu2['id_sub2'] == 0)
                                {
                                    $url2       = sprintf('%s/%s', $userMenu2['url_controller'], $userMenu2['url_view']);
                                    $url2_      = array();
                                    $url2_array = array($url2);

                                    if (strpos($userMenu2['url_parameter'], ',')) {

                                        $url2_parameters = explode(',', $userMenu2['url_parameter']);

                                        $url2_param_array = [];

                                        foreach ($url2_parameters as $key2 => $url2_parameter) {

                                            if (strpos($url2_parameter, '=')) {

                                                $param = explode('=', $url2_parameter);

                                                $url2_param_array[trim($param[0])] = trim($param[1]);
                                            }
                                            
                                        }

                                        $url2_ = array_merge($url2_array, $url2_param_array);

                                    } else {

                                        $url2_param_array = [];

                                        if (strpos($userMenu2['url_parameter'], '=')) {

                                            $param = explode('=', $userMenu2['url_parameter']);

                                            $url2_param_array[trim($param[0])] = trim($param[1]);

                                        }

                                        $url2_ = array_merge($url2_array, $url2_param_array);

                                    }

                                    switch ($userMenu2['class']) {
                                        
                                        case 'L':
                                            $menuItems2[] = [
                                                'label' => $userMenu2['name'],
                                                'url' => $url2_
                                            ];
                                        break;

                                        case 'S':
                                            /* ------------------------------------------ MENU LEVEL 3 ------------------------------------------ */
                                            $userMenus3 = \backend\models\UserMenu::find()
                                            ->where([
                                                'module' => Yii::$app->controller->module->id, 
                                                'id_sub' => $userMenu['id'], 
                                                'id_sub2' => $userMenu2['id'], 
                                                'guest' => ($guestMode ? 0 : 1)
                                            ])
                                            ->orderBy(['seq' => SORT_ASC, 'id' => SORT_DESC])
                                            ->asArray()
                                            ->all();

                                            $menuItems3 = array();

                                            if (count($userMenus3) > 0) // Check if Array Exists
                                            {
                                                foreach ($userMenus3 as $key3 => $userMenu3) 
                                                {
                                                    if ($userMenu3['id_sub2'] == $userMenu2['id']) 
                                                    {
                                                        $url3       = sprintf('%s/%s', $userMenu3['url_controller'], $userMenu3['url_view']);
                                                        $url3_      = array();
                                                        $url3_array = array($url3);

                                                        if (strpos($userMenu3['url_parameter'], ',')) {

                                                            $url3_parameters = explode(',', $userMenu3['url_parameter']);

                                                            $url3_param_array = [];

                                                            foreach ($url3_parameters as $key2 => $url3_parameter) {

                                                                if (strpos($url3_parameter, '=')) {

                                                                    $param = explode('=', $url3_parameter);

                                                                    $url3_param_array[trim($param[0])] = trim($param[1]);
                                                                }
                                                                
                                                            }

                                                            $url3_ = array_merge($url3_array, $url3_param_array);

                                                        } else {

                                                            $url3_param_array = [];

                                                            if (strpos($userMenu3['url_parameter'], '=')) {

                                                                $param = explode('=', $userMenu3['url_parameter']);

                                                                $url3_param_array[trim($param[0])] = trim($param[1]);

                                                            }

                                                            $url3_ = array_merge($url3_array, $url3_param_array);

                                                        }

                                                        switch ($userMenu3['class']) {
                                                            case 'L':
                                                                $menuItems3[] = [
                                                                    'label' => $userMenu3['name'],
                                                                    'url' => $url3_
                                                                ];
                                                            break;

                                                            case 'S':
                                                                /* MENU LEVEL 4 */
                                                            break;
                                                            
                                                            default:
                                                            break;
                                                        }
                                                    }
                                                }
                                            }

                                            $menuItems3[] = [
                                                'label' => $userMenu2['name'],
                                                'url' => '#',
                                                'items' => $menuItems3,
                                            ];

                                        break;
                                        
                                        default:
                                        break;
                                    }
                                }
                            }
                        }

                        $menuItems[] = [
                            'label' => $userMenu['name'],
                            'url' => '#',
                            'items' => $menuItems2,
                        ];
                    
                    break;

                    default:
                    break;
                }
            }
        }
    }

    // all menu from db automatic sign in here 
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Profile', 'url' => ['/user/view', 'id' => Yii::$app->user->identity->id]];
        $menuItems[] = ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
    }
    
    echo Nav::widget([
        'options' => [
            'class' => 'navbar-nav ml-auto'
        ],
        'items' => $menuItems,
        'encodeLabels' => false,
        'activateItems' => true,
        'activateParents' => true,
    ]);
    
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-right"><?= 'Powered By Divsite Teknologi' ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>