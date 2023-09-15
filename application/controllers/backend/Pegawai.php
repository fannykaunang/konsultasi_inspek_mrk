<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function index()
    {
        if ($this->user_model->CheckSession() == 1) {
            $data['page_title'] = 'Daftar Pegawai - Inspektorat Kabupaten Merauke';
            $data['settingsmenu'] = 'active';
            $data['profil_menu'] = 'active';
            $data['profil_pejabatstaff_submenu'] = 'active';

            $data['theme'] = $this->user_model->GetUserTheme();


            /*role*/
            $data['role'] = $this->role_model->LoadRole();

            $RoleUserCreate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'UserCreate');
            if ($RoleUserCreate == 'no') {
                $RoleUserCreate = 'disabled';
            }
            $data['RoleUserCreate'] = $RoleUserCreate;
            /*role*/

            $query = $this->db->get('unit_kerja');
            if ($query->num_rows() > 0) {
                $data['unit_kerja'] = $query->result();
            } else {
                $data['unit_kerja'] = null;
            }


            $this->load->view("backend/pegawai", $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

    function PegawaiList()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                $requestData = $this->input->post();
                $table = 'skpdpegawai';
                $columns = array(
                    '0' => 'NIP',
                    '1' => 'NamaPegawai',
                    '2' => 'TglLahir',
                    '3' => 'Jabatan',
                    '4' => 'JenisPegawai',
                    '5' => 'Filename'
                );

                $query = $this->db->query("
						SELECT IdPegawai, NIP, NamaPegawai, TglLahir, Jabatan, JenisPegawai, unit_kerja.UnitKerja
						FROM $table INNER JOIN unit_kerja ON skpdpegawai.IdUnit = unit_kerja.IDUnit");
                $recordsTotal = $query->num_rows();
                $recordsFiltered = $recordsTotal;

                if (!empty($requestData['search']['value'])) {
                    //receive search value;
                    $sql = " SELECT IdPegawai, NIP, NamaPegawai, TglLahir, Jabatan, JenisPegawai, unit_kerja.UnitKerja";
                    $sql .= " FROM $table ";
                    $sql .= " WHERE NIP LIKE'%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR NamaPegawai LIKE '%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR Jabatan LIKE '%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR JenisPegawai LIKE '%" . $requestData['search']['value'] . "%' ";
                    $sql .= " OR Filename LIKE '%" . $requestData['search']['value'] . "%' ORDER BY NoUrut ASC";

                    $query = $this->db->query($sql);
                    $recordsFiltered = $query->num_rows();
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                } else {
                    $sql = " SELECT IdPegawai, NIP, NamaPegawai, TglLahir, Jabatan, JenisPegawai, unit_kerja.UnitKerja ";
                    $sql .= " FROM $table  INNER JOIN unit_kerja ON skpdpegawai.IdUnit = unit_kerja.IDUnit";
                    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
                    $query = $this->db->query($sql);
                }

                if ($query->num_rows() > 0) {

                    foreach ($query->result() as $row) {
                        $data[] = array(
                            'NIP' => $row->NIP,
                            'NamaPegawai' => $row->NamaPegawai,
                            'TglLahir' => $row->TglLahir,
                            'Jabatan' => $row->Jabatan,
                            'JenisPegawai' => $row->JenisPegawai,
                            'UnitKerja' => $row->UnitKerja,
                            'Option' => '   <button onclick="UserEdit(' . $row->IdPegawai . ');" class="btn btn-icon btn-sm btn-primary btn-round" title="Edit" ' . $RoleUserDelete . '>
											    <i class="icon wb-pencil"></i>
											</button> &nbsp;  
                                            <button onclick="UploadPictureUser(' . $row->IdPegawai . ')" class="btn btn-sm btn-icon btn-warning btn-round" ' . $RoleUserDelete . '>
												<i class="icon wb-image"></i>
											</button>  &nbsp;
                                            <button onclick="UserDelete(' . $row->IdPegawai . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleUserDelete . '>
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
                redirect(base_url() . 'backend/login');
            }
        } else {
            $this->load->view('404');
        }
    }
    function ajax()
    {
        if ($this->user_model->CheckSession() == 1) {
            if ($this->input->is_ajax_request() == true) {
                if ($do = $this->input->post('do')) {
                    switch ($do) {
                        case "UserDelete":
                            $IdPegawai = $this->input->post('IdPegawai');
                            $query = $this->db->where('IdPegawai', $IdPegawai);
                            $query = $this->db->get('skpdpegawai');
                            if ($query->num_rows() > 0) {
                                $row = $query->row();
                                $Filename = $row->Filename;
                                $Fullpath = $row->Fullpath;
                                $Basename = $row->Basename;
                                $Dirname = $row->Dirname;
                                $Extension = $row->Extension;

                                $query = $this->db->where('IdPegawai', $IdPegawai);
                                $query = $this->db->delete('skpdpegawai');
                                if ($query) {
                                    $respon = array(
                                        'status' => 'sukses',
                                        'message' => 'Hapus file'
                                    );
                                    unlink("$Dirname/$Basename");
                                } else {
                                    $respon = array(
                                        'status' => 'gagal',
                                        'message' => 'Hapus file'
                                    );
                                }
                            }
                            echo json_encode($respon);
                            break;
                        case "UserEdit":
                            $IdPegawai = $this->input->post('IdPegawai');
                            $query = $this->db->where('IdPegawai', $IdPegawai);
                            $query = $this->db->get('skpdpegawai');
                            $data = $query->result();
                            $respon = array(
                                'status' => 'sukses',
                                'message' => 'Get slider data',
                                'data' => $data
                            );

                            echo json_encode($respon);
                            break;
                        case "UserUpdate":
                            $IdPegawai = $this->input->post('IdPegawai');
                            $NoUrut = $this->input->post('NoUrut');
                            $NIP = $this->input->post('NIP');
                            $NamaPegawai = $this->input->post('NamaPegawai');
                            $JKelamin = $this->input->post('JKelaminEdit');
                            $PangkatGolongan = $this->input->post('PangkatGolongan');
                            $Jabatan = $this->input->post('Jabatan');
                            $JenisPegawai = $this->input->post('JenisPegawai');
                            $IdUnit = $this->input->post('IdUnit');
                            $TipeJabatan = $this->input->post('TipeJabatan');
                            $TglLahir = $this->input->post('TglLahirEdit');
                            $TglLahir = DateSlashMysql($TglLahir) . ' ' . date('H:i:s');

                            $data = array(
                                'NoUrut' => $NoUrut,
                                'NIP' => $NIP,
                                'NamaPegawai' => $NamaPegawai,
                                'TglLahir' => $TglLahir,
                                'JKelamin' => $JKelamin,
                                'PangkatGolongan' => $PangkatGolongan,
                                'Jabatan' => $Jabatan,
                                'JenisPegawai' => $JenisPegawai,
                                'IdUnit' => $IdUnit,
                                'TipeJabatan' => $TipeJabatan
                            );

                            $query = $this->db->where('IdPegawai', $IdPegawai);
                            $query = $this->db->update('skpdpegawai', $data);
                            if ($query) {
                                $respon = array(
                                    'status' => 'sukses',
                                    'message' => 'Update pegawai'
                                );
                            }

                            echo json_encode($respon);
                            break;
                        case "EditFoto":
                            $IdPegawai = $this->input->post('IdPegawai');
                            $query = $this->db->where('IdPegawai', $IdPegawai);
                            $query = $this->db->get('skpdpegawai');
                            $data = $query->result();
                            $respon = array(
                                'status' => 'sukses',
                                'message' => 'Get data foto',
                                'data' => $data
                            );

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

            $Path = 'pegawai';
            $Filename = url_title($this->input->post('Filename'));
            $NoUrut = $this->input->post('NoUrut');
            $NIP = $this->input->post('NIP');
            $NamaPegawai = $this->input->post('NamaPegawai');
            $JKelamin = $this->input->post('JKelamin');
            $PangkatGolongan = $this->input->post('PangkatGolongan');
            $Jabatan = $this->input->post('Jabatan');
            $JenisPegawai = $this->input->post('JenisPegawai');
            $IdUnit = $this->input->post('IdUnit');
            $TipeJabatan = $this->input->post('TipeJabatan');

            $TglLahir = $this->input->post('TglLahir');
            $TglLahir = DateSlashMysql($TglLahir) . ' ' . date('H:i:s');

            $config['upload_path'] = $Path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
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
                        'NoUrut' => $NoUrut,
                        'NIP' => $NIP,
                        'NamaPegawai' => $NamaPegawai,
                        'TglLahir' => $TglLahir,
                        'JKelamin' => $JKelamin,
                        'PangkatGolongan' => $PangkatGolongan,
                        'Jabatan' => $Jabatan,
                        'JenisPegawai' => $JenisPegawai,
                        'IdUnit' => $IdUnit,
                        'TipeJabatan' => $TipeJabatan,
                        'Fullpath' => $Fullpath,
                        'Filename' => $raw_name,
                        'Dirname' => $file_path,
                        'Basename' => $file_name,
                        'Extension' => str_replace(".", "", $file_extension),
                        'Fullpath' => base_url() . $Path . '/' . $file_name,
                        'Filesize' => $file_size
                    );
                    $query = $this->db->insert('skpdpegawai', $data);
                    if ($query) {
                        $respon = array(
                            'status' => 'sukses',
                            'message' => 'Update pegawai'
                        );
                    }
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
        } else {
            redirect(base_url() . 'backend/login');
        }
    }




    function UploadPictureUser()
    {
        if ($this->user_model->CheckSession() == 1) {

            $Path = 'pegawai';

            $Filename = $this->user_model->GetNameUser();
            $IdPegawai = $this->input->post('IdPegawai');


            $config['upload_path'] = $Path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
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

                    /*resize*/
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $file_path . $file_name;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 200;
                    $config['height'] = 200;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    /*resize*/

                    $fileinfo = get_file_info($file_path . $file_name);
                    $file_size = $fileinfo['size'];


                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $file_path . $file_name;
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 500;
                    $config['height'] = 500;

                    $data = array(
                        'Filename' => $raw_name,
                        'Dirname' => $file_path,
                        'Basename' => $file_name,
                        'Extension' => str_replace(".", "", $file_extension),
                        'Fullpath' => base_url() . $Path . '/' . $file_name,
                        'Filesize' => $file_size
                    );

                    $query = $this->db->where('IdPegawai', $IdPegawai);
                    $query = $this->db->update('skpdpegawai', $data);
                }

                /*resize*/
                $message = "";
                $status = 'sukses';
            }

            if ($status == 'sukses') {
                echo '<script>
					parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";
					parent.document.getElementById("picture-user").src="' . base_url() . $Path . '/' . $file_name . '";
					parent.document.getElementById("picture-user-navbar").src="' . base_url() . $Path . '/' . $file_name . '";
					</script>';
            } else {
                echo '<script>parent.document.getElementById("ResponUpload").innerHTML="' . $message . '";
					parent.document.getElementById("StatusUpload").innerHTML="' . $status . '";
				</script>';
            }
            $this->load->view('backend/dashboard', $data);
        } else {
            redirect(base_url() . 'backend/login');
        }
    }

}