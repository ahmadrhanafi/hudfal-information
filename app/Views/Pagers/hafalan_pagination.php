<?php

/** @var \CodeIgniter\Pager\PagerRenderer $pager */
$pager->setSurroundCount(2);
?>

<nav aria-label="Page navigation">
    <ul class="pagination pagination-sm mb-0">
        <!-- List Nomor Halaman Saja -->
        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <?php if ($link['active']) : ?>
                    <span class="page-link bg-success border-success text-white px-3"><?= $link['title'] ?></span>
                <?php else : ?>
                    <a class="page-link text-success px-3" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                <?php endif ?>
            </li>
        <?php endforeach ?>
    </ul>
</nav>