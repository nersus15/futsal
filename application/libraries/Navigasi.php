<?php
    class Navigasi {
        function get_navigasi($id = null, $filter = array()){
            /** CI_Controller @var CI_Controller */
            $ci =& get_instance();

            /** @var Datatables */
            $ci->load->library('Datatables');


            $query = $ci->db->from('menu')
                ->join('menu_permission', 'menu_permission.menu = menu.id', 'left')
                ->join('permission', 'menu_permission.permission = permission.id', 'left');

            if(!empty($filter)){
                extract($filter);
                if(isset($jenis))
                    $query->where('parrent_element', $jenis);
                if(isset($level))
                    $query->where('lvl', $level);


                if(isset($dt) && $dt == 0){
                    $query->select('menu.*, permission.nama as nama_permission, permission.id as id_permission');
                    $compiledData = $query->get()->result();
                    $tmp = [];
                    foreach($compiledData as $v){
                        if(!isset($tmp[$v->id])){
                            $v->permission =[$v->nama_permission];
                            $v->id_permission = [$v->id_permission];
                            $tmp[$v->id] = $v;
                        }
                        else{
                            $tmp[$v->id]->permission[] = $v->nama_permission;
                            $tmp[$v->id]->id_permission[] = $v->id_permission;
                        }
                    }
                    $menu = [];
                    foreach($tmp as $v){
                        $menu[] = $v;
                    }
                    response(['data' => $menu]);

                }
            }
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
                        $v->id_permission = [$v->id_permission];
                        $tmp[$v->id] = $v;
                    }
                    else{
                        $tmp[$v->id]->permission[] = $v->nama_permission;
                        $tmp[$v->id]->id_permission[] = $v->id_permission;
                    }
                }
                $menu = [];
                foreach($tmp as $v){
                    $menu[] = $v;
                }
                return $menu;
            });
            
            $header = array(
                'id' => array('searchable' => false),
                'icon' => array('searchable' => false),
                'nama' => array('searchable' => 'menu.nama'),
                'url' => array('searchable' => true),
                'level' => array('searchable' => 'lvl', 'field' => 'lvl'),
                'jenis' => array('searchable' => 'parrent_element', 'field' => 'parrent_element'),
                'aktif' => array('searchable' => true),
                'nama_permission' => array('searchable' => 'permission.nama', 'field' => 'nama_permission'),
                'id_permission' => array('searchable' => false, 'field' => 'id_permission'),
                'desc' => array('searchable' => 'menu.deskripsi ', 'field' => 'deskripsi'),
            );
            

            $ci->datatables->setHeader($header)
                ->addSelect('menu.*, permission.nama as nama_permission, permission.id as id_permission')
                ->setQuery($query);
            $data =  $ci->datatables->getData();
            response($data);


            // return (object) array('data' => $menu);
        }

        function persiapanSimpan($post){
            $menu = fieldmapping('navigasi-menu', $post, array(
                'id' => random(8),
                'aktif'=> 1,
                'deskripsi' => '#unset'
            ));
            $permission = fieldmapping('navigasi-permission', $post);
            $permission['menu'] = $menu['id'];

            if($menu['lvl'] == 1) unset($menu['induk']);
            $isEdit = isset($post['mode']) && $post['mode'] = 'edit';

            return [$permission, $menu, $isEdit];
        }

        function simpanNavigasi($input){
            /** @var CI_Controller */
            $ci =& get_instance();

            list($permission, $menu, $isEdit) = $input;
            log_message("DEBUG", "-====== INPUT NAVIGASI ===== " . print_r($input, true));

            try {
                $idMenu = $menu['id'];
                if($isEdit){
                    unset($menu['id']);
                    $ci->db->where('id', $idMenu)->update('menu', $menu);
                }else{
                    $ci->db->insert('menu', $menu);
                }
                $data = [];
                if(isset($permission['permission']) && !empty($permission['permission'])){
                    foreach($permission['permission'] as $p){
                        $data[] = array(
                            'menu' => $permission['menu'],
                            'permission' => $p
                        );
                    }
                }
                if(!$isEdit && !empty($data)){
                    $ci->db->insert_batch('menu_permission', $data);
                }else{
                    $ci->db->where('menu', $idMenu)->delete('menu_permission');
                    if(!empty($data))
                        $ci->db->insert_batch('menu_permission', $data);
                }
                if($isEdit){
                    response("Berhasil Update Navigasi #" . $idMenu . " (" . $menu['nama'] . ")");
                }else{
                    response("Berhasil Menambah Navigasi #" . $idMenu . " (" . $menu['nama'] . ")");
                }
            } catch (\Throwable $th) {
                response("Gagal Input Navigasi Baru", 500);
            }
        }
    }