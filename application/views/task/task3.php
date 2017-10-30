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
            <form action="/task/3" method="post">
                Пример ввода: <br>
                a1,a2,a3,a4<br>
                b1,b2,b3<br>
                c1,c2<br>
                d1,d2,d3,d4<br>
                <textarea name="string" class="form-control" id="string" cols="30" rows="10"
                          placeholder="Текстовое поле для массива данных"></textarea><br>
                <input class="btn-default btn" c type="submit" value="Отправить">
            </form>
        </div>
        <div class="col-md-8">
            <?php if (isset($data)): ?>
                <table class="table table-bordered">
                    <tbody>
                    <?php foreach ($data as $key => $value): ?>
                        <tr>
                            <?php foreach ($value as $item): ?>
                                <td>
                                    <?= $item; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
