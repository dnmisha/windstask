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
            <form action="/task/1" method="post">
                <textarea name="string" class="form-control" id="string" cols="30" rows="10"
                          placeholder="Текстовое поле для текста с тегами"></textarea><br>
                <input class="btn-default btn" c type="submit" value="Отправить">
            </form>
        </div>
        <div class="col-md-8">
            <?php if (isset($data)): ?>

                <?php foreach ($data as $key => $value): ?>
                    <h4><?= $key; ?></h4>
                    <table class="table table-bordered">
                        <tbody>
                        <?php foreach ($value as $keyValue => $item): ?>
                            <tr>
                                <th> [<?= $keyValue; ?>]</th>
                                <td>
                                    <?= $item; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>
</div>
