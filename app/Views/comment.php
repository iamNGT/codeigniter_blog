<?php if (count($comments) > 0): ?>
<?php foreach ($comments as $item) :  ?>
    <table class="table">
        <tbody>
            <tr>
                <td><?= $item->name ?></td>
                <td><?= $item->description ?></td>
            </tr>
        </tbody>
    </table>
<?php endforeach ?>
<?php else :?>
    <span>no comment</span>
<?php endif ?>
