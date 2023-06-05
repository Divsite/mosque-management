<?php

use backend\models\Division;
use backend\models\EventFollow;
use yii\helpers\Html;
use backend\models\User;
use backend\models\VolunteerProfile;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$this->params['page_title'] = 'Dashboard';
$this->params['page_desc'] = 'Yii2-Webapps';
$this->params['title_card'] = 'Information';

?>
<div class="row" style="margin: 3px;">
    <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(User::getCountEquipmentDivision()); ?></h3>
            <p>Divisi Peralatan</p>
            </div>
            <div class="icon">
            <i class="fa fa-book"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= Yii::$app->formatter->asInteger(User::getCountSecurityDivision()); ?><sup style="font-size: 20px"></sup></h3>
                <p>Divisi Keamanan</p>
            </div>
            <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    </div>
    
    <div class="col-lg-4 col-xs-6">
    
        <div class="small-box bg-orange">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(User::getCountConsumptionDivision()); ?></h3>
            <p>Divisi Komsumsi</p>
            </div>
            <div class="icon">
            <i class="fa fa-exchange"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row" style="margin: 3px;">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(User::getCountVolunteer()) ?></h3>
            <p>Jumlah Peserta</p>
            </div>
            <div class="icon">
            <i class="fa fa-book"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(VolunteerProfile::getCountFemaleGender()); ?></h3>
            <p>Jumlah Peserta Perempuan</p>
            </div>
            <div class="icon">
            <i class="fa fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-orange">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(VolunteerProfile::getCountMaleGender()); ?></h3>
            <p>Jumlah Peserta Laki</p>
            </div>
            <div class="icon">
            <i class="fa fa-exchange"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(VolunteerProfile::getCountNonMoslem()); ?></h3>
            <p>Jumlah Non Muslim</p>
            </div>
            <div class="icon">
            <i class="fa fa-bookmark"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row" style="margin: 3px;">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(User::getCountCompanionDivision()); ?></h3>
            <p>Divisi Pendamping</p>
            </div>
            <div class="icon">
            <i class="fa fa-book"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= Yii::$app->formatter->asInteger(User::getCountPublicationDivision()); ?><sup style="font-size: 20px"></sup></h3>
                <p>Divisi Publikasi</p>
            </div>
            <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
    </div>
    
    <div class="col-lg-3 col-xs-6">
    
        <div class="small-box bg-orange">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(User::getCountDocumentationDivision()); ?></h3>
            <p>Divisi Dokumentasi</p>
            </div>
            <div class="icon">
            <i class="fa fa-exchange"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
    
        <div class="small-box bg-red">
            <div class="inner">
            <h3><?= Yii::$app->formatter->asInteger(User::getCountMedicalDivision()); ?></h3>
            <p>Divisi Medis</p>
            </div>
            <div class="icon">
            <i class="fa fa-bookmark"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<?php if (Yii::$app->user->identity->level === 'a7fcbeefd3d80e0d1402b9a0c2dcbaeb') : // Pimpinan Level?>
<div class="row">
    <div class="col-sm-12">
        <div class="box-header with-border">
        <!-- <h3 class="box-title">Relawan Berdasarkan Divisi</h3> -->
        </div>
        <div class="box-body">
        <?= Highcharts::widget([
            'options' => [
            'credits' => false,
            'title' => ['text' => 'Divisi'],
            'exporting' => ['enabled' => true],
            'plotOptions' => [
                'pie' => [
                'cursor' => 'pointer',
                ],
            ],
            'series' => [
                [
                'type' => 'pie',
                'name' => 'Total',
                'data' => Division::getGrafikList(),
                ],
            ],
            ],
        ]);?>
        </div>
    </div>
</div>
<?php endif ?>
<?php if (Yii::$app->user->identity->level === '6fb4f22992a0d164b77267fde5477248'): // LEVEL_ADMIN_ONLY ?>

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"># Link Shortcuts</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
                <i class="fas fa-expand"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">

            <div class="body-content">

                <div class="row">

                    <?php

                        $fulllist = [];
                        $controllerlist = [];

                        if ($handle = opendir(Yii::getAlias('@app/controllers'))) 
                        {
                            while (false !== ($file = readdir($handle))) 
                            {
                                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') 
                                {
                                    $controllerlist[] = $file;
                                }
                            }

                            closedir($handle);
                        }

                        asort($controllerlist);
                        
                        foreach ($controllerlist as $controller)
                        {
                            $handle = fopen(Yii::getAlias('@app/controllers') . '/' . $controller, "r");

                            if ($handle) 
                            {
                                while (($line = fgets($handle)) !== false) 
                                {
                                    if (preg_match('/public function action(.*?)\(/', $line, $action))
                                    {
                                        if (strlen($action[1]) > 2)
                                        {
                                            $controller_fix       = preg_replace('/Controller.php/', '', $controller);
                                            $controller_divide    = preg_split('/(?=[A-Z])/', $controller_fix, -1, PREG_SPLIT_NO_EMPTY);
                                            $controller_divide_   = isset($controller_divide) && is_array($controller_divide) ? $controller_divide : [];
                                            $controller_lowletter = strtolower(implode('-', $controller_divide_));
                                            $action_divide        = preg_split('/(?=[A-Z])/', trim($action[1]), -1, PREG_SPLIT_NO_EMPTY);
                                            $action_divide_       = isset($action_divide) && is_array($action_divide) ? $action_divide : [];
                                            $action_lowletter     = strtolower(implode('-', $action_divide_));
                                            if (in_array($action_lowletter, ['index','create','input','info','control']))
                                            {
                                                $fulllist[$controller_lowletter][] = $action_lowletter;
                                            }
                                        }
                                    }
                                }
                            }

                            fclose($handle);
                        }

                        $count      = 0;
                        $devide     = 2;
                        $totalcount = count($fulllist);
                        $percount   = round($totalcount / $devide);

                        foreach ($fulllist as $key => $value) 
                        {
                            $what = ucwords(str_replace('-', ' ', $key));
                            $whatif = substr($what, 0, 30);
                            
                            if ($count % $percount == 0) 
                            {   
                                echo '<div class="col-lg-' . round(12 / $devide) . '">';
                                echo '<div class="table-responsive table-nowrap">';
                                echo '<table class="table table-bordered">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th Width="10">No.</th>';
                                echo '<th>Name</th>';
                                echo '<th>Action</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                            }

                            echo '<tr>';
                            echo '<td>' . ($count + 1) . '</td>';
                            echo '<td>' . $what . '</td>';
                            echo '<td>';

                            foreach ($value as $key2 => $value) 
                            {
                                echo Html::a('<i class="fa fa-external-link-alt"></i>&nbsp;' . ucfirst($value), [$key.'/'.$value], ['target' => '_blank']);
                                echo '&nbsp;&nbsp;&nbsp;';
                            }

                            echo '</td>';
                            echo '</tr>';

                            if ($count % $percount == ($percount-1)) 
                            {
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                                echo '</div>';
                            }

                            /*if ($count % $totalcount == ($totalcount-1)) 
                            {
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>';
                                echo '</div>';
                            }*/

                            $count++;
                        }
                    ?>

                    <!-- FIX --> </div> <!-- FIX --> 

                </div>

            </div>
                
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="text-center"><i>Created and Designed by <a href="https://samsul-hadi.vercel.app/" target="_blank">@sams</a></i></div>
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

<?php endif; ?>

<?php

$js = <<< JS

JS;

$css = <<< CSS

CSS;

$this->registerJs($js);
$this->registerCss($css);

?>
