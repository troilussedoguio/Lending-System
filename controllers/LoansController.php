<?php 

namespace controllers;

use models\Loans;

class LoansController{
    private $loansModel;


    public function __construct($db){
        $this->loansModel = new Loans($db);
    }

    public function createLoans($form){
       return $this->loansModel->insertLoans($form);
    }

    public function fetchLoans(){
       return $this->loansModel->getLoans();
    }

    public function fetchPercentage(){
       return $this->loansModel->getPercentage();
    }

    public function dashboardCards(){
       return $this->loansModel->getDashboard();
    }

    public function weeklyPayment($data){
       return $this->loansModel->getWeekly($data);
    }

     public function fetchDueDate(){
       return $this->loansModel->dueDate();
    } 

    public function savePercentage($value){
      return $this->loansModel->updatePercentage($value);
    }
    public function updateWeekly($value){
      return $this->loansModel->updateWeeklyPayment($value);
    }
    public function editLoans($id){
      return $this->loansModel->editLoan($id);
    }
    public function deleteLoanInfos($data){
      return $this->loansModel->deleteLoanInfo($data);
    }

    public function sendDueDates(){
      return $this->loansModel->sendDueDate();
    }
    public function additionInterests(){
      return $this->loansModel->additionInterest();
    }
    
}

?>