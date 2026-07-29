<?php

/** @var \CodeIgniter\Pager\PagerRenderer $pager */
$pager->setSurroundCount(2);
?>

<nav aria-label="Page navigation">
    <ul class="pagination pagination-sm mb-0">
        <!-- Tombol Sebelumnya (Previous) -->
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link text-success rounded-start-3" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                    Sebelumnya
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <span class="page-link rounded-start-3">Sebelumnya</span>
            </li>
        <?php endif ?>

        <!-- List Nomor Halaman -->
        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <?php if ($link['active']) : ?>
                    <span class="page-link bg-success border-success text-white"><?= $link['title'] ?></span>
                <?php else : ?>
                    <a class="page-link text-success" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                <?php endif ?>
            </li>
        <?php endforeach ?>

        <!-- Tombol Berikutnya (Next) -->
        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link text-success rounded-end-3" href="<?= $pager->getNext() ?>" aria-label="Next">
                    Berikutnya
                </a>
            </li>
        <?php else : ?>
            <li class="page-item disabled">
                <span class="page-link rounded-end-3">Berikutnya</span>
            </li>
        <?php endif ?>
    </ul>
</nav>