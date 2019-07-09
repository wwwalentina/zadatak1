<?php

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("ModelUser");
        $this->load->library('session');
        if (($this->session->userdata('user')) == NULL)
            redirect("Guest");
    }

    private function loadView($data, $mainPart) {
        $this->load->view("includes/header.php", $data);
        $this->load->view($mainPart, $data);
        $this->load->view("includes/footer.php");
    }
    
    public function home() {
        $this->loadView(NULL, "home.php");
    }

    public function loadCreateArticle() {
        $this->loadView(NULL, "createArticle.php");

        print_r($this->session->userdata("user")->autorId);
    }
    
    public function loadListArticles() {
        $this->loadView(NULL, "listArticles.php");
    }
    
    public function loadFullArticle() {
        $this->loadView(NULL, "singleArticle.php");
    }
    
    public function loadDeleteArticle() {
        $this->loadView(NULL, "deleteArticle.php");
    }
    
    public function loadUpdateArticle() {
        $this->loadView(NULL, "updateArticle.php");
    }
    
    public function loadFullArticleUpdate() {
        $this->loadView(NULL, "singleArticleUpdate.php");
    }

    public function createArticle() {
//        $articleTitle = $this->input->post('articleTitle');
//        $articleBody = $this->input->post('articleBody');
       $rawArticleData = file_get_contents("php://input");
       $decoded = json_decode($rawArticleData);
       $articleTitle = $decoded->articleTitle;
       $articleBody = $decoded->articleBody;
       $articlePicture = $decoded->articlePicture;
        $createdArticle = $this->ModelUser->addArticle($articleTitle, $articleBody, $articlePicture);
        if (!$createdArticle == 0) {
            $json = json_encode($createdArticle);
            print_r($json);
        } else {
            $data['message'] = "Error. Creation of the article failed!";
            error_log($data);
        }
    }
    
        public function listArticles() {
//        $this->loadView(NULL, "listArticles.php");
        $articles = $this->ModelUser->fetchArticles();
        if (!$articles == 0) {
            $json = json_encode($articles);
//            echo $json;
            print_r($json);
            return $json;
        } else {
            $data['message'] = "Error. Creation of the article failed!";
            error_log($data);
        }
    }
    
    public function updateArticle() {
        $rawArticleData2 = file_get_contents("php://input");
        $decoded2 = json_decode($rawArticleData2);
        $articleTitleUpdate = $decoded2->articleTitleUpdate;
        $articleBodyUpdate = $decoded2->articleBodyUpdate;
        $articlePictureUpdate = $decoded2->articlePictureUpdate;
        $updatedArticle = $this->ModelUser->updateArticle($articleTitleUpdate, $articleBodyUpdate, $articlePictureUpdate);
        if (!$updatedArticle == 0) {
            $json = json_encode($updatedArticle);
            print_r($json);
        } else {
            $data['message'] = "Error. Update of the article failed!";
            error_log($data);
        }
    }
    
    public function deleteArticle() {
        $id = $this->uri->segment(3);
        $this->ModelUser->deleteArticle($id);
    }

    

    public function logout() {
        $this->session->unset_userdata("user");
        $this->session->sess_destroy();
        redirect("Guest");
    }

}
