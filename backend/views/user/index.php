<?php

/**
 * @var $data
 * @var $params 'global variable' -> set it in common/config/params-local.php witch is a gitignore file
 */

$sort = 'asc';
if (isset($_GET['sort']) && $_GET['sort'] === 'asc') {
    $sort = 'desc';
}

$currentUrl = '';
if (isset($_GET['sortBy'])) {
    $currentUrl .= "&sortBy={$_GET['sortBy']}";
}
if (isset($_GET['sort'])) {
    $currentUrl .= "&sort={$_GET['sort']}";
}
?>

<link rel="stylesheet" type="text/css" href="../../web/css/user.css">

<div class="user-index">
    <h1>Users</h1>
    <button class="export-csv" id="export_csv">Export all</button>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th><a href="/user/index?sortBy=name&sort=<?php echo $sort ?>" id="name_column">Name</a></th>
            <th><a href="/user/index?sortBy=email&sort=<?php echo $sort ?>" id="email_column">Email</a</th>
            <th>Image</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($data['users'] as $user) { ?>
            <tr>
                <td><?php echo $user['id'] ?></td>
                <td><?php echo $user['name'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td>
                    <a href="#" class="image-link">
                        <img src="<?php echo "{$params['frontendUrl']}/web/images/{$user['image']}"; ?>"
                             alt="<?php echo $user['image']; ?>">
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php if ((int)$data['currentPage'] > 1) { ?>
            <a href="?page=<?php echo ((int)$data['currentPage'] - 1) . $currentUrl ?>">Previous</a>
        <?php } else { ?>
            <span class="disabled">Previous</span>
        <?php } ?>

        <?php for ($i = 1; $i <= $data['totalPages']; $i++) { ?>
            <?php if ($i === (int)$data['currentPage']) { ?>
                <a href="?page=<?php echo $i . $currentUrl ?>" class="active"><?php echo $i; ?></a>
            <?php } else { ?>
                <a href="?page=<?php echo $i . $currentUrl ?>"><?php echo $i; ?></a>
            <?php } ?>
        <?php } ?>

        <?php if ((int)$data['currentPage'] < $data['totalPages']) { ?>
            <a href="?page=<?php echo ((int)$data['currentPage'] + 1) . $currentUrl ?>">Next</a>
        <?php } else { ?>
            <span class="disabled">Next</span>
        <?php } ?>
    </div>
</div>

<!-- Modal window for images -->
<div id="image_modal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modal_image" alt="modal-image">
</div>

<script src="../../web/js/jquery.min.js"></script>
<script src="../../web/js/user.js"></script>

