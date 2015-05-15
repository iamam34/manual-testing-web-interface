<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tests extends CI_Controller {
    public function index() {        
        $this->load->model('test');
        $this->load->model('result');
        
        // harvest selections
        // check for posts first because the gets seem to hang around in the url
        if ($this->input->post('submit_test_edit')) {
            $selected_test_id = $this->input->post('id');
            
            $this->setup_form_validation_test();
            if ($this->form_validation->run() === TRUE) {
                $selected_test_id = $this->save_to_database($this->test, $selected_test_id, $this->collect_test_data());
            }
        } else if ($this->input->post('submit_result_edit')) {
            $selected_test_id = $this->input->post('testId');
            $selected_result_id = $this->input->post('id');
            
            $this->setup_form_validation_result();
            if ($this->form_validation->run() === TRUE) {
                $selected_result_id = $this->save_to_database($this->result, $selected_result_id, $this->collect_result_data());
            }
        } else if ($this->input->post('submit_test_delete')) {
            $id = $this->input->post('id');
            
            $this->test->delete($id);
        } else if ($this->input->post('submit_result_delete')) {
            $selected_test_id = $this->input->post('testId');
            $id = $this->input->post('id');
            
            $this->result->delete($id);
        } else {
            if ($this->input->get('testId')) {
                $selected_test_id = $this->input->get('testId');
            } if ($this->input->get('resultId')) {
                $selected_result_id = $this->input->get('resultId');
            }
        }
        
        // populate the data array
        $data['tests'] = $this->test->list_all();
        if (isset($selected_test_id) && $selected_test_id) {
            // populate test-specific fields
            $data['selected_test'] = $this->test->read($selected_test_id);
            $data['test_results'] = $this->result->list_all($selected_test_id);

            if (isset($selected_result_id) && $selected_result_id) {
                // populate result-specific fields
                $data['selected_result'] = $this->result->read($selected_result_id);
            }
        }

        $this->display_view('tests', $data);
    }
    
    private function save_to_database($model, $id, $form_data) {
        if ($id) {
            return $model->update($id, $form_data);
        } else {
            return $model->create($form_data);
        }
    }
    
    private function collect_test_data() {
        return array(
            'title' => $this->input->post('title', TRUE),
            'steps' => $this->input->post('steps', TRUE),
            'expectedResult' => $this->input->post('expectedResult', TRUE),
            'creator' => $this->input->post('creator', TRUE),
            'creationDate' => $this->input->post('creationDate', TRUE)
        );
    }

   private function collect_result_data() {
       return array(
            'testId' => $this->input->post('testId', TRUE),
            'date' => $this->input->post('date', TRUE),
            'tester' => $this->input->post('tester', TRUE),
            'operatingSystem' => $this->input->post('operatingSystem', TRUE),
            'build' => $this->input->post('build', TRUE),
            'result' => $this->input->post('result', TRUE),
            'comment' => $this->input->post('comment', TRUE)
        );
    }

    /**
     * Loads a php view into the master template
     * @param type $page php view
     * @param type $data optional auxiliary data for the view
     */
    private function display_view($page, $data = null) {
        if (!file_exists(APPPATH . '/views/pages/' . $page . '.php')) {
            show_404();
        }
        $data['title'] = ucfirst($page);  // Capitalize the first letter
        $data['content'] = $this->load->view('pages/' . $page, $data, TRUE); // Generate page as string
        $this->load->view('templates/master', $data);
    }

    private function setup_form_validation_test() {
        $rules = array();
        foreach (array('title', 'steps', 'expectedResult', 'creator', 'creationDate') as $field) {
            $rules[$field] = array(
                'field' => $field,
                'label' => $field,
                'rules' => 'trim|required|xss_clean'
            );
        }
        $rules['expectedResult']['rules'] = 'trim|xss_clean';
        $rules['creationDate']['rules'] = 'trim|callback_verify_date|xss_clean';
            
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $this->form_validation->set_rules($rules);
    }
    
    private function setup_form_validation_result() {
        foreach (array('testId', 'date', 'tester', 'operatingSystem', 'build', 'result', 'comment') as $field) {
            $rules[$field] = array(
                'field' => $field,
                'label' => $field,
                'rules' => 'trim|required|xss_clean'
            );
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $rules['date']['rules'] = 'trim|required|xss_clean|callback_verify_date';
        $rules['comment']['rules'] = 'trim|xss_clean';
        $this->form_validation->set_rules($rules);
    }
    
    /**
     * https://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#callbacks
     * @param type $str
     */
    public function verify_date($str) {
        $REGEX = '/(\d{4})-(\d{2})-(\d{2})/';
        $out = array();
        if (preg_match($REGEX, $str, $out) && checkdate($out[2], $out[3], $out[1])) {
            return TRUE;
        } else {
            $this->form_validation->set_message('verify_date', 'The %s field must be a valid date (yyyy-mm-dd).');
            return FALSE;
        }
    }
}
