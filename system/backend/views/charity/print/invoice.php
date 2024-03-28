<?php
$this->title = Yii::t('app', 'invoice');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-container">
    <div class="header">
        <div class="logo">
            <img src="<?= $branchImage ?>" width="80" height="80">
        </div>
        <div class="branch-info">
            <div class="name"><b><?= $branchName ?></b></div>
            <div class="address"><?= $branchAddress ?></div>
            <div class="address"><?= Yii::t('app', 'telp') . ' : ' . $branchTelp ?></div>
        </div>
        <div class="content">
            <hr>
                <p class="title"><?= strtoupper(Yii::t('app', 'proof_of_payment') . ' ' . $model->charityType->charitySource->name) ?></p>
            <hr>
            <table class="info">
                <tr>
                    <td><?= Yii::t('app', 'customer_name') ?></td>
                    <td>:</td>
                    <td><?= $charity->customer_name ?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('app', 'total_rice') ?></td>
                    <td>:</td>
                    <td><?= $charity->total_rice .' Liter' ?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('app', 'money') ?></td>
                    <td>:</td>
                    <td><?= Yii::$app->formatter->asCurrency($charity->payment_total, 'IDR') ?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('app', 'payment_date') ?></td>
                    <td>:</td>
                    <td><?= $charity->payment_date ?></td>
                </tr>
            </table>
            <div class="customer-address">
                <?= $charity->customer_address ?>
            </div>
        </div>
        <div class="footer">
            <div class="contact-info">
                <div>
                    <?= Yii::t('app', 'if_you_have_any_questions_dont_hesitate_to_contact_the_admin_or_customer_service') ?>
                </div>
            </div>
        </div>
    </div>
</div>
