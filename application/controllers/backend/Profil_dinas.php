<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil_dinas extends CI_Controller
{
    public function index()
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Profil Dinas - Inspektorat Kabupaten Merauke';
            $data['pagemenu'] = 'active';
            $data['profil_menu'] = 'active';
            $data['profil_dinas_submenu'] = 'active';

            /*role*/
            $data['role'] = $this->role_model->LoadRole();
            /*role*/

            $data['totalpage'] = $this->db->count_all('skpdprofildinas');

            $this->load->view("backend/profil-dinas", $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }
    function SambutanList()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                $requestData = $this->input->post();
                $table = 'skpdprofildinas ';
                $columns = array(
                    '0' => 'Sambutan',
                    '1' => 'TglUpdate'
                );

                $query = $this->db->query("
						SELECT IdProfil, Sambutan, TglUpdate
						FROM $table
						");
                $recordsTotal = $query->num_rows();
                $recordsFiltered = $recordsTotal;

                if (!empty($requestData['search']['value'])) {
                    //receive search value;
                    $sql = " SELECT IdProfil, Sambutan, TglUpdate ";
                    $sql .= " FROM $table ";
                    $sql .= " WHERE Sambutan LIKE '%" . $requestData['search']['value'] . "%' ";

                    $query = $this->db->query($sql);
                    $recordsFiltered = $query->num_rows();
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                } else {
                    $sql = " SELECT IdProfil, Sambutan, TglUpdate ";
                    $sql .= " FROM $table ";
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                }

                if ($query->num_rows() > 0) {

                    /*role*/
                    // $RoleNewsUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsUpdate');
                    // if ($RoleNewsUpdate == 'no') {
                    //     $RoleNewsUpdate = 'disabled';
                    // }
                    // $RoleNewsDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsDelete');
                    // if ($RoleNewsDelete == 'no') {
                    //     $RoleNewsDelete = 'disabled';
                    // }
                    /*role*/

                    foreach ($query->result() as $row) {
                        $data[] = array(
                            'Sambutan' => '<label id="' . $row->IdProfil . '" onmouseover="ShowMenu(' . $row->IdProfil . ')">' . word_limiter($row->Sambutan, 30) . '</label> 
                            	<br/><small style="display:none;" class="' . $row->IdProfil . '" >
                            	<i><a href="' . base_url() . 'dinas" target="_blank">Lihat profil</a></i> &nbsp;									
                            	</small>',
                            'TglUpdate' => $row->TglUpdate,
                            'Option' => '<a href="' . base_url() . 'backend/profil_dinas/edit/' . $row->IdProfil . '" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleNewsUpdate . '>
											<i class="icon wb-pencil"></i>
											</a> &nbsp;  
											<button onclick="PageDelete(' . $row->IdProfil . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleNewsDelete . '>
												<i class="icon wb-trash"></i>
											</button>'
                        );
                        $respon = array(
                            'draw' => intval($requestData['draw']),
                            'recordsTotal' => intval($recordsTotal),
                            'recordsFiltered' => intval($recordsFiltered),
                            'data' => $data
                        );
                    }
                } else {
                    $respon = array(
                        'draw' => intval($requestData['draw']),
                        'recordsTotal' => intval($recordsTotal),
                        'recordsFiltered' => intval($recordsFiltered),
                        'data' => array()
                    );
                }
                echo json_encode($respon);
            } else {
                $this->load->view('404');
            }
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

    function add()
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Tambah Profil - Inspektorat Kabupaten Merauke';
            $data['pagemenu'] = 'active';
            $data['pagesubmenu'] = 'active';
            /*role*/
            $data['author'] = $this->user_model->GetNameUser();

            if ($this->user_model->GetLevelUser() == 'superadmin') {
                $data['flagpublish'] = '';
                $data['flagdate'] = '';
                $data['flagcomment'] = '';
            } else {
                if ($this->user_model->GetLevelUser() == 'moderator') {
                    $data['flagpublish'] = 'disabled';
                    $data['flagdate'] = 'disabled';
                    $data['flagcomment'] = 'disabled';
                }
            }

            $this->load->view("backend/profil-dinas-add", $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }
    function ajax()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                if ($do = $this->input->post('do')) {

                    $AuthorPage = $this->user_model->GetNameUser();
                    $IdUser = $this->user_model->GetIdUser();

                    switch ($do) {
                        case "PageCreate":
                            $data = array(
                                'Sambutan' => $this->input->post('ContentPage'),
                                'TglUpdate' => date('Y-m-d H:i:s')
                            );
                            $query = $this->db->insert('skpdprofildinas', $data);
                            if ($query) {

                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Simpan sambutan baru'
                                );
                            }

                            echo json_encode($respon);
                            break;
                        case "PageUpdate":
                            $IdProfil = $this->input->post('IdProfil');

                            $data = array(
                                'Sambutan' => $this->input->post('ContentPage'),
                                'TglUpdate' => date('Y-m-d H:i:s')
                            );
                            $query = $this->db->where('IdProfil', $IdProfil);
                            $query = $this->db->update('skpdprofildinas', $data);
                            if ($query) {

                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Update data sambutan'
                                );
                            }
                            //$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

                            echo json_encode($respon);
                            break;
                        case "PageDelete":
                            $ulevel = $this->user_model->GetLevelUser();
                            if ($ulevel == 'contributor' || $ulevel == 'moderator') {
                                $respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak menghapus profil ini');
                            } else {
                                $IdProfil = $this->input->post('IdProfil');
                                $query = $this->db->where('IdProfil', $IdProfil);
                                $query = $this->db->delete('skpdprofildinas ');
                                if ($query) {
                                    $respon = array(
                                        'status' => 'sukses',
                                        'message' => 'Hapus profil'
                                    );
                                }
                            }
                            echo json_encode($respon);
                            break;
                    }
                }
            } else {
                $this->load->view('404');
            }
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

    function edit($IdProfil)
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Ubah Sambutan - Inspektorat Kabupaten Merauke';
            $data['pagemenu'] = 'active';
            $data['pagesubmenu'] = 'active';

            $data['author'] = $this->user_model->GetNameUser();

            /*role*/
            $Role = $this->role_model->LoadRole();

            if ($this->user_model->GetLevelUser() == 'superadmin') {
                $query = $this->db->query("
												SELECT * FROM skpdprofildinas 
												WHERE IdProfil='$IdProfil'
											");
                if ($query->num_rows() > 0) {
                    $data['editpage'] = $query->result();
                    $querycategory = $this->db->order_by('NameCategory', 'ASC');
                    $querycategory = $this->db->get('categorypage');
                    $data['categorypage'] = $querycategory->result();
                } else {
                    $data['editpage'] = null;
                }
                $data['RoleNewsUpdate'] = 'yes';
            } else {
                if ($this->user_model->GetLevelUser() == 'moderator') {
                    if ($Role['RoleNewsUpdate'] == 'yes') {
                        $query = $this->db->query("
														SELECT * FROM skpdprofildinas 
														WHERE IdProfil='$IdProfil'
													");
                        if ($query->num_rows() > 0) {
                            $data['editnews'] = $query->result();
                            $querycategory = $this->db->order_by('NameCategory', 'ASC');
                            $querycategory = $this->db->get('category');
                            $data['categorynews'] = $querycategory->result();
                        } else {
                            $data['editnews'] = null;
                        }
                        $data['RoleNewsUpdate'] = 'yes';
                    } else {
                        $data['RoleNewsUpdate'] = 'no';
                    }
                }
            }

            /*role*/


            $this->load->view('backend/profil-dinas-edit', $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

}