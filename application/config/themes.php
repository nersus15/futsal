<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Resource group "main"
$config['themes'] = array(
    'main' => array(
        'js' => array(
            array('pos' => 'head', 'src' => 'vendor/jquery/jquery.min.js'),
            array('pos' => 'head', 'src' => 'vendor/jquery/jquery.form.js'),
            array('pos' => 'head', 'src' => 'vendor/bootstrap/js/popper.min.js'),
            array('pos' => 'head', 'src' => 'vendor/bootstrap/js/bootstrap.min.js'),
            array('pos' => 'head', 'src' => 'vendor/bootstrap/js/bootstrap.bundle.min.js'),
            array('pos' => 'head', 'src' => 'vendor/bootstrap-notify/bootstrap-notify.min.js'),
            array('pos' => 'head', 'src' => 'vendor/jquery-validation/dist/jquery.validate.min.js'),
            array('pos' => 'head', 'src' => 'vendor/jquery-validation/lang/id.js'),
            array('pos' => 'head', 'src' => 'vendor/moment/moment.min.js'),
            array('pos' => 'head', 'src' => 'vendor/kamscore/js/Kamscore.js'),
            array('pos' => 'head', 'src' => 'vendor/kamscore/js/uihelper.js'),
            array('pos' => 'head', 'src' => 'js/utils/navbar.action.js')
        ),
        'css' => array(
            array('pos' => 'head', 'src' => 'vendor/bootstrap/css/bootstrap.min.css'),
            array('pos' => 'head', 'src' => 'vendor/kamscore/css/main.css'),
            array('pos' => 'head', 'src' => 'vendor/fontawesome/css/all.min.css'),
            array('pos' => 'head', 'src' => 'vendor/icon/iconsmind/style.css' ),
            array('pos' => 'head', 'src' => 'vendor/icon/simple-line-icons/css/simple-line-icons.css')
        )
    ), 

    'softui' => array(
        'js' => array(
            array('pos' => 'head', 'src' => 'vendor/fontawesome/js/fontawesome.js'),
            array('pos' => 'head', 'src' => 'themes/softUi/js/plugins/perfect-scrollbar.min.js'),
            array('pos' => 'head', 'src' => 'themes/softUi/js/plugins/smooth-scrollbar.min.js'),
            array('pos' => 'body:end', 'src' => 'themes/softUi/js/soft-ui-dashboard.min.js?v=1.0.3'),
            array('pos' => 'body:end', 'src' => 'themes/softUi/js/script.js'),
        ),
        'css' => array(
            array('pos' => 'head', 'src' => 'themes/softUi/css/nucleo-icons.css'),
            array('pos' => 'head', 'src' => 'themes/softUi/css/nucleo-svg.css'),
            array('pos' => 'head', 'src' => 'themes/softUi/css/soft-ui-dashboard.css?v=1.0.3'),
        )
    ),

    'onix' => array(
        'js' => array(
            array('pos' => 'head', 'src' => 'themes/onix/js/owl-carousel.js'),
            array('pos' => 'head', 'src' => 'themes/onix/js/animation.js'),
            array('pos' => 'head', 'src' => 'themes/onix/js/owl-carousel.js'),
            array('pos' => 'body:end', 'src' => 'themes/onix/js/custom.js'),
        ),
        'css' => array(
            
            array('pos' => 'head', 'src' => 'themes/onix/css/fontawesome.css'),
            array('pos' => 'head', 'src' => 'themes/onix/css/templatemo-onix-digital.css'),
            array('pos' => 'head', 'src' => 'themes/onix/css/animated.css'),
            array('pos' => 'head', 'src' => 'themes/onix/css/owl.css'),
        ),
    ),
    'dore' => array(
        'css' => array(
            array('pos' => 'head', 'src' => 'themes/dore/css/dore.light.green.css'),
            array('pos' => 'head', 'src' => 'themes/dore/css/main.css')
        ),
        'js' => array(
            array('pos' => 'head', 'src' => 'themes/dore/js/script.js'),
            array('pos' => 'head', 'src' => 'themes/dore/js/dore.script.js'),
        )
    ),

    'form' => array(
        'js' => array(
            array('pos' => 'head', 'src' => 'vendor/select2/dist/js/select2.min.js'),
            array('pos' => 'head', 'src' => 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', 'type' => 'cdn'),
            array('pos' => 'head', 'src' => 'vendor/datepicker/js/bootstrap-datepicker.js'),
            array('pos' => 'head', 'src' => 'js/utils/main.init.js'),
        ),
        'css' => array(
            array('pos' => 'head', 'src' => 'vendor/select2/dist/css/select2.css'),
            array('pos' => 'head', 'src' => 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css', 'type' => 'cdn'),
            array('pos' => 'head', 'src' => 'vendor/datepicker/css/datepicker.css'),
        )
    ),

    'datatables' => array(
        'css' => array(
            array('src' => 'vendor/datatables/dataTables.bootstrap4.min.css', 'pos' => 'head'),
            array('src' => 'vendor/datatables/datatables.responsive.bootstrap4.min.css', 'pos' => 'head'),
            // array('src' => 'vendor/datatables/jquery.dataTables.min.css', 'pos' => 'head'),
            array('src' => 'vendor/datatables/select.dataTables.css', 'pos' => 'head'),
            array('pos' => 'head', 'src' => 'vendor/dt-checkbox/css/dataTables.checkboxes.css'),

        ),
        'js' => array(
            array('pos' => 'head', 'src' => 'vendor/datatables/datatables.min.js'),
            array('pos' => 'head', 'src' => 'vendor/datatables/buttons.datatables.js'),
            array('pos' => 'head', 'src' => 'vendor/datatables/dt.select.js'),
            array('pos' => 'head', 'src' => 'vendor/datatables/btn.zip.js'),
            array('pos' => 'head', 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', 'type' => 'cdn'),
            array('pos' => 'head', 'src' => 'vendor/datatables/btn.pfs.js'),
            array('pos' => 'head', 'src' => 'vendor/datatables/btn.html-buttons.js'),
            array('pos' => 'head', 'src' => 'vendor/datatables/btn.print.js'),
            array('pos' => 'head', 'src' => 'vendor/dt-checkbox/js/dataTables.checkboxes.min.js'),
            array('pos' => 'head', 'src' => 'https://cdn.datatables.net/fixedcolumns/4.0.0/js/dataTables.fixedColumns.min.js', 'type' => 'cdn'),
            // array('pos' => 'head', 'src' => 'vendor/datatables/jquery.dataTables.min.js'),
            // array('pos' => 'head', 'src' => 'vendor/datatables/dataTables.select.min.js'),
        )
    ), 
    'icon' => array(
        'js' => [],
        'css' => [
            array('pos' => 'head', 'src' => 'vendor/fontawesome/css/all.min.css'),
            array('pos' => 'head', 'src' => 'vendor/icon/iconsmind/style.css' ),
            array('pos' => 'head', 'src' => 'vendor/icon/simple-line-icons/css/simple-line-icons.css')
        ]
    ),

    'heremap' => array(
        'js' => [
            array('pos' => 'head', 'src' => 'https://js.api.here.com/v3/3.1/mapsjs-core.js', 'type' => 'cdn'),
            array('pos' => 'head', 'src' => 'https://js.api.here.com/v3/3.1/mapsjs-service.js', 'type' => 'cdn'),
            array('pos' => 'head', 'src' => 'https://js.api.here.com/v3/3.1/mapsjs-ui.js', 'type' => 'cdn'),
            array('pos' => 'head', 'src' => 'https://js.api.here.com/v3/3.1/mapsjs-mapevents.js', 'type' => 'cdn'),
        ],
        'css' => [
            array('pos' => 'head', 'src' => 'https://js.api.here.com/v3/3.1/mapsjs-ui.css', 'type' => 'cdn')
        ]
    ),
);