<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 02.09.17
 * Time: 16:50
 */
?>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <form action="/task/2" method="post">
                <input type="number" min="2" max="1000" name="count" class="form-control" placeholder="Количество записей"><br>
                <input class="btn-default btn" name="random" type="submit" value="Сгенерировать новое случайное дерево">
            </form>
        </div>
        <div class="col-md-8">
            <?php if (isset($data)): ?>
              <b><pre><?= $data; ?></pre></b>
            <?php endif; ?>
        </div>
    </div>
</div>
