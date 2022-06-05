<?php
    if (isset($resource) && !empty($resource)) {
        foreach ($resource as $k => $v) {
            echo addResourceGroup($v, null, 'body:end');
        }
    }
    if(isset($extra_js) && !empty($extra_js)){
        foreach($extra_js as $js){
            if(!isset($js['attr']))
                $js['attr'] = null;

            if($js['pos'] == 'body:end' && $js['type'] == 'file')
                echo '<script src="' . base_url('public/assets/' . $js['src']) . '"></script>';
            elseif($js['pos'] == 'body:end' && $js['type'] == 'cache')
                echo '<script type="application/javascript" src="' . base_url('public/assets/' . $js['src']) . '"></script>';
            elseif($js['pos'] == 'body:end' && $js['type'] == 'inline'){
                echo '<script async type="application/javascript">' . $js['script'] . '</script>';
            }
            elseif($js['pos'] == 'body:end' && $js['type'] == 'cdn')
                echo '<script src="' . $js['src'] . '"'. $js['attr'] .'></script>';
        }
    }

    if(isset($extra_css) && !empty($extra_css)){
        foreach($extra_css as $css){
            if(!isset($css['attr']))
                $css['attr'] = null;
                
            if($css['pos'] == 'body:end' && $css['type'] == 'file')
                echo '<link rel="stylesheet" href="' . base_url('public/assets/' . $css['src']) . '"></link>';
            elseif($css['pos'] == 'body:end' && $css['type'] == 'inline'){
                echo '<style>' . $css['style'] . '</style>';
            }
            elseif($css['pos'] == 'body:end' && $css['type'] == 'cdn')
                echo '<link rel="stylesheet" href="' . $css['src'] . '"'. $css['attr'] .'></link>';
        }
    }
?>

<script>
    var adaThemeSelector = <?php echo !empty($adaThemeSelector) ? boolval($adaThemeSelector) : 'false' ?>;
    $(document).ready(function(){
        if(adaThemeSelector && themeSelector && typeof(themeSelector) === "function")
            themeSelector();
        else{
            try {
                $("body").dore();
            } catch (error) {
                
            }
        }
           
    });
</script>
</body>

</html>