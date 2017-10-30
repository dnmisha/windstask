<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 02.09.17
 * Time: 15:16
 */
?>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/"><?=MvcKernel::$app->getAppName();?></a>
        </div>
        <ul class="nav navbar-nav pull-right">
            <li><a href="/">Home</a></li>
            <li><a href="/task/1">Task one</a></li>
            <li><a href="/task/2">Task two</a></li>
            <li><a href="/task/3">Task three</a></li>
        </ul>
    </div>
</nav>