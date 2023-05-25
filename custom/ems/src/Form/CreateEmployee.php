<?php
/**
 * @file
 * Contains \Drupal\ems\Form\CreateEmployee.
 */
namespace Drupal\ems\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\File\FileSystemInterface;

class CreateEmployee extends FormBase
{ /**
  * {@inheritdoc}
  */
    public function getFormId()
    {
        return 'employee_form';
    }
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['ID'] = array(
            '#type' => 'textfield',
            '#title' => t('Enter ID:'),
            '#required' => TRUE,
            '#attributes' => [
                'style' => 'padding: 5px;
                border: 1px solid #ccc;
                border-radius: 4px;',
            ]
        );
        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Enter Name:'),
            '#required' => TRUE,
            '#attributes' => [
                'style' => 'padding: 5px;
                border: 1px solid #ccc;
                border-radius: 4px;',
            ]
        );
        $form['salary'] = array(
            '#type' => 'textfield',
            '#title' => t('Enter Salary:'),
            '#required' => TRUE,
            '#attributes' => [
                'style' => 'padding: 5px;
                border: 1px solid #ccc;
                border-radius: 4px;',
            ]
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#button_type' => 'primary',
            '#attributes' => [
                'style' => 'padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;'
            ]
        );
        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $id = $_POST['ID'];
        $name = $_POST['name'];
        $salary = $_POST['salary'];
        $filename = "employee_data.txt";
        $data = $id . "," . $name . "," . $salary . PHP_EOL;
        $file_system = \Drupal::service('file_system');
        $module_path = drupal_get_path('module', 'ems');
        $file_path = $module_path . '/' . $filename;
        $file_contents = file_get_contents($file_path);
        $file_contents .= $data;
        $status = $file_system->saveData($file_contents, $file_path, FileSystemInterface::EXISTS_REPLACE);
        if ($status !== FALSE) {
            // File was successfully saved.
            // You can perform additional actions here if needed.
            \Drupal::messenger()->addMessage(t("File Updated Successfully"));

        }
    }
}

?>