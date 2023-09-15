<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sambutan extends CI_Controller
{
    public function index()
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Sambutan - Inspektorat Kabupaten Merauke';
            $data['profil_menu'] = 'active';
            $data['profil_sambutan_submenu'] = 'active';

            /*role*/
            $data['role'] = $this->role_model->LoadRole();
            /*role*/

            $data['totalpage'] = $this->db->count_all('sambutan');

            $this->load->view("backend/sambutan", $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }
    function SambutanList()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                $requestData = $this->input->post();
                $table = 'sambutan';
                $columns = array(
                    '0' => 'Sambutan',
                    '1' => 'TglUpdate'
                );

                $query = $this->db->query("
						SELECT IDSambutan, Sambutan, TglUpdate
						FROM $table
						");
                $recordsTotal = $query->num_rows();
                $recordsFiltered = $recordsTotal;

                if (!empty($requestData['search']['value'])) {
                    //receive search value;
                    $sql = " SELECT IDSambutan, Sambutan, TglUpdate ";
                    $sql .= " FROM $table ";
                    $sql .= " WHERE Sambutan LIKE '%" . $requestData['search']['value'] . "%' ";

                    $query = $this->db->query($sql);
                    $recordsFiltered = $query->num_rows();
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                } else {
                    $sql = " SELECT IDSambutan, Sambutan, TglUpdate ";
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
                            'Sambutan' => '<label id="' . $row->IDSambutan . '" onmouseover="ShowMenu(' . $row->IDSambutan . ')">' . word_limiter($row->Sambutan, 30) . '</label> 
                            	<br/><small style="display:none;" class="' . $row->IDSambutan . '" >
                            	<i><a href="' . base_url() . 'profil/sambutan" target="_blank">Lihat Sambutan</a></i> &nbsp;									
                            	</small>',
                            'TglUpdate' => $row->TglUpdate,
                            'Option' => '<a href="' . base_url() . 'backend/sambutan/edit/' . $row->IDSambutan . '" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleNewsUpdate . '>
											<i class="icon wb-pencil"></i>
											</a> &nbsp;  
											<button onclick="PageDelete(' . $row->IDSambutan . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleNewsDelete . '>
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
            $data['page_title'] = 'Tambah Sambutan - Inspektorat Kabupaten Merauke';
            $data['profil_menu'] = 'active';
            $data['profil_sambutan_submenu'] = 'active';
            /*role*/
            $data['role'] = $this->role_model->LoadRole();
            $RoleNewsCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsCreate');
            if ($RoleNewsCreate == 'no') {
                $RoleNewsCreate = 'disabled';
            }
            $data['RoleNewsCreate'] = $RoleNewsCreate;
            /*role*/
            $data['authorpage'] = $this->user_model->GetNameUser();

            $query = $this->db->order_by('NameCategory', 'ASC');
            $query = $this->db->get('categorypage');
            $row = $query->row();
            $data['category'] = $query->result();

            $this->load->view("backend/sambutan-add", $data);
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
                            $query = $this->db->insert('sambutan', $data);
                            if ($query) {
                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Simpan sambutan baru'
                                );
                            }

                            echo json_encode($respon);
                            break;
                        case "PageUpdate":
                            $IDSambutan = $this->input->post('IDSambutan');

                            $data = array(
                                'Sambutan' => $this->input->post('ContentPage'),
                                'TglUpdate' => date('Y-m-d H:i:s')
                            );

                            $query = $this->db->where('IDSambutan', $IDSambutan);
                            $query = $this->db->update('sambutan', $data);
                            if ($query) {

                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Update data sambutan'
                                );
                            }

                            echo json_encode($respon);
                            break;
                        case "PageDelete":
                            $ulevel = $this->user_model->GetLevelUser();
                            if ($ulevel == 'contributor' || $ulevel == 'moderator') {
                                $respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak  menghapus halaman ini');
                            } else {
                                $IDSambutan = $this->input->post('IDSambutan');
                                $query = $this->db->where('IDSambutan', $IDSambutan);
                                $query = $this->db->delete('sambutan');
                                if ($query) {
                                    $respon = array(
                                        'status' => 'sukses',
                                        'message' => 'Hapus sambutan'
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

    function edit($IDSambutan)
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Ubah Sambutan - Inspektorat Kabupaten Merauke';
            $data['profil_menu'] = 'active';
            $data['profil_sambutan_submenu'] = 'active';

            $data['authorpage'] = $this->user_model->GetNameUser();

            /*role*/
            $data['role'] = $this->role_model->LoadRole();
            $RoleNewsCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsCreate');
            if ($RoleNewsCreate == 'no') {
                $RoleNewsCreate = 'disabled';
            }
            $data['RoleNewsCreate'] = $RoleNewsCreate;

            /*role*/


            $this->load->view('backend/sambutan-edit', $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }


}