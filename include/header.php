<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$__config['title'][PAGE_TYPE]?><?php if(PAGE_TYPE =="production") echo " || ".$production['name']?></title>
    <base href="<?=$__config['urlBase']?>/">
    <link href="template/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="template/css/animate.css" rel="stylesheet">
    <link href="template/css/style.css" rel="stylesheet">

<?php switch (PAGE_TYPE) {
        case 'search':
            ?>
    <link href="template/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="template/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">>
            <?php
            break;
        case 'production':
            ?> 
    <link href="template/css/plugins/slick/slick.css" rel="stylesheet">
    <link href="template/css/plugins/slick/slick-theme.css" rel="stylesheet">
            <?php
            break;

        case 'insert':
            ?>
    <link href="template/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="template/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

    <link href="template/css/plugins/cropper/cropper.min.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="template/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
            <?php
            break;
        default:
            # code...
            break;
    } ?>

</head>
