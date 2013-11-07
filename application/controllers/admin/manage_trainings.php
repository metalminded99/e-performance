<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Trainings extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'trainings_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# Trainings list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_trainings' 
																		,$this->trainings_model->getTotalTrainings()
																		,'admin'
																		,PER_PAGE
																	 );

		$data['h_title']   = 'Manage Trainings';
		$data['listing'] = $this->trainings_model->getAllTrainings( $offset, PER_PAGE );
		$data['th'] = array(
								'Training Title'
								,'Training Description'
								,'Duration'
								,'Date Created'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_trainings/new_training'
										,'Add new training'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_trainings/delete_training';
		$data['u_uri'] = 'manage_trainings/update_training';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_training() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() )
			$this->save_training( 'add' );

		$this->load->model( 'skills_model' );
		$this->load->model( 'abilities_model' );

		$data['t_skills']	= array();
		$data['t_abilities']= array();
		$data['skills']		= $this->skills_model->getAllSkills( 0, 1000 );
		$data['abilities']	= $this->abilities_model->getAllAbilities( 0, 1000 );

		# Trainings form
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_trainings', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_training( $training_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );
		if( !is_integer( $training_id ) && $training_id == 0 )
			redirect( base_url().'control_panel/manage_trainings' );

		if( $this->input->post() )
			$this->save_training( 'edit' );

		$this->load->model( 'skills_model' );
		$this->load->model( 'abilities_model' );

		$data['skills']		= $this->skills_model->getAllSkills( 0, 1000 );
		$data['abilities']	= $this->abilities_model->getAllAbilities( 0, 1000 );
		
		# Trainings form
		$training_skills	= $this->trainings_model->getTrainingSkills( $training_id );
		$training_abilities	= $this->trainings_model->getTrainingAbilities( $training_id );
		$trainings			= $this->trainings_model->getAllTrainings( 0, 1, array( 'training_id' => $training_id ) );
		$data['t_skills']	= $training_skills;
		$data['t_abilities']= $training_abilities;
		$data['trainings']	= $trainings[0];

		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_trainings', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_training( $action ) {
		if( $action == 'add' ) {
			$this->trainings_model->saveNewTraining( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'New training has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->trainings_model->updateTraining( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'Training has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_trainings' );
	}

	public function delete_training() {
		if( $this->input->is_ajax_request() ) {
			$this->trainings_model->deleteTraining( array( 'training_id' => $this->input->post( 'id' ) ) );
			echo "Trainings deleted successfully!";
		}
	}

}

/* End of file manage_trainings.php */
/* Location: ./application/controllers/manage_trainings.php */