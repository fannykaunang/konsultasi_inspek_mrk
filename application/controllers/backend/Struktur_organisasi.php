<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Struktur_organisasi extends CI_Controller
{

    public function index()
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Struktur Organisasi - Inspektorat Kabupaten Merauke';
            $data['profil_menu'] = 'active';
            $data['profil_struktur_submenu'] = 'active';
            /*role*/
            $data['role'] = $this->role_model->LoadRole();

            $RoleFileCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileCreate');
            if ($RoleFileCreate == 'no') {
                $RoleFileCreate = 'disabled';
            }
            $data['RoleFileCreate'] = $RoleFileCreate;
            $data['totalpage'] = $this->db->count_all('skpdstruktur_org');
            /*role*/
            $this->load->view("backend/struktur-organisasi", $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

    function StrukturList()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                $requestData = $this->input->post();
                $table = 'skpdstruktur_org';
                $columns = array(
                    '0' => 'Filename',
                    '1' => 'Fullpath',
                    '2' => 'Filesize',
                    '3' => 'Time'
                );

                $query = $this->db->query("
						SELECT IdStruktur, Filename, Fullpath, Extension, Filesize, Time
						FROM $table
						");
                $recordsTotal = $query->num_rows();
                $recordsFiltered = $recordsTotal;

                if (!empty($requestData['search']['value'])) {
                    //receive search value;
                    $sql = " SELECT IdStruktur, Filename, Fullpath, Extension, Filesize, Time ";
                    $sql .= " FROM $table ";
                    $sql .= " WHERE Filename LIKE'%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR Fullpath LIKE '%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR Extension LIKE '%" . $requestData['search']['value'] . "%' ";

                    $query = $this->db->query($sql);
                    $recordsFiltered = $query->num_rows();
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                } else {
                    $sql = " SELECT IdStruktur, Filename, Fullpath, Extension, Filesize, Time ";
                    $sql .= " FROM $table ";
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                }

                if ($query->num_rows() > 0) {
                    /*role*/
                    // $RoleFileUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileUpdate');
                    // if ($RoleFileUpdate == 'no') {
                    //     $RoleFileUpdate = 'disabled';
                    // }
                    // $RoleFileDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'FileDelete');
                    // if ($RoleFileDelete == 'no') {
                    //     $RoleFileDelete = 'disabled';
                    // }
                    /*role*/

                    foreach ($query->result() as $row) {
                        if (strtolower($row->Extension) == 'png' || strtolower($row->Extension) == 'jpg' || strtolower($row->Extension) == 'jpeg' || strtolower($row->Extension == 'gif')) {
                            $Image = '<a href="' . $row->Fullpath . '" target="_blank"><img src="' . $row->Fullpath . '" width="100" height="100" class="img-rounded"/></img></a>';
                        } else {
                            $Image = word_limiter($row->Filename, 20);
                        }

                        $data[] = array(
                            'Filename' => $Image,
                            'Fullpath' => $row->Fullpath,
                            'Filesize' => byte_format($row->Filesize),
                            'Time' => substr(DateTimeIndo($row->Time), 0, -3) . '<br/><i><small data-livestamp="' . $row->Time . '" class="livestamp"></small></i>',
                            'Option' => '   <button onclick="StrukturEdit(' . $row->IdStruktur . ');" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleFileDelete . '>
                                                <i class="icon wb-pencil"></i>
                                            </button> &nbsp; 
                                            <button onclick="FileDelete(' . $row->IdStruktur . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleFileDelete . '>
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
    function ajax()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                if ($do = $this->input->post('do')) {

                    switch ($do) {
                        case "FileDelete":

                            $ulevel = $this->user_model->GetLevelUser();

                            if ($ulevel == 'contributor' || $ulevel == 'moderator') {
                                $respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak  menghapus struktur ini');
                            } else {
                                $IdStruktur = $this->input->post('IdStruktur');
                                $query = $this->db->where('IdStruktur', $IdStruktur);
                                $query = $this->db->get('skpdstruktur_org');
                                if ($query->num_rows() > 0) {
                                    $row = $query->row();
                                    $Filename = $row->Filename;
                                    $Fullpath = $row->Fullpath;
                                    $Basename = $row->Basename;
                                    $Dirname = $row->Dirname;
                                    $Extension = $row->Extension;
                                    $query = $this->db->where('IdStruktur', $IdStruktur);
                                    $query = $this->db->delete('skpdstruktur_org');
                                    $respon = array(
                                        'status' => 'sukses',
                                        'message' => 'Hapus file'
                                    );
                                    unlink("$Dirname/$Basename");
                                }
                            }

                            echo json_encode($respon);
                            break;

                        case "StrukturEdit":

                            $ulevel = $this->user_model->GetLevelUser();
                            if ($ulevel == 'contributor' || $ulevel == 'moderator') {
                                $respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak mengedit struktur ini');
                            } else {
                                $IdStruktur = $this->input->post('IdStruktur');
                                $query = $this->db->where('IdStruktur', $IdStruktur);
                                $query = $this->db->get('skpdstruktur_org');
                                $data = $query->result();
                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Get Struktur Organisasi',
                                    'data' => $data
                                );
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

    function UploadFile()
    {
        if ($this->user_model->CheckSession() == 1) {
            $ulevel = $this->user_model->GetLevelUser();

            if ($ulevel == 'moderator') {
                $respon = array('status' => 'gagal', 'message' => 'Maaf anda tidak berhak mengupload struktur ini');
            } else {
                $Path = 'files';
                $Filename = url_title($this->input->post('Filename'));
                $IdUser = $this->user_model->GetIdUser();

                $config['upload_path'] = $Path;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = '4000';
                $config['max_width'] = '4000';
                $config['max_height'] = '4000';
                $config['file_name'] = $Filename;

                $this->load->library('upload', $config);
                $this->load->library('image_lib', $config);

                if (!$this->upload->do_upload()) {

                    $message = $this->upload->display_errors("<span class='label label-danger'><i class='fa fa-exclamation-circle'></i> ", "</span>");
                    $status = 'gagal';
                } else {
                    $result = array('upload_data' => $this->upload->data());
                    foreach ($result as $row) {
                        $full_path = $row['full_path'];
                        $file_path = $row['file_path'];
                        $file_name = $row['file_name'];
                        $raw_name = $row['raw_name'];
                        $file_extension = $row['file_ext'];
                        $file_size = $row['file_size'];

                        $data = array(
                            'Filename' => $raw_name,
                            'Dirname' => $file_path,
                            'Basename' => $file_name,
                            'Extension' => str_replace(".", "", $file_extension),
                            'Fullpath' => base_url() . $Path . '/' . $file_name,
                            'Filesize' => $file_size,
                            'Status' => '',
                            'Time' => date('Y-m-d H:i:s'),
                            'IdUser' => $IdUser
                        );
                        $query = $this->db->insert('skpdstruktur_org', $data);
                    }

                    $message = "";
                    $status = 'sukses';
                }

                if ($status == 'sukses') {
                    echo '<script>						
                        parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";	
                                
                        </script>';
                } else {
                    echo '<script>parent.document.getElementById("ResponUpload").innerHTML="' . $message . '";
                        parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";
                    </script>';
                }

            }

        } else {
            redirect(base_url() . 'backend/login');
        }
    }

    function UploadPictureStruktur()
    {
        if ($this->user_model->CheckSession() == 1) {
            $Path = 'files';
            $Filename = url_title($this->input->post('Filename'));
            $IdUser = $this->user_model->GetIdUser();

            $config['upload_path'] = $Path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '4000';
            $config['max_width'] = '4000';
            $config['max_height'] = '4000';
            $config['file_name'] = $Filename;

            $this->load->library('upload', $config);
            $this->load->library('image_lib', $config);

            if (!$this->upload->do_upload()) {
                $message = $this->upload->display_errors("<span class='label label-danger'><i class='fa fa-exclamation-circle'></i> ", "</span>");
                $status = 'gagal';
            } else {
                $result = array('upload_data' => $this->upload->data());
                foreach ($result as $row) {
                    $full_path = $row['full_path'];
                    $file_path = $row['file_path'];
                    $file_name = $row['file_name'];
                    $raw_name = $row['raw_name'];
                    $file_extension = $row['file_ext'];
                    $file_size = $row['file_size'];

                    $data = array(
                        'Filename' => $raw_name,
                        'Dirname' => $file_path,
                        'Basename' => $file_name,
                        'Extension' => str_replace(".", "", $file_extension),
                        'Fullpath' => base_url() . $Path . '/' . $file_name,
                        'Filesize' => $file_size,
                        'Status' => '',
                        'Time' => date('Y-m-d H:i:s'),
                        'IdUser' => $IdUser
                    );
                    $query = $this->db->update('skpdstruktur_org', $data);
                }

                /*resize*/
                $message = "";
                $status = 'sukses';
            }

            if ($status == 'sukses') {
                echo '<script>						
                            parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";	
                                    
                            </script>';
            } else {
                echo '<script>parent.document.getElementById("ResponUpload").innerHTML="' . $message . '";
                            parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";
                        </script>';
            }
        } else {
            redirect(base_url() . 'backend/login');
        }
    }
}

/* End of file File_manager.php */
/* Location: ./application/controllers/backend/File_manager.php */