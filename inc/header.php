<?php
if (!isset($page_title)) {
    $page_title = 'Cognify';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo esc($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo isset($asset_prefix) ? $asset_prefix : ''; ?>assets/css/style.css">
</head>
<body>

<div class="topbar">
    <div class="container">

        <div class="brand">

            <!-- LOGO IMAGE -->
            <img class="brand-logo"
                 src="<?php echo isset($asset_prefix) ? $asset_prefix : ''; ?>assets/images/logo.png"
                 alt="Cognify Logo">

            <div class="brand-text">
                <div class="brand-title">Cognify</div>
                <div class="small muted">Cognitive Assessment Platform</div>
            </div>

        </div>

        <?php if (!empty($nav_links)) { ?>
        <div class="nav">
            <?php foreach ($nav_links as $link) { ?>
                <a href="<?php echo esc($link['url']); ?>">
                    <?php echo esc($link['label']); ?>
                </a>
            <?php } ?>
        </div>
        <?php } ?>

    </div>
</div>

<div class="container">
<?php show_flash(); ?>