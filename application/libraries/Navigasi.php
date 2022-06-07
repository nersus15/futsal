<?php
    class Navigasi {
        function get_navigasi($id = null, $permission = array()){
            /** CI_Controller @var CI_Controller */
            $ci =& get_instance();

            /** @var Datatables */
            $ci->load->library('Datatables');


            $query = $ci->db->from('menu')
                ->join('menu_permission', 'menu_permission.menu = menu.id')
                ->join('permission', 'menu_permission.permission = permission.id');

            // if(!empty($id))
            //     $query->where('menu.id', $id);
            // if(!empty($permission))
            //     $query->where_in('permission.id', $permission);

            // $menu = $query->get('menu')->result();
            // $tmp = [];
            // foreach($menu as $v){
            //     if(!isset($tmp[$v->id])){
            //         $v->permission =[$v->nama_permission];
            //         $tmp[$v->id] = $v;
            //     }
            //     else
            //         $tmp[$v->id]->permission[] = $v->nama_permission;
            // }
            // $menu = [];
            // foreach($tmp as $v){
            //     $menu[] = $v;
            // }

            $ci->datatables->set_resultHandler(function($data, $compiledData){
                $tmp = [];
                foreach($compiledData as $v){
                    if(!isset($tmp[$v->id])){
                        $v->permission =[$v->nama_permission];
                        $tmp[$v->id] = $v;
                    }
                    else
                        $tmp[$v->id]->permission[] = $v->nama_permission;
                }
                $menu = [];
                foreach($tmp as $v){
                    $menu[] = $v;
                }
                return $menu;
            });
            
            $header = array(
                'id' => array('searchable' => 'menu.id'),
                'nama' => array('searchable' => 'menu.nama'),
                'url' => array('searchable' => true),
                'level' => array('searchable' => 'lvl', 'field' => 'lvl'),
                'induk' => array('searchable' => 'parrent_element', 'field' => 'parrent_element'),
                'aktif' => array('searchable' => true),
                'nama_permission' => array('searchable' => 'permission.nama', 'field' => 'nama_permission'),
            );
            

            $ci->datatables->setHeader($header)
                ->addSelect('menu.*, permission.nama as nama_permission')
                ->setQuery($query);
            $data =  $ci->datatables->getData();
            response($data);


            // return (object) array('data' => $menu);
        }
    }