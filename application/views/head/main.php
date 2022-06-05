<!DOCTYPE html>
<html lang="id">
<?php 
    $manifest = json_decode(file_get_contents(DOCS_PATH . "manifest.json"));
    
?>
<head>
    
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website" >
    <meta name="description" content="<?php echo isset($desc) ? $desc : $manifest->description?>">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <?php if(!empty($manifest->keywords)):
        foreach($manifest->keywords as $key):?>
            <meta name="keywords" content="<?= $key ?>">
    <?php endforeach;endif?>
    <meta property="og:title" content="<?php echo isset($konten) ? $konten : $manifest->title ?>">
    <meta property="og:description" content="<?php echo isset($desc) ? $desc : $manifest->description?>">
    <meta property="og:url" content="<?php echo base_url() ?>">
    <?php if(isset($thumb) || isset($manifest->image)): ?>
        <meta property="og:image" content="<?php echo isset($thumb) ? base_url($thumb)  : base_url($manifest->image) ?>">
    <?php endif?>
    <meta property="og:image:width" content="2250" />
    <meta property="og:image:height" content="2250" />
    <?php if(isset($manifest->image)): ?>
    <link rel="icon" type="image/gif" href="<?php echo !empty($manifest) && isset($manifest->image) ? base_url( $manifest->image ) : null ?>">
    <?php endif?>
    <title><?php echo isset($title) ? $title : $manifest->title; ?></title>

    <?php
    if (isset($resource) && !empty($resource)) {
        foreach ($resource as $k => $v) {
            echo addResourceGroup($v);
        }
    }
    if (isset($extra_js) && !empty($extra_js)) {
        foreach ($extra_js as $js) {
            if(!isset($js['attr']))
                $js['attr'] = null;
                
            if ($js['pos'] == 'head' && $js['type'] == 'file')
                echo '<script src="' . base_url('public/assets/' . $js['src']) . '"></script>';
            elseif ($js['pos'] == 'head' && $js['type'] == 'cache')
                echo '<script type="application/javascript" src="' . base_url('public/assets/' . $js['src']) . '"></script>';
            elseif ($js['pos'] == 'head' && $js['type'] == 'inline') {
                echo '<script>' . $js['script'] . '</script>';
            }
            elseif($js['pos'] == 'head' && $js['type'] == 'cdn')
                echo '<script src="' . $js['src'] . '"'. $js['attr'] .'></script>';
        }
    }

    if (isset($extra_css) && !empty($extra_css)) {
        foreach ($extra_css as $css) {
            if(!isset($css['attr']))
                $css['attr'] = null;

            if ($css['pos'] == 'head' && $css['type'] == 'file')
                echo '<link rel="stylesheet" href="' . base_url('public/assets/' . $css['src']) . '"></link>';
            elseif ($css['pos'] == 'head' && $css['type'] == 'inline') {
                echo '<style>' . $css['style'] . '</style>';
            }
            elseif($css['pos'] == 'head' && $css['type'] == 'cdn')
                echo '<link rel="stylesheet" href="' .  $css['src'] . '" '. $css['attr'] .'></link>';

        }
    }
    ?>
    <script>
        var path = location.origin + '/';
        var data_dari_siswa = ['4101', '4102', '4103'];
        var kas_kecil = ['K01', 'K02', 'K03', 'K04', 'K05'];
    </script>
</head>

<body id="app-container" class="<?php echo isset($sembunyikanSidebar) && $sembunyikanSidebar ? 'menu-hidden' : 'menu-default';?> show-spinner">
    <div class="c-overlay">
        <div class="c-overlay-text">Loading</div>
    </div>