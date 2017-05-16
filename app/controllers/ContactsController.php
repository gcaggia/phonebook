<?php

use Phalcon\Mvc\Controller;

class ContactsController extends Controller {
    
    public function initialize()
    {
        $this->view->setTemplateAfter("basic");
    }
    
    public function indexAction()
    {
        $this->view->contacts = Contacts::find();
        $this->view->title = "My Contacts";
    }
    
}
