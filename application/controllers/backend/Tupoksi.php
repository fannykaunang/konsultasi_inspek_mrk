<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tupoksi extends CI_Controller
{

    public function index()
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Tupoksi - Inspektorat Kabupaten Merauke';
            $data['profil_menu'] = 'active';
            $data['profil_tupoksi_submenu'] = 'active';
            /*role*/
            $data['role'] = $this->role_model->LoadRole();
            /*role*/
            $data['totaltupoksi'] = $this->db->count_all('skpdtupoksi');

            $this->load->view("backend/tupoksi", $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

    function TupoksiList()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                $requestData = $this->input->post();
                $table = 'skpdtupoksi';
                $columns = array(
                    '0' => 'TugasPokok',
                    '1' => 'Fungsi',
                    '2' => 'Author',
                    '3' => 'UpdatedBy',
                    '4' => 'DateCreated',
                    '5' => 'LastUpdated',
                    '6' => 'FlagPublish'
                );

                $query = $this->db->query("
						SELECT IDTupoksi, TugasPokok, Fungsi, Author, UpdatedBy, DateCreated, LastUpdated, FlagPublish
						FROM $table");
                $recordsTotal = $query->num_rows();
                $recordsFiltered = $recordsTotal;

                if (!empty($requestData['search']['value'])) {
                    //receive search value;
                    $sql = " SELECT IDTupoksi, TugasPokok, Fungsi, Author, UpdatedBy, DateCreated, LastUpdated, FlagPublish ";
                    $sql .= " FROM $table ";
                    $sql .= " WHERE TugasPokok LIKE'%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR Fungsi LIKE '%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR Author LIKE '%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR UpdatedBy LIKE '%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

                    $query = $this->db->query($sql);
                    $recordsFiltered = $query->num_rows();
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                } else {
                    $sql = " SELECT IDTupoksi, TugasPokok, Fungsi, Author, UpdatedBy, DateCreated, LastUpdated, FlagPublish ";
                    $sql .= " FROM $table ";
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                }

                if ($query->num_rows() > 0) {

                    foreach ($query->result() as $row) {
                        $data[] = array(
                            'DateCreated' => substr(DateTimeIndo($row->DateCreated), 0, -3) . '<br/><i><small data-livestamp="' . $row->DateCreated . '" class="livestamp"></small></i>',
                            'LastUpdated' => substr(DateTimeIndo($row->LastUpdated), 0, -3) . '<br/><i><small data-livestamp="' . $row->LastUpdated . '" class="livestamp"></small></i>',
                            'TugasPokok' => '<label id="' . $row->IDTupoksi . '" onmouseover="ShowMenu(' . $row->IDTupoksi . ')">' . word_limiter($row->TugasPokok, 8) . '</label> 
								<br/><small style="display:none;" class="' . $row->IDTupoksi . '" >
								<i><a href="' . site_url('tupoksi/' . $row->IDTupoksi . '/' . url_title(strtolower($row->TugasPokok))) . '" target="_blank">Lihat Tugas Pokok</a></i> &nbsp;									
								</small>',
                            'Fungsi' => '<label id="' . $row->IDTupoksi . '" onmouseover="ShowMenu(' . $row->IDTupoksi . ')">' . word_limiter($row->Fungsi, 8) . '</label> 
								<br/><small style="display:none;" class="' . $row->IDTupoksi . '" >
								<i><a href="' . site_url('tupoksi/' . $row->IDTupoksi . '/' . url_title(strtolower($row->Fungsi))) . '" target="_blank">Lihat Fungsi</a></i> &nbsp;									
								</small>',
                            'Author' => $row->Author,
                            'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
                            'Option' => '<a href="' . base_url() . 'backend/tupoksi/edit/' . $row->IDTupoksi . '" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleTupoksiUpdate . '>
											<i class="icon wb-pencil"></i>
											</a> &nbsp;  
											<button onclick="TupoksiDelete(' . $row->IDTupoksi . ')" class="btn btn-sm btn-icon btn-danger btn-round" title="Hapus" ' . $RoleTupoksiDelete . '>
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
            $data['page_title'] = 'Tambah Tupoksi - Inspektorat Kabupaten Merauke';
            $data['profil_menu'] = 'active';
            $data['profil_tupoksi_submenu'] = 'active';

            $data['author'] = $this->user_model->GetNameUser();

            if ($this->user_model->GetLevelUser() == 'superadmin') {
                $data['flagpublish'] = '';
                $data['flagdate'] = '';
                $data['flagcomment'] = '';
            } else {
                if ($this->user_model->GetLevelUser() == 'moderator') {
                    $data['flagpublish'] = '';
                    $data['flagdate'] = '';
                    $data['flagcomment'] = '';
                }
                if ($this->user_model->GetLevelUser() == 'contributor') {
                    $data['flagpublish'] = 'disabled';
                    $data['flagdate'] = 'disabled';
                    $data['flagcomment'] = 'disabled';
                }
            }
            /*flag*/
            $this->load->view("backend/tupoksi-add", $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

    function ajax()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->user_model->CheckSession() == 1) {
                if ($do = $this->input->post('do')) {

                    $Author = $this->user_model->GetNameUser();

                    switch ($do) {
                        case "TupoksiCreate":
                            if (!$this->input->post('FlagPublish')) {
                                $FlagPublish = '0';
                            } else {
                                $FlagPublish = '1';
                            }

                            $data = array(
                                'TugasPokok' => $this->input->post('TugasPokok'),
                                'Fungsi' => $this->input->post('Fungsi'),
                                'Author' => $Author,
                                'UpdatedBy' => $Author,
                                'DateCreated' => date('Y-m-d H:i:s'),
                                'LastUpdated' => date('Y-m-d H:i:s'),
                                'FlagPublish' => $FlagPublish
                            );
                            $query = $this->db->insert('skpdtupoksi', $data);
                            if ($query) {

                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Simpan Tupoksi baru'
                                );
                            }
                            //$this->InsertLog('UserLog',$this->encrypt->decode($session['uname']).' berita','buat berita baru');

                            echo json_encode($respon);
                            break;
                        case "TupoksiUpdate":
                            $IDTupoksi = $this->input->post('IDTupoksi');
                            if (!$this->input->post('FlagPublish')) {
                                $FlagPublish = '0';
                            } else {
                                $FlagPublish = '1';
                            }

                            $data = array(
                                'TugasPokok' => $this->input->post('TugasPokok'),
                                'Fungsi' => $this->input->post('Fungsi'),
                                'Author' => $Author,
                                'UpdatedBy' => $Author,
                                'DateCreated' => date('Y-m-d H:i:s'),
                                'LastUpdated' => date('Y-m-d H:i:s'),
                                'FlagPublish' => $FlagPublish
                            );

                            $query = $this->db->where('IDTupoksi', $IDTupoksi);
                            $query = $this->db->update('skpdtupoksi', $data);
                            if ($query) {

                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Update data Tupoksi'
                                );
                            }

                            echo json_encode($respon);
                            break;
                        case "TupoksiDelete":
                            $ulevel = $this->user_model->GetLevelUser();

                            if ($ulevel == 'contributor' || $ulevel == 'moderator') {
                                $respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak  menghapus tupoksi ini');
                            } else {
                                $IDTupoksi = $this->input->post('IDTupoksi');
                                $query = $this->db->where('IDTupoksi', $IDTupoksi);
                                $query = $this->db->delete('skpdtupoksi');
                                if ($query) {
                                    $respon = array(
                                        'status' => 'sukses',
                                        'message' => 'Hapus Tupoksi'
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

    function edit($IDTupoksi)
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Ubah tupoksi - Inspektorat Kabupaten Merauke';
            $data['profil_menu'] = 'active';
            $data['profil_tupoksi_submenu'] = 'active';

            $data['author'] = $this->user_model->GetNameUser();

            /*role*/
            $Role = $this->role_model->LoadRole();

            if ($this->user_model->GetLevelUser() == 'superadmin') {
                $query = $this->db->query("
												SELECT * FROM skpdtupoksi
												WHERE IDTupoksi='$IDTupoksi'
											");
                if ($query->num_rows() > 0) {
                    $data['editpage'] = $query->result();
                    $querycategory = $this->db->order_by('IDTupoksi', 'ASC');
                    $querycategory = $this->db->get('skpdtupoksi');
                    $data['categorypage'] = $querycategory->result();
                } else {
                    $data['editpage'] = null;
                }
                $data['RoleNewsUpdate'] = 'yes';
            } else {
                if ($this->user_model->GetLevelUser() == 'moderator') {
                    if ($Role['RoleNewsUpdate'] == 'yes') {
                        $query = $this->db->query("
														SELECT * FROM skpdtupoksi 
														WHERE IDTupoksi='$IDTupoksi'
													");
                        if ($query->num_rows() > 0) {
                            $data['editnews'] = $query->result();
                            $querycategory = $this->db->order_by('IDTupoksi', 'ASC');
                            $querycategory = $this->db->get('skpdtupoksi');
                            $data['categorynews'] = $querycategory->result();
                        } else {
                            $data['editnews'] = null;
                        }
                        $data['RoleNewsUpdate'] = 'yes';
                    } else {
                        $data['RoleNewsUpdate'] = 'no';
                    }
                }
                if ($this->user_model->GetLevelUser() == 'contributor') {
                    if ($Role['RoleNewsUpdate'] == 'yes') {
                        $Author = $this->user_model->GetNameUser();

                        $query = $this->db->query("
														SELECT * FROM skpdtupoksi 
														WHERE IDTupoksi='$IDTupoksi'
														AND Author='$Author' AND FlagPublish='0'
													");
                        if ($query->num_rows() > 0) {
                            $data['editnews'] = $query->result();
                            $querycategory = $this->db->order_by('IDTupoksi', 'ASC');
                            $querycategory = $this->db->get('skpdtupoksi');
                            $data['categorynews'] = $querycategory->result();
                        } else {
                            $data['editnews'] = null;
                            $data['prohibitupdate'] = 'yes';
                        }
                        $data['RoleNewsUpdate'] = 'yes';
                    } else {
                        $data['RoleNewsUpdate'] = 'no';
                    }
                }
            }

            /*role*/


            $this->load->view('backend/tupoksi-edit', $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }
}

/* End of file News.php */
/* Location: ./application/controllers/backend/News.php */