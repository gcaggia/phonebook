<?php

use Phalcon\Mvc\Controller;

class ContactsController extends Controller {
    
    public function initialize()
    {
        $this->view->setTemplateAfter("basic");
    }
    
    /**
     * Display all the contact
     */
    public function indexAction()
    {
        $this->view->contacts = Contacts::find(array('order' => 'name'));
        $this->view->title = "My Contacts";
    }
    
    /**
     * Rendering the new form to create a new Contact
     */
    public function newAction()
    {
        $this->view->title = "New Contact";
    }
    
    /**
     * Create a new contact
     */
    public function createAction()
    {
        $contact = new Contacts();
        // $contact->name  = $this->request->getPost('name');
        // $contact->phone = $this->request->getPost('phone');
        // $contact->email = $this->request->getPost('email');
        
        $success = $contact->save($this->request->getPost(), 
                                  array('name', 'phone', 'email'));
        
        if($success) {
            
            $this->flash->success('The contact has been created successfully');
            
            // We redirect to the index contacts page in case of success
            $this->dispatcher->forward(['action' => 'index']);
            
        } else {
            
            $errors = '<strong>Unable to add this new contact... Following errors occured:</strong><br><ul>';
            foreach ($contact->getMessages() as $message) {
                $errors .= '<li>' . $message . '</li>';
            }
            
            $this->flash->error($errors . '</ul>');
            
            // We redirect to the new contact form in case of an error
            $this->dispatcher->forward(['action' => 'new']);
        }
    }
    
    
    /**
     * Update a Contact
     */
    public function updateAction()
    {
        
        if ($this->request->getPost()) {
            
            $id = $this->request->getPost('id');
            $contact = Contacts::findFirst($id);
            
            if(!$contact) {
                $this->flash->error('This contact does not exist...');
                
                // We redirect to the index page in case of this error
                $this->dispatcher->forward(['action' => 'index']);
            } else {
                
                $success = $contact->save($this->request->getPost(), 
                                  array('name', 'phone', 'email'));
                
                
                if($success) {
            
                    $this->flash->success('The contact has been updated successfully');
                    
                    // We redirect to the index contacts page in case of success
                    $this->dispatcher->forward(['action' => 'index']);
                    
                } else {
                    
                    $errors = '<strong>Unable to edit this contact... Following errors occured:</strong><br><ul>';
                    foreach ($contact->getMessages() as $message) {
                        $errors .= '<li>' . $message . '</li>';
                    }
                    
                    $this->flash->error($errors . '</ul>');
                    
                    // We redirect to the new contact form in case of an error
                    $this->dispatcher->forward(['action' => 'edit']);
                }
                
            }
            
        } else {
            $this->flash->error('Invalid request...');
            $this->dispatcher->forward(['action' => 'index']);
        }
    
    }
    
    
    /**
     * Rendering the form to edit a Contact
     */
    public function editAction($id)
    {
        if (!$this->request->getPost()) {
            $contact = Contacts::findFirst($id);
            
            if(!$contact) {
                $this->flash->error('This contact does not exist...');
                
                // We redirect to the index page in case of this error
                $this->dispatcher->forward(['action' => 'index']);
            } else {
                
                $this->tag->displayTo('id', $contact->id);
                $this->tag->displayTo('name', $contact->name);
                $this->tag->displayTo('email', $contact->email);
                $this->tag->displayTo('phone', $contact->phone);
                
                $this->view->title = "Edit Contact";
                
            }
            
        } else {
            $this->flash->error('Invalid request...');
            $this->dispatcher->forward(['action' => 'index']);
        }
    }
    
    
    /**
     * Delete a contact
     */
    public function deleteAction($id)
    {
        $contact = Contacts::findFirst($id);
        
        if(!$contact) {
            $this->flash->error('This contact does not exist...');
        } else {
            
            if(!$contact->delete()) {
                foreach ($contact->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $this->flash->success('The contact has been deleted successfully');
            }
        }
        
        $this->dispatcher->forward(['action' => 'index']);
        
    }
    
}
