<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use yii\widgets\Menu;
//use yii\widgets\Breadcrumbs;
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

    function generateSubMenu($parentId, $userMenus, $guestMode) {
        $subMenuItems = [];
        foreach ($userMenus as $userMenu) {
            if ($userMenu['id_sub'] == $parentId && $userMenu['guest'] == ($guestMode ? 0 : 1)) {
                $menuLabel = $userMenu['name'];
                $menuUrl = [$userMenu['url_controller'] . '/' . $userMenu['url_view']];
                
                // Query untuk mengambil submenu sesuai dengan menu utama
                $subMenus = generateSubMenu($userMenu['id'], $userMenus, $guestMode);
                
                if (!empty($subMenus)) {
                    $subMenuItems[] = [
                        'label' => $menuLabel,
                        'items' => $subMenus,
                        'dropdownOptions' => ['class' => 'dropdown-menu'],
                    ];
                } else {
                    $subMenuItems[] = ['label' => $menuLabel, 'url' => $menuUrl];
                }
            }
        }
        return $subMenuItems;
    }
    
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
    
    foreach ($userMenus as $userMenu) {
        // sub menu level 1
        if ($userMenu['id_sub'] == 0) {
            $menuLabel = $userMenu['name'];
            $menuUrl = [$userMenu['url_controller'] . '/' . $userMenu['url_view']];
    
            $subMenus = generateSubMenu($userMenu['id'], $userMenus, $guestMode);
    
            if (!empty($subMenus)) {
                $menuItems[] = [
                    'label' => $menuLabel,
                    'items' => $subMenus,
                    'dropdownOptions' => ['class' => 'dropdown-menu'],
                ];
            } else {
                $menuItems[] = ['label' => $menuLabel, 'url' => $menuUrl];
            }
        }
    }
    
    // all menu from db automatic sign in here 
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Profile', 'url' => ['/user/view', 'id' => Yii::$app->user->identity->id]];
        $menuItems[] = ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
    }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
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
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>