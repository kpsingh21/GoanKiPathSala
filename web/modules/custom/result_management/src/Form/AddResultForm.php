<?php

namespace Drupal\result_management\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CloseDialogCommand;
use Drupal\Core\Ajax\RedirectCommand;


/**
 * Implements Add Result Form
 */


class AddResultForm extends FormBase {

    /**
     * { @inheritdoc }
     */

     public function getFormId(){
        return 'add_result';
     }

     /**
      * {@inheritdoc}
      */

    public function buildForm(array $form, FormStateInterface $form_state){

        $list_of_student = [];
        $content_type='student';
        $nodes=\Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type'=>$content_type,'status'=>1]);

        if(!empty($nodes)){
            foreach($nodes as $node){
                  $name = $node->get('field_name')->value;
                  $roll_no= $node->get('field_roll_no')->value;
                  $list_of_student[$roll_no] = $name . '(' . $roll_no . ')';
            }
        }


        $list_of_subject = [];
        $vid = 'subjects';
        $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
        foreach ($terms as $term) {
          // Access term data like $term->name or $term->tid
          $list_of_subject[$term->name]=$term->name;
        }

       $form['student_name']=[
        '#type'=>'select',
        '#title'=>'Select Student',
        '#options'=>$list_of_student,
        '#empty_option' => $this->t('- Select Student -'),
    
       ];

       $form['subject']=[
        '#type'=>'select',
        '#title'=>'Select Subject',
        '#options'=>$list_of_subject,
        '#empty_option' => $this->t('- Select Subject -'),
       ];

       $form['student_uid']=[
        '#type'=>'textfield',
        "#title"=>'student_uid'
       ];

       $form['roll_no']=[
        '#type'=>'textfield',
        "#title"=>'roll no'
       ];

       $form['marks_obtained']=[
        '#type'=>'number',
        "#title"=>'Marks Obtained'
       ];

       $form['academic_year_id']=[
        '#type'=>'number',
        "#title"=>'academic_year_id'
       ];

       $form['subject_tid']=[
        '#type'=>'number',
        "#title"=>'subject_tid'
       ];

       $form['total_marks']=[
        '#type'=>'number',
        "#title"=>'total_marks'
       ];
  
       $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Go to URL'),
        '#attributes' => ['formtarget' => '_blank'],
      ];

      $form['actions'] = [
        '#type' => 'actions',
      ];
      
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Save Result'),
        // '#ajax' => [
        //   'callback' => '::ajaxSubmit',
        // ],
      ];
      
      $form['actions']['cancel'] = [
        '#type' => 'button',
        '#value' => $this->t('Cancel'),
        '#ajax' => [
          'callback' => '::ajaxCancel',
        ],
      ];
      


       return $form;

    }

     /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // $this->messenger()->addStatus($this->t('Your phone number is @number', ['@number' => $form_state->getValue('phone_number')]));

    \Drupal::database()->insert('result')
    ->fields([
      'student_uid' => $form_state->getValue('student_uid'),
      'academic_year_id' => $form_state->getValue('academic_year_id'),
      'roll_no' => $form_state->getValue('roll_no'),
      'subject_tid' => $form_state->getValue('subject_tid'),
      'marks' => $form_state->getValue('marks_obtained'),
    ])
    ->execute();

  }


  // public function ajaxSubmit(array &$form, FormStateInterface $form_state) {
  //   $response = new AjaxResponse();
  
  //   // Close modal
  //   $response->addCommand(new CloseDialogCommand());
  
  //   // Optional: redirect after close
  //   // $response->addCommand(new RedirectCommand('/student-results'));
  
  //   return $response;
  // }


  public function ajaxCancel(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $response->addCommand(new CloseDialogCommand());
    return $response;
  }
  
  
 }