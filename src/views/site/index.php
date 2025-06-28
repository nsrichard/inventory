<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Demo de gestión de catálogo!</h1>

        <p class="lead">By: Richard Cuizara.</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <p>
                    <?= Html::a('ver Productos', ['site/products'], ['class' => 'btn btn-outline-secondary']) ?>
                </p>
            </div>
            <div class="col-lg-4 mb-3">
                <p>
                    <?= Html::a('ver Categorías', ['site/categories'], ['class' => 'btn btn-outline-secondary']) ?>
                </p>
            </div>
        </div>

    </div>
</div>
