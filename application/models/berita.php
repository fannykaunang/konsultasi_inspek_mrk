<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'config/database.php';
class berita extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->__resTraitConstruct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['index_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['index_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->methods['index_get_kategori']['limit'] = 500;
    }

    // show data News
    function index_get()
    {
        $IdNews = $this->get('IdNews');
        $CreatedNews = $this->get('CreatedNews');
        if ($IdNews == '') {
            $this->db->where('FlagPublish', 1)->limit(30);
            $this->db->order_by('CreatedNews', "DESC");
            $news = $this->db->get('news')->result(); // api url http://localhost:90/portal_api/index.php/berita
        } else {
            $this->db->where('IdNews', $IdNews);
            $this->db->where('FlagPublish', 1);
            $news = $this->db->get('news')->result(); // url api http://localhost:90/portal_api/index.php/berita?IdNews=3
        }
        $this->response($news, 200);
    }

    function index_beritabyCategory_get()
    {
        $IdCategory = $this->get('IdCategory');
        if ($IdCategory == '') {
            $this->db->order_by('IdCategory', "ASC");
            $news = $this->db->get('news')->result();
        } else {
            $this->db->where('IdCategory', $IdCategory);
            $this->db->where('FlagPublish', 1);
            $news = $this->db->get('news')->result();
        }
        $this->response($news, 200); // url api http://localhost:90/portal_api/index.php/berita/index_beritabyCategory?IdCategory=2
    }

    //     public function index_beritaRelated_get($keyword = null){
    //         if ($keyword === null) {
    //             $news = $this->db->get('news')->result();
    //         } else {
    //         $this->db->select('*');
    //         $this->db->from('news');
    //         if($keyword){
    //             $this->db->or_like('ContentNews',$keyword);
    //             $this->db->or_like('TitleNews',$keyword);
    //         }
    //         $news = $this->db->get('news')->result_array();
    //         $this->response($news, 200);
    //     }
    // }

    function index_beritaSearch_get()
    {
        $IdNews = $this->get('IdNews');
        $search = $this->input->get('search', TRUE);
        $this->db->like('ContentNews', $search);
        $this->db->or_like('TitleNews', $search);
        $this->db->or_like('CategoryNews', $search);
        $this->db->or_like('AuthorNews', $search);
        $this->db->where('FlagPublish', 1)->limit(5);
        $news = $this->db->get('news')->result();
        $this->response($news, 200); //url api 
    }

    function index_beritaRelated_get()
    {
        $IdNews = $this->get('IdNews');
        $ContentNews = $this->get('ContentNews');
        $TitleNews = $this->get('TitleNews');
        if ($ContentNews == '') {
            $this->db->order_by('IdNews', "ASC");
            $news = $this->db->get('news')->result();
        } else {
            $this->db->where('FlagPublish', 1);
            $this->db->like('ContentNews', $ContentNews);
            $this->db->or_like('TitleNews', $TitleNews)->limit(5);
            $news = $this->db->get('news')->result();
        }
        $this->response($news, 200); // url api http://localhost:90/portal_api/index.php/berita/index_beritabyCategory?IdCategory=2



        // $query = $this->db->where('IdNews', $IdNews);
        // $query = $this->db->get('news');
        // if($query->num_rows()>0){
        //     $row = $query->row();

        //     $TitleNews = $row->TitleNews;
        //     $slice = explode(" ", $TitleNews);
        //     if(count($slice) > 1){
        //         $keyword1 = $slice[0];
        //         $keyword2 = $slice[1];

        //         $sql = " SELECT * FROM news ";
        //         $sql .= " WHERE (ContentNews LIKE '%$keyword1%' OR ContentNews LIKE '%$keyword2%') AND FlagPublish = 1 ";					
        //         //$sql .= " AND FlagPublish = 1 ";
        //         $sql .= " ORDER BY CreatedNews DESC LIMIT 0, $Limit ";

        //         $query = $this->db->query($sql);
        //         if($query->num_rows()>0){
        //             $this->response($query, 200);
        //         }				
        //     }else{
        //         $sql = " SELECT * FROM news ";
        //         $sql .= " WHERE (ContentNews LIKE '%$TitleNews%') AND FlagPublish = 1 ";					
        //         //$sql .= " AND FlagPublish = 1 ";
        //         $sql .= " ORDER BY CreatedNews DESC LIMIT 0, $Limit ";

        //         $query = $this->db->query($sql);
        //         if($query->num_rows()>0){
        //             $this->response($query, 200);
        //         }				
        //     }				
    }

    // show data News by Category
    function index_category_get()
    {
        $CategoryNews = $this->get('CategoryNews');
        if ($CategoryNews == '') {
            $this->db->order_by('CategoryNews', "ASC");
            $news = $this->db->get('news')->result();
        } else {
            $this->db->where('CategoryNews', $CategoryNews);
            $news = $this->db->get('news')->result();
        }
        $this->response($news, 200);
    }

    function index_bymonth_get()
    {
        $IdNews = $this->get('IdNews');
        $CreatedNews = $this->get('CreatedNews');
        if ($IdNews == '') {

            $this->db->select('news.*, user.IdUser AS IdUser, user.NameUser');
            $this->db->join('user', 'news.IdUser = user.IdUser');
            $this->db->from('news', 5);
            $this->db->where('MONTH(CreatedNews)', date('m'));
            $this->db->where('YEAR(CreatedNews)', date('Y'));
            $this->db->where('FlagPublish', 1)->limit(10)->order_by('CreatedNews', "DESC");
            $news = $this->db->get()->result();

            // $this->db->where('MONTH(CreatedNews)', date('m'));
            // $this->db->where('YEAR(CreatedNews)', date('Y'));
            // $this->db->where('FlagPublish', 1)->limit(10);
            // $this->db->order_by('CreatedNews', "DESC");
            // $news = $this->db->get('news')->result();// api url http://localhost:90/portal_api/index.php/berita/index_bymonth
        } else {
            $this->db->where('IdNews', $IdNews);
            $this->db->where('FlagPublish', 1);
            $news = $this->db->get('news')->result();
        }
        $this->response($news, 200);

        // $Year = date('Y');
        // $Month = date('m');
        // $MonthYear = $Month.' '.$Year;
        // $query = $this->db->query("
        // SELECT * FROM news 
        // WHERE DATE_FORMAT(CreatedNews, '%M %Y') = '$MonthYear' AND FlagPublish = 1 
        // ORDER BY CreatedNews ASC LIMIT 7");

        // $bymonth = $this->db->get('news')->result();
        // $this->response($bymonth, 200);

        // if($query->num_rows()>0){
        //     return $query->result();
        // }else{
        //     return null;
    }

    // function indexs_get()
    // {
    //     if(!$this->get('ID_BERITA'))
    //     {
    //         $this->response(NULL, 400);
    //     }

    //     $user = $this->db->get( $this->get('ID_BERITA') );

    //     if($user)
    //     {
    //         $this->response($user, 200); // 200 being the HTTP response code
    //     }

    //     else
    //     {
    //         $this->response(NULL, 404);
    //     }
    // }

    // insert new data to mahasiswa
    function index_post()
    {
        $data = array(
            'AuthorNews' => $this->post('AuthorNews'),
            'TitleNews' => $this->post('TitleNews'),
            'ContentNews' => $this->post('ContentNews'),
            'CreatedNews' => $this->post('CreatedNews'),
            'UpdatedNews' => $this->post('UpdatedNews'),
            'FlagPublish' => $this->post('FlagPublish'),
            'FlagComment' => $this->post('FlagComment'),
            'FlagEditByOther' => $this->post('FlagEditByOther'),
            'CategoryNews' => $this->post('CategoryNews'),
            'UpdatedBy' => $this->post('UpdatedBy'),
            'FlagDate' => $this->post('FlagDate'),
            'ReadRating' => $this->post('ReadRating'),
            'Thumbnail' => $this->post('Thumbnail'),
            'LastUpdate' => $this->post('LastUpdate'),
            'IdUser' => $this->post('IdUser'),
            'IdCategory' => $this->post('IdCategory')
        );
        $insert = $this->db->insert('news', $data);
        if ($insert) {
            $this->response($data, 200);
            //$this->uploadImage();
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_uploadImage_post()
    {
        $config['upload_path']          = 'C:\xampp\htdocs\portal_api\application\controllers\upload_file';
        $config['allowed_types']        = 'gif|jpg|png';
        //$config['file_name']            = 'img';
        $config['overwrite']            = true;
        $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $response["Success"] = 1;
            $response["Filename"] = $_FILES['image']['name'];
            $response["Message"] = "Gambar berhasil diupload";
            $this->response($response, 200);
            return $this->upload->data();
        }
        //  $response["Success"] = 0;
        //  $response["Message"] = "Gambar gagal diupload";
        //  $this->response($response, 500);
        print_r($this->upload->display_errors()); // url http://172.16.17.61:90/portal_api/index.php/berita/index_uploadImage > body > multipart-formdata
        //return "default.jpg";
    }

    // update data mahasiswa
    function index_put()
    {
        $nim = $this->put('nim');
        $data = array(
            'nim'       => $this->put('nim'),
            'nama'      => $this->put('nama'),
            'id_jurusan' => $this->put('id_jurusan'),
            'alamat'    => $this->put('alamat')
        );
        $this->db->where('nim', $nim);
        $update = $this->db->update('mahasiswa', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    // delete mahasiswa
    function index_delete()
    {
        $nim = $this->delete('nim');
        $this->db->where('nim', $nim);
        $delete = $this->db->delete('mahasiswa');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
