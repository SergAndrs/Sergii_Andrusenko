<?php
require 'src/FileManager.php';

$dir = new File_Manager;
$lists = $dir->index();
if(isset($_GET['dir']) && strlen($_GET['dir']) > 0)
{
    $lists = $dir->init($_GET['dir']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Manager</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</head>

<body>
<div class="back">
    <a href="<?= $dir->getString($_SERVER['DOCUMENT_ROOT']); ?>">Root</a>
    <?php if(isset($_GET['dir'])): ?>
        <a href="?dir="><?= $_GET['dir']; ?></a>
    <?php endif; ?>
</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">File name</th>
                <th scope="col">Type</th>
                <th scope="col">Size</th>
                <th scope="col">Path</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lists as $list): ?>
            <tr>
                <td scope="row">
                    <?php preg_match('/[0-9]/', $list['name']) ?
                        print $list['name'] :
                        print "<a href=\"{$dir->makeLink($list['path'])}\">{$list['name']}</a>";
                    ?>
                </td>
                <td scope="row"><?= $list['type']; ?></td>
                <td scope="row"><?= $list['size']; ?></td>
                <td scope="row">/<?= $list['path']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>