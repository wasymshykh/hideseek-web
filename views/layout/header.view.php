<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hide Seek</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=URL?>/static/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?=URL?>/static/css/style.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="<?=URL?>/static/js/jquery-3.5.1.min.js"></script>

    <?php if (isset($select2)): ?>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <?php endif; ?>

</head>
<body>


<div class="container mb-4">
    <div class="row">
        <div class="col-12 p-4 d-flex justify-content-between">
            <div class="logo">
                <h3>Hide<b>And</b>Seek</h3>
            </div>
            <div class="">
                <?php if ($logged): ?>
                    <a href="<?=URL?>/settings" class="btn"><i class="fa fa-cogs"></i> settings</a>
                    <a href="<?=URL?>/dashboard" class="btn btn-secondary"><i class="fa fa-th-large"></i> dashboard</a>
                    <a href="<?=URL?>/logout" class="btn"><i class="fa fa-sign-out"></i> logout</a>
                <?php else: ?>
                    <a href="<?=URL?>/" class="btn">login</a>
                    <a href="<?=URL?>/signup" class="btn btn-secondary">signup</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-12 shadow-sm p-3 mb-5 bg-white rounded">
            
            