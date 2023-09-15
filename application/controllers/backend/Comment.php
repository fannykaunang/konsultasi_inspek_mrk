<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends CI_Controller
{

	public function index()
	{
		if ($this->user_model->CheckSession() == 1) {
			$data['newsmenu'] = 'active';
			$data['commentsubmenu'] = 'active';
			/*role*/
			$data['role'] = $this->role_model->LoadRole();

			/*role*/
			$this->load->view("backend/comment", $data);

		} else {
			redirect(base_url() . 'backend/login');
		}

	}
	function CommentList()
	{
		if ($this->user_model->CheckSession() == 1) {
			if ($this->input->is_ajax_request() == true) {
				$requestData = $this->input->post();
				$table = 'comment';
				$columns = array(
					'0' => 'DateComment',
					'1' => 'NameComment',
					'2' => 'EmailComment',
					'3' => 'ContentComment',
					'4' => 'TitleNews',
					'5' => 'FlagPublish'
				);

				$query = $this->db->query("
						SELECT IdComment, IdNews, DateComment, NameComment, EmailComment, ContentComment, TitleNews, FlagPublish
						FROM $table
						");
				$recordsTotal = $query->num_rows();
				$recordsFiltered = $recordsTotal;

				if (!empty($requestData['search']['value'])) {
					//receive search value;
					$sql = " SELECT IdComment, IdNews, DateComment, NameComment, EmailComment, ContentComment, TitleNews, FlagPublish ";
					$sql .= " FROM $table ";
					$sql .= " WHERE NameComment LIKE'%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR EmailComment LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR ContentComment LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR TitleNews LIKE '%" . $requestData['search']['value'] . "%' ";
					$sql .= " OR FlagPublish LIKE '%" . $requestData['search']['value'] . "%' ";

					$query = $this->db->query($sql);
					$recordsFiltered = $query->num_rows();
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				} else {
					$sql = " SELECT IdComment, IdNews, DateComment, NameComment, EmailComment, ContentComment, TitleNews, FlagPublish ";
					$sql .= " FROM $table ";
					$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
					$query = $this->db->query($sql);
				}

				if ($query->num_rows() > 0) {
					/*role*/
					$RoleCommentUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CommentUpdate');
					if ($RoleCommentUpdate == 'no') {
						$RoleCommentUpdate = 'disabled';
					}
					$RoleCommentDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CommentDelete');
					if ($RoleCommentDelete == 'no') {
						$RoleCommentDelete = 'disabled';
					}
					/*role*/

					foreach ($query->result() as $row) {

						$data[] = array(
							'DateComment' => substr(DateTimeIndo($row->DateComment), 0, -3) . '<br/><i><small data-livestamp="' . $row->DateComment . '" class="livestamp"></small></i>',
							'NameComment' => $row->NameComment,
							'EmailComment' => $row->EmailComment,
							'ContentComment' => '<label id="' . $row->IdComment . '" onmouseover="ShowMenu(' . $row->IdComment . ')">' . word_limiter($row->ContentComment, 8) . '</label> 
								<br/><small style="display:none;" class="' . $row->IdComment . '" >
								<i><a href="' . base_url() . 'backend/comment/detail/' . $row->IdComment . '">Lihat komentar</a></i> &nbsp;									
								</small>',
							'TitleNews' => word_limiter($row->TitleNews, 20),
							'FlagPublish' => $this->backend_konsultasi_model->FlagPublishIndicator($row->FlagPublish),
							'Option' => '<button onclick="CommentDelete(' . $row->IdComment . ')" class="btn btn-sm btn-icon btn-danger btn-round" ' . $RoleCommentDelete . '>
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
						case "CommentDelete":
							$IdComment = $this->input->post('IdComment');
							$query = $this->db->where('IdComment', $IdComment);
							$query = $this->db->delete('comment');
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Hapus komentar'
								);
							}
							echo json_encode($respon);
							break;
						case "CommentUpdate":
							$IdComment = $this->input->post('IdComment');
							$ContentComment = $this->input->post('ContentComment');
							$EmailComment = $this->input->post('EmailComment');
							$NameComment = $this->input->post('NameComment');

							if (!$this->input->post('FlagPublish')) {
								$FlagPublish = '0';
							} else {
								$FlagPublish = '1';
							}

							$data = array(
								'NameComment' => $NameComment,
								'EmailComment' => $EmailComment,
								'ContentComment' => $ContentComment,
								'FlagPublish' => $FlagPublish
							);

							$query = $this->db->where('IdComment', $IdComment);
							$query = $this->db->update('comment', $data);
							if ($query) {
								$respon = array(
									'status' => 'sukses',
									'message' => 'Update komentar'
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

	function detail($IdComment)
	{
		if ($this->user_model->CheckSession() == 1) {
			if (isset($IdComment)) {
				$data['newsmenu'] = 'active';
				$data['commentsubmenu'] = 'active';
				/*role*/
				$data['role'] = $this->role_model->LoadRole();
				$RoleCommentUpdate = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CommentUpdate');
				if ($RoleCommentUpdate == 'no') {
					$RoleCommentUpdate = 'disabled';
				}
				$data['RoleCommentUpdate'] = $RoleCommentUpdate;
				$RoleCommentDelete = $this->role_model->GetRole($this->user_model->GetLevelUser(), 'CommentDelete');
				if ($RoleCommentDelete == 'no') {
					$RoleCommentDelete = 'disabled';
				}
				$data['RoleCommentDelete'] = $RoleCommentDelete;
				/*role*/

				$query = $this->db->where('IdComment', $IdComment);
				$query = $this->db->get('comment');
				if ($query->num_rows() > 0) {
					$data['comment'] = $query->result();
				} else {
					$data['comment'] = null;
				}

				$this->load->view("backend/comment-detail", $data);
			} else {
				$this->load->view('404');
			}
		} else {
			redirect(base_url() . 'backend/login');
		}

	}

}

/* End of file Comment.php */
/* Location: ./application/controllers/backend/Comment.php */