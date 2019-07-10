<?php

class ModelUser extends CI_Model {

    public $username;
    public $email;
    public $autorId;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function usernameCheck() {
        $this->db->where('username', $this->username);
        $result = $this->db->get('users');
        if ($result->result())
            return TRUE;
        else
            return false;
    }

    public function passwordCheck($password) {
        $this->db->where('username', $this->username);
        $this->db->where('password', $password);
        $result = $this->db->get('users');
        $user = $result->row_array();

        if ($user != NULL) {
            $this->email = $user['email'];
            $this->autorId = $user['id'];
            return TRUE;
        } else
            return false;
    }

    public function addArticle($articleTitle, $articleBody, $articlePicture) {
        $autorId = $this->session->userdata("user")->autorId;
        $this->db->set("title", $articleTitle);
        $this->db->set("body", $articleBody);
        $this->db->set("image", $articlePicture);
        $this->db->set("authorId", $autorId);
        $this->db->insert("articles");
        $query = $this->db->query("SELECT a.* FROM articles a INNER JOIN (SELECT authorId, MAX(id) id FROM articles 
            WHERE authorId = '$autorId'
            GROUP BY authorId
            ) b ON a.authorId = b.authorId AND a.id = b.id");
        $addedArticle = $query->result_array();
        if ($addedArticle) {
            return $addedArticle;
        } else {
            return false;
        }
    }

    public function updateArticle($articleTitleUpdate, $articleBodyUpdate, $articlePictureUpdate, $articleHiddenUpdate) {
        $autorId = $this->session->userdata("user")->autorId;
        $query = $this->db->query("UPDATE articles
        SET title = '$articleTitleUpdate', body= '$articleBodyUpdate', image = '$articlePictureUpdate' WHERE id = '$articleHiddenUpdate' AND authorId = '$autorId'");
        $updatedArticle = $query->row_array();
        if ($updatedArticle) {
            return $updatedArticle;
        } else {
            return false;
        }
    }

    public function fetchArticles() {
        $query = $this->db->get('articles');
        $result = $query->result_array();
        return $result;
    }

    public function fetchArticlesForLogedUsers() {
        $autorId = $this->session->userdata("user")->autorId;
        $this->db->where('authorId', $autorId);
        $query = $this->db->get('articles');
        $result = $query->result_array();
        return $result;
    }

    public function deleteArticle($id) {
        $autorId = $this->session->userdata("user")->autorId;
        $this->db->where('id', $id);
        $this->db->where('authorId', $autorId);
        $this->db->delete('articles');
    }

}
