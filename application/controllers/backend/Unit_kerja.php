<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit_kerja extends CI_Controller
{
    public function index()
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Unit Kerja - Inspektorat Kabupaten Merauke';
            $data['unitkerja_menu'] = 'active';
            $data['unitkerja_submenu'] = 'active';
            /*role*/
            $data['role'] = $this->role_model->LoadRole();
            /*role*/
            $data['totalunit'] = $this->db->count_all('unit_kerja');

            $this->load->view("backend/unit-kerja", $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

    function TupoksiList()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                $requestData = $this->input->post();
                $table = ' unit_kerja ';
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
						SELECT IDUnit, TugasPokok, Fungsi, Author, UpdatedBy, DateCreated, UnitKerja, FlagPublish
						FROM $table");
                $recordsTotal = $query->num_rows();
                $recordsFiltered = $recordsTotal;

                if (!empty($requestData['search']['value'])) {
                    //receive search value;
                    $sql = " SELECT IDUnit, TugasPokok, Fungsi, Author, UpdatedBy, DateCreated, UnitKerja, FlagPublish ";
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
                    $sql = " SELECT IDUnit, TugasPokok, Fungsi, Author, UpdatedBy, DateCreated, UnitKerja, FlagPublish ";
                    $sql .= " FROM $table ";
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                }

                if ($query->num_rows() > 0) {

                    // /*role*/
                    // $RoleTupoksiUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsUpdate');
                    // if ($RoleTupoksiUpdate == 'no') {
                    //     $RoleTupoksiUpdate = 'disabled';
                    // }
                    // $RoleTupoksiDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'NewsDelete');
                    // if ($RoleTupoksiDelete == 'no') {
                    //     $RoleTupoksiDelete = 'disabled';
                    // }
                    // /*role*/

                    foreach ($query->result() as $row) {
                        $data[] = array(
                            'UnitKerja' => $row->UnitKerja,
                            'DateCreated' => substr(DateTimeIndo($row->DateCreated), 0, -3) . '<br/><i><small data-livestamp="' . $row->DateCreated . '" class="livestamp"></small></i>',
                            'LastUpdated' => substr(DateTimeIndo($row->LastUpdated), 0, -3) . '<br/><i><small data-livestamp="' . $row->LastUpdated . '" class="livestamp"></small></i>',
                            'TugasPokok' => '<label id="' . $row->IDUnit . '" onmouseover="ShowMenu(' . $row->IDUnit . ')">' . word_limiter($row->TugasPokok, 8) . '</label> 
								<br/><small style="display:none;" class="' . $row->IDUnit . '" >
																	
								</small>',
                            'Fungsi' => '<label id="' . $row->IDUnit . '" onmouseover="ShowMenu(' . $row->IDUnit . ')">' . word_limiter($row->Fungsi, 8) . '</label> 
								<br/><small style="display:none;" class="' . $row->IDUnit . '" >
															
								</small>',
                            'Author' => $row->Author,
                            'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
                            'Option' => ' 
                                             <a href="' . base_url() . 'backend/unit_kerja/edit/' . $row->IDUnit . '" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleTupoksiUpdate . '>
											 <i class="icon wb-pencil"></i>
											 </a> &nbsp; 
											<button onclick="TupoksiDelete(' . $row->IDUnit . ')" class="btn btn-sm btn-icon btn-danger btn-round" title="Hapus" ' . $RoleTupoksiDelete . '>
												<i class="icon wb-trash"></i>
											</button>'
                            // <a href="' . base_url() . 'backend/news/edit/' . $row->IDUnit . '" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleTupoksiUpdate . '>
                            // <i class="icon wb-pencil"></i>
                            // </a> &nbsp; 
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
            $data['tupoksimenu'] = 'active';
            $data['tupoksisubmenu'] = 'active';

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
            $this->load->view("backend/unit-kerja-add", $data);
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
                                'UnitKerja' => $this->input->post('UnitKerja'),
                                'UnitKerjaAlias' => $this->input->post('UnitKerjaAlias'),
                                'TugasPokok' => $this->input->post('TugasPokok'),
                                'Fungsi' => $this->input->post('Fungsi'),
                                'Author' => $Author,
                                'UpdatedBy' => $Author,
                                'DateCreated' => date('Y-m-d H:i:s'),
                                'LastUpdated' => date('Y-m-d H:i:s'),
                                'FlagPublish' => $FlagPublish
                            );
                            $query = $this->db->insert('unit_kerja', $data);
                            if ($query) {

                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Simpan Tupoksi baru'
                                );
                            }

                            echo json_encode($respon);
                            break;
                        case "TupoksiUpdate":
                            $IDUnit = $this->input->post('IDUnit');
                            if (!$this->input->post('FlagPublish')) {
                                $FlagPublish = '0';
                            } else {
                                $FlagPublish = '1';
                            }
                            $data = array(

                                'UnitKerja' => $this->input->post('UnitKerja'),
                                'UnitKerjaAlias' => $this->input->post('UnitKerjaAlias'),
                                'TugasPokok' => $this->input->post('TugasPokok'),
                                'Fungsi' => $this->input->post('Fungsi'),
                                'Author' => $Author,
                                'UpdatedBy' => $Author,
                                'DateCreated' => date('Y-m-d H:i:s'),
                                'LastUpdated' => date('Y-m-d H:i:s'),
                                'FlagPublish' => $FlagPublish
                            );

                            $query = $this->db->where('IDUnit', $IDUnit);
                            $query = $this->db->update('unit_kerja', $data);
                            if ($query) {
                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Update unit'
                                );
                            }

                            echo json_encode($respon);
                            break;
                        case "TupoksiDelete":
                            $ulevel = $this->user_model->GetLevelUser();

                            if ($ulevel == 'moderator') {
                                $respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak  menghapus unit ini  ini');
                            } else {
                                $IDUnit = $this->input->post('IDUnit');
                                $query = $this->db->where('IDUnit', $IDUnit);
                                $query = $this->db->delete('unit_kerja');
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

    function edit($IDUnit)
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Ubah Unit keja - Inspektorat Kabupaten Merauke';
            $data['pagemenu'] = 'active';
            $data['pagesubmenu'] = 'active';

            $data['author'] = $this->user_model->GetNameUser();

            /*role*/
            $Role = $this->role_model->LoadRole();

            if ($this->user_model->GetLevelUser() == 'superadmin') {
                $query = $this->db->query("
												SELECT * FROM unit_kerja 
												WHERE IDUnit='$IDUnit'
											");
                if ($query->num_rows() > 0) {
                    $data['editpage'] = $query->result();
                    $querycategory = $this->db->order_by('IDUnit', 'ASC');
                    $querycategory = $this->db->get('unit_kerja');
                    $data['categorypage'] = $querycategory->result();
                } else {
                    $data['editpage'] = null;
                }
                $data['RoleNewsUpdate'] = 'yes';
            } else {
                if ($this->user_model->GetLevelUser() == 'moderator') {
                    if ($Role['RoleNewsUpdate'] == 'yes') {
                        $query = $this->db->query("
														SELECT * FROM unit_kerja 
														WHERE IDUnit='$IDUnit'
													");
                        if ($query->num_rows() > 0) {
                            $data['editnews'] = $query->result();
                            $querycategory = $this->db->order_by('IDUnit', 'ASC');
                            $querycategory = $this->db->get('unit_kerja');
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
														SELECT * FROM unit_kerja 
														WHERE IDUnit='$IDUnit'
														AND Author='$Author' AND FlagPublish='0'
													");
                        if ($query->num_rows() > 0) {
                            $data['editnews'] = $query->result();
                            $querycategory = $this->db->order_by('IDUnit', 'ASC');
                            $querycategory = $this->db->get('unit_kerja');
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


            $this->load->view('backend/unit-kerja-edit', $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }
}

/* End of file News.php */
/* Location: ./application/controllers/backend/News.php */