<?php

class Renderer
{
    protected $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function addViews($views, $params = null)
    {
        /**
         * @var CI_Controller
         */
        if (is_array($views)) {
            foreach ($views as $v)
                $this->CI->views[] = $v;
        } else
            $this->CI->views[] = $views;

        if (!is_array($params))
            $this->CI->setParams($params, 'params');
        else {
            foreach ($params as $k => $v) {
                $this->CI->setParams($v, $k);
            }
        }
    }
    function add_javascript($js)
    {
        if (isset($js['pos'])) {
            $this->CI->setParams($js, 'extra_js', true);
        } else {
            foreach ($js as $j) {
                $this->CI->setParams($j, 'extra_js', true);
            }
        }
    }

    function add_cachedJavascript($js, $type = 'file', $pos = "body:end", $data = array())
    {
        try {
            if ($type == 'file') {
                ob_start();
                if (!empty($data))
                    extract($data);

                include_once ASSETS_PATH . 'js/' . $js . '.js';
            }
            $params = array(
                'script' => $type == 'file' ? ob_get_contents() : $js,
                'type' => 'inline',
                'pos' => 'body:end'
            );
            $this->CI->setParams($params, 'extra_js', true);
            if ($type == 'file')
                ob_end_clean();
        } catch (\Throwable $th) {
            print_r($th);
        }
    }
    function add_cachedStylesheet($css, $type = 'file', $pos = 'head', $data = array())
    {
        if ($type == 'file') {
            ob_start();
            if (!empty($data))
                extract($data);
            try {
                include_once ASSETS_PATH . 'css/' . $css . '.css';
            } catch (\Throwable $th) {
                print_r($th);
            }
        }

        $params = array(
            'style' => $type == 'file' ? ob_get_contents() : $css,
            'type' => 'inline',
            'pos' => $pos
        );
        $this->CI->setParams($params, 'extra_css', true);
        if ($type == 'file')
            ob_end_clean();
    }
    function add_stylesheet($css)
    {
        if (isset($css['pos'])) {
            $this->CI->setParams($css, 'extra_css', true);
        } else {
            foreach ($css as $c) {
                $this->CI->setParams($c, 'extra_css', true);
            }
        }
    }
}
