<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/8/14
 * Time: 10:09 PM
 */

class TestController extends CI_Controller
{
    public function index($page)
    {
        $this->load->view("templates/header", array("pageTitle"=>"Test Page"));
        $this->load->view("TestPages/".$page);
        $this->load->view("templates/footer");
    }
}