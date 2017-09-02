<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 02.09.17
 * Time: 15:17
 */
use Mvc\Core\Base\BaseView;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= MvcKernel::$app->getAppName(); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= BaseView::renderAssets()->css; ?>
</head>
<body>
<?= BaseView::renderPartial('header'); ?>
<div class="container">
    <hr>
    <?= $content; ?>
    <hr>
</div>

<?= BaseView::renderPartial('footer'); ?>
<?= BaseView::renderAssets()->js; ?>
</body>
</html>
