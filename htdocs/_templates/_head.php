<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Selfmade Ninja Academy">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Photozard</title>

    <!-- Bootstrap core CSS -->
    <link
        href="<?=get_config('base_path')?>assets/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <!-- JS has to be loaded in footer not header as it impacts page load time. -->

    <link rel="stylesheet" href="/css/style.css">

    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] .get_config('base_path').'css/' . basename($_SERVER['PHP_SELF'], ".php") . ".css")) { ?>
    <link
        href="<?=get_config('base_path')?>css/<?= basename($_SERVER['PHP_SELF'], ".php") ?>.css"
        rel="stylesheet">
    <?php } ?>

</head>