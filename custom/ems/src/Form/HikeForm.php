<?php
/**
 * @file
 * Contains \Drupal\ems\Form\HikeForm.
 */
namespace Drupal\ems\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\File\FileSystemInterface;

class HikeForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'emp_form';
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
        $form['hike'] = array(
            '#type' => 'textfield',
            '#title' => t('Enter Hike(in %):'),
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
        $hike_amount = $_POST['hike'];
        $filename = "employee_data.txt";
        $file_system = \Drupal::service('file_system');
        $module_path = drupal_get_path('module', 'ems');
        $file_path = $module_path . '/' . $filename;
        $file_contents = file_get_contents($file_path);
        $lines = explode("\n", $file_contents);
        // Traverse the lines and perform operations.
        $writecontents = '';
        $statusW = 0;
        $data = '';
        foreach ($lines as $line) {
            // Process each line here.
            $linearr = explode(",", $line);
            if ($linearr[0] == $id) {
                $salary = $linearr[2];
                $new_salary = $salary + ($salary * $hike_amount / 100);
                $linearr[2] = $new_salary;
                $statusW = 1;
            }
            $data = implode(',', $linearr);
            $writecontents .= $data . "\n";
        }

        $status = $file_system->saveData($writecontents, $file_path, FileSystemInterface::EXISTS_REPLACE);
        if ($status !== FALSE && $statusW == 1) {
            // File was successfully saved.
            // You can perform additional actions here if needed.
            \Drupal::messenger()->addMessage(t("File Updated Successfully"));

        }
        if ($statusW == 0) {
            \Drupal::messenger()->addMessage(t("Employee Not Found!"));

        }

    }
}