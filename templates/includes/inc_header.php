<!DOCTYPE html>
<html lang="<?php echo SITE_LANG; ?>">

<head>
  <!-- Add basepath to define from where the links should be generated and the file loading -->
  <base href="<?php echo BASEPATH; ?>">

  <meta charset="UTF-8">

  <title><?php echo isset($d->title) ? $d->title . ' - ' . get_sitename() : 'Welcome - ' . get_sitename(); ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Site favicon -->
  <?php echo get_favicon(); ?>

  <!-- inc_styles.php -->
  <?php require_once INCLUDES . 'inc_styles.php'; ?>
</head>

<body class="<?php echo isset($d->bg) && $d->bg === 'dark' ? 'bg-dark' : 'bg-light' ?>"
  style="<?php echo 'padding: ' . (isset($d->padding) ? $d->padding : '200px 0px'); ?>">
  <!-- ends inc_header.php -->