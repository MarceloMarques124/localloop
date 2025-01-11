<?php

use yii\helpers\Html;

$this->title = 'Favorites List';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Anúncios do Usuário -->
<div class="user-advertisements">
    <div class="row">
        <?php foreach ($userAdvertisements as $advertisement): ?>
            <div class="col-lg-4 mb-4">
                <a href="<?= \yii\helpers\Url::to(['advertisement/page', 'id' => $advertisement->id]) ?>" class="card-click">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-truncate"><?= Html::encode($advertisement->title) ?></h5>
                                    <p class="card-text text-truncate"><?= Html::encode($advertisement->description) ?></p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Criado <?= Yii::$app->formatter->asRelativeTime($advertisement->created_at) ?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>