<?php
$URL_SPLIT = '://';
$url_pieces = explode($URL_SPLIT, base_url());
$logout_url = $url_pieces[0] . $URL_SPLIT .'logout@' . $url_pieces[1];

echo doctype('html5');
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        <!-- Bootstrap -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">-->
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
        <link href="<?php echo base_url('assets/css/base.css'); ?>" rel="stylesheet" type="text/css" />
        <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico')?>" type="image/ico"/>
    </head>
    <body>
        <!-- site banner, menu would go here -->
        <p class='logout'><a href="<?php echo $logout_url ?>" >logout</a></p>
        <?php echo $content; ?>
        <hr>
        <p style="font-weight:bold">2015</p>
    </body>
</html>
