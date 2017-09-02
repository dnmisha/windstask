<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 01.09.17
 * Time: 15:17
 */
use Mvc\Core\Base\BaseView;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=MvcKernel::$app->getAppName();?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= BaseView::renderAssets()->css;?>
</head>
<body>
<div class="container">
    <?= BaseView::renderPartial('header');?>
    <?= $content;?>
    <?= BaseView::renderPartial('footer');?>
</div>
<?= BaseView::renderAssets()->js;?>
</body>
</html>
