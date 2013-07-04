<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Abilities extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model( 'abilities_model' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( );

		# Abilities list
		$data['pagination'] = $this->template_library->get_pagination(
																		'control_panel/manage_abilities' 
																		,$this->abilities_model->getTotalAbilities( ABILITIES )
																		,PER_PAGE
																	 );

		$data['h_title'] = 'Manage Abilities';
		$data['listing'] = $this->abilities_model->getAllAbilities( $offset, PER_PAGE );
		$data['th'] = array(
								'Ability Code'
								,'Ability Name'
								,'Ability Description'
								,'Date Added'
							);
		$data['add_button'] = anchor(
										base_url().'control_panel/manage_abilities/new_ability'
										,'Add new ability'
										,'class="button add"'
									);
		$data['counter'] = $offset;
		$data['d_uri'] = 'manage_abilities/delete_ability';
		$data['u_uri'] = 'manage_abilities/update_ability';
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'templates/results_listing', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function new_ability() {
		# Check user's session
		$this->template_library->check_session( );

		if( $this->input->post() )
			$this->save_ability( 'add' );

		# Abilities form
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_abilities', '', true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function update_ability( $ability_id = 0 ) {
		# Check user's session
		$this->template_library->check_session( );
		if( !is_integer( $ability_id ) && $ability_id == 0 )
			redirect( base_url().'control_panel/manage_abilities' );

		if( $this->input->post() )
			$this->save_ability( 'edit' );

		# Abilities form
		$abilities = $this->abilities_model->getAllAbilities( 0, 1, array( 'ability_id' => $ability_id ) );
		$data['abilities'] = $abilities[0];
		$template_param['sidebar'] = $this->load->view( '_components/sidebar', '', true );
		$template_param['main_content'] = $this->load->view( 'admin/manage_abilities', $data, true );
		$template_param['content'] = 'templates/admin_template';

		# Render page
		$this->template_library->render( $template_param );
	}

	public function save_ability( $action ) {
		if( $action == 'add' ) {
			$this->abilities_model->saveNewAbility( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'New ability has been added successfully!', 'class' => 'n_ok' ) );
		}elseif( $action == 'edit' ) {
			$this->abilities_model->updateAbility( $this->input->post() );
			$this->session->set_flashdata( 'message', array('str' => 'Ability has been updated successfully!', 'class' => 'n_ok' ) );
		}

		redirect( base_url().'control_panel/manage_abilities' );
	}

	public function delete_ability() {
		if( $this->input->is_ajax_request() ) {
			$this->abilities_model->deleteAbility( array( 'ability_id' => $this->input->post( 'id' ) ) );
			echo "Abilities deleted successfully!";
		}
	}

}

/* End of file manage_abilities.php */
/* Location: ./application/controllers/manage_abilities.php */