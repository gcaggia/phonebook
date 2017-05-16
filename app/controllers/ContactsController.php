<?php

use Phalcon\Mvc\Controller;

class ContactsController extends Controller {
    
    public function indexAction()
    {
        $this->view->contacts = Contacts::find();
        $this->view->title = "My Contacts";
    }
    
}
