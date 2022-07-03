<footer class="site-footer">
    <div class="footer-content-area">
        <div class="container">
            <div class="footer-widgets">
                <div class="row justify-content-between">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="widget about-widget">
                            <div class="footer-logo">
                                <img src="<?= base_url('public/assets/themes/funden') ?>/img/logo-white.png" alt="Funden">
                            </div>
                            <p>
                                Sed ut perspiciatis unde omn iste natus error sit voluptatem
                            </p>
                            <div class="newsletter-form">
                                <h5 class="form-title">Join Newsletters</h5>
                                <form action="#">
                                    <input type="text" placeholder="Email Address">
                                    <button type="submit"><i class="far fa-arrow-right"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                                        <div class="col-lg-2 col-md-5 col-sm-6">
                        <div class="widget nav-widget">
                            <h4 class="widget-title">Our Projects</h4>
                            <ul>
                                <li><a href="project-1.html">Medical & Health</a></li>
                                <li><a href="project-2.html">Educations</a></li>
                                <li><a href="project-1.html">Technology</a></li>
                                <li><a href="project-3.html">Web Development</a></li>
                                <li><a href="project-2.html">Food & Clothes</a></li>
                                <li><a href="project-1.html">Video & Movies</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="widget nav-widget">
                            <h4 class="widget-title">Support</h4>
                            <ul>
                                <li><a href="about.html">Privacy Policy</a></li>
                                <li><a href="contact.html">Conditions</a></li>
                                <li><a href="company-overview.html">Company</a></li>
                                <li><a href="faq.html">Faq & Terms</a></li>
                                <li><a href="contact.html">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-auto col-md-5 col-sm-8">
                        <div class="widget contact-widget">
                            <h4 class="widget-title">Contact Us</h4>
                            <ul class="info-list">
                                <li>
                                    <span class="icon"><i class="far fa-phone"></i></span>
                                    <span class="info">
                                        <span class="info-title">Phone Number</span>
                                        <a href="#">+012(345) 78 93</a>
                                    </span>
                                </li>
                                <li>
                                    <span class="icon"><i class="far fa-envelope-open"></i></span>
                                    <span class="info">
                                        <span class="info-title">Email Address</span>
                                        <a href="#"><span class="__cf_email__" data-cfemail="a1d2d4d1d1ced3d5e1c6ccc0c8cd8fc2cecc">[email&#160;protected]</span></a>
                                    </span>
                                </li>
                                <li>
                                    <span class="icon"><i class="far fa-map-marker-alt"></i></span>
                                    <span class="info">
                                        <span class="info-title">Locations</span>
                                        <a href="#">59 Main Street, USA</a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-area">
                <div class="row flex-md-row-reverse">
                    <div class="col-md-6">
                        <ul class="social-icons">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="#"><i class="fab fa-behance"></i></a></li>
                            <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <p class="copyright-text">© 2021 <a href="#">Funden</a>. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
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