<?php

/** @var yii\web\View $this */

$this->title = 'Localloop';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Congratulations!</h1>
            <p class="fs-5 fw-light">You have successfully created your Yii-powered application.</p>
            <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Get started with Yii</a></p>
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <?php foreach ($advertisements as $advertisement): ?>
                <div class="col-lg-4">
                    <a href="<?= \yii\helpers\Url::to(['advertisement/view', 'id' => $advertisement->id]) ?>" class="card-click">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="<?php /* \yii\helpers\Html::encode($advertisement->image_url) */ ?>" class="img-fluid rounded-start" alt="<?= \yii\helpers\Html::encode($advertisement->title) ?>">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= \yii\helpers\Html::encode($advertisement->title) ?></h5>
                                        <p class="card-text"><?= \yii\helpers\Html::encode($advertisement->description) ?></p>
                                        <p class="card-text"><small class="text-body-secondary">Created <?= Yii::$app->formatter->asRelativeTime($advertisement->created_at) ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<?php
// Verifique se há uma flash message de sucesso
if (Yii::$app->session->hasFlash('success')) {
    $this->registerJs("
            $('#toastMessage').text('Info updated with success!!')
            showToast();
    ");
}
?>