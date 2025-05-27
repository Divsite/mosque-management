<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'statistics_dashboard');
$this->params['page_title'] = Yii::t('app', 'dashboard');
$this->params['page_desc'] = Yii::t('app', 'all_information_statistics');
$this->params['title_card'] = Yii::t('app', 'all_information_statistics');
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
                <i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="site-index">
            <div class="row" id="dynamic-statistics">
                <?php foreach ($statistics as $key => $jumlah): ?>
                    <?php
                        $colorClass = $statStyles[$key]['color'] ?? 'bg-gradient-info';
                        $icon = $statStyles[$key]['icon'] ?? 'fa-info-circle';
                        $label = Yii::t('app', $key);
                    ?>
                    <div class="col-md-4">
                        <div class="small-box <?= $colorClass ?>">
                            <div class="inner">
                                <p><?= $label ?></p>
                                <h3 class="stat-amount" data-key="<?= $key ?>"><?= $jumlah ?></h3>
                            </div>
                            <div class="icon" data-toggle="tooltip" title="<?= $label ?>"><i class="fa <?= $icon ?>"></i></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Table -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><?= Yii::t('app', 'neighborhood_association') ?></th>
                        <th><?= Yii::t('app', 'total_qurban_coupon') ?></th>
                        <th><?= Yii::t('app', 'total_claim_qurban_coupon') ?></th>
                        <th><?= Yii::t('app', 'total_not_claim_qurban_coupon') ?></th>
                    </tr>
                </thead>
                <tbody id="table-details-body">
                    <?php foreach ($details as $receiver => $data): ?>
                        <?php
                            $rowClass = $data['not_claimed'] > 0 ? 'table-warning' : 'table-success';
                            $percent = $data['total'] > 0 ? round(($data['claimed'] / $data['total']) * 100) : 0;
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $receiver ?></td>
                            <td><?= $data['total'] ?></td>
                            <td><?= $data['claimed'] ?> (<?= $percent ?>%)</td>
                            <td><?= $data['not_claimed'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="text-muted small mt-3">
                <?= Yii::t('app', 'last_updated') ?>: <span id="last-update-time"><?= date('H:i:s') ?></span>
            </p>
        </div>
    </div>
</div>

<?php
$urlTrace = Url::to(['receiver/refresh-statistics'], true);

$js = <<< JS
function animateNumber(\$el, newVal) {
    const currentVal = parseInt(\$el.text());
    \$({ val: currentVal }).animate({ val: newVal }, {
        duration: 500,
        step: function (now) {
            \$el.text(Math.floor(now));
        },
        complete: function () {
            \$el.text(newVal);
        }
    });
}

function refreshStatistics() {
    $('#table-details-body, #dynamic-statistics').addClass('opacity-50');

    $.ajax({
        url: '{$urlTrace}',
        type: 'GET',
        success: function(data) {
            $('.stat-amount').each(function() {
                let key = $(this).data('key');
                if (data.statistics[key] !== undefined) {
                    animateNumber($(this), data.statistics[key]);
                }
            });

            let tbody = '';
            $.each(data.details, function(receiver, val) {
                let rowClass = val.not_claimed > 0 ? 'table-warning' : 'table-success';
                let percent = val.total > 0 ? Math.round((val.claimed / val.total) * 100) : 0;

                tbody += '<tr class="' + rowClass + '">' +
                        '<td>' + receiver + '</td>' +
                        '<td>' + val.total + '</td>' +
                        '<td>' + val.claimed + ' (' + percent + '%)</td>' +
                        '<td>' + val.not_claimed + '</td>' +
                        '</tr>';
            });

            $('#table-details-body').html(tbody);

            let now = new Date();
            let formatted = now.toLocaleTimeString();
            $('#last-update-time').text(formatted);

            $('[data-toggle="tooltip"]').tooltip();
        },
        complete: function() {
            $('#table-details-body, #dynamic-statistics').removeClass('opacity-50');
        },
        error: function() {
            console.error("Failed to fetch updated statistics.");
        }
    });
}

setInterval(refreshStatistics, 10000);

JS;

$css = <<< CSS
.opacity-50 {
    opacity: 0.5;
    transition: opacity 0.3s ease-in-out;
}
CSS;

$this->registerJs($js);
$this->registerCss($css);
?>
