<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_skills extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'skills_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# Skills list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_skills' 
																		,$this->skills_model->getTotalSkills( SKILLS )
																		,'admin'
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage Skills';
		$data['listing'] = $this->skills_model->getAllSkills( $offset, PER_PAGE );
		$data['th'] = array(
								'Skill Code'
								,'Skill Name'
								,'Skill Description'
								,'Date Added'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_skills/new_skill'
										,'Add new skill'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_skills/delete_skill';
		$data['u_uri'] = 'manage_skills/update_skill';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_skill() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() )
			$this->save_skill( 'add' );

		# Skills form
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_skills', '', true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_skill( $skill_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );
		if( !is_integer( $skill_id ) && $skill_id == 0 )
			redirect( base_url().'control_panel/manage_skills' );

		if( $this->input->post() )
			$this->save_skill( 'edit' );

		# Skills form
		$skills = $this->skills_model->getAllSkills( 0, 1, array( 'skill_id' => $skill_id ) );
		$data['skills'] = $skills[0];
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_skills', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_skill( $action ) {
		if( $action == 'add' ) {
			$this->skills_model->saveNewSkill( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'New skill has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->skills_model->updateSkill( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'Skills has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_skills' );
	}

	public function delete_skill() {
		if( $this->input->is_ajax_request() ) {
			$this->skills_model->deleteSkill( array( 'skill_id' => $this->input->post( 'id' ) ) );
			echo "Skills deleted successfully!";
		}
	}

}

/* End of file manage_skills.php */
/* Location: ./application/controllers/manage_skills.php */