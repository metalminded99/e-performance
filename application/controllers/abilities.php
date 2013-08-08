<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abilities extends CI_Controller {
	protected $user_job_id;
	protected $module = 'ability';

	public function __construct() {
		parent::__construct();
		$this->load->model( 'abilities_model' );

		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Ability list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'abilities' 
																					,$this->abilities_model->getTotalAbilities( JOB_ABILITIES, array( 'job_id' => $this->user_job_id ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$template_param['attributes'] = $this->abilities_model->getAllJobAbilities( $offset, PER_PAGE, array( 'job_id' => $this->user_job_id ) );

		# Template meta data
		$template_param['heading']			= 'Job Abilities for <i>'.$this->session->userdata( 'job_title' ).'</i>';
		$template_param['table_heading']	= array(
														'Ability Code'
														,'Ability Name'
														,'Ability Description'
														,'Active'
													);
		$template_param['add_link']			= base_url().'abilities/new_abilities';
		$template_param['delete_url']		= base_url().'abilities/delete_abilities';
		$template_param['update_url']		= base_url().'abilities/update_abilities';
		$template_param['add_link_text']	= 'Add Ability';
		$template_param['counter']	= $offset;
		$template_param['key']	= 'ability_id';


		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['attr_selection']	= $this->get_abilities_list();
		$template_param['content']			= 'templates/job_attribute_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function new_abilities() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_ability( 'new' );

		$template_param['action'] = 'Add New';
		$template_param['content']= 'abilities';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_abilities() {
		$job_ability = array( 
							'job_id' => $this->user_job_id
							,'active' => 'Yes'
						  );
		$items = $this->input->post( 'item' );
		if( $items ){
			for( $i = 0; $i < count( $items ); $i++ ){
				$ability = array( 'ability_id' => $items[$i] );
				$this->abilities_model->saveNewJobAbility( array_merge( $ability, $job_ability ) );
			}
		}

		$log = array( 
						'user_id'	=> $this->session->userdata( 'user_id' )
						,'module'	=> $this->module
						,'history'	=> 'Created new ability'
					);
		$this->template_library->insert_log( $log );
		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New ability has been added successfully!', 'class' => 'info' ) );
		redirect( base_url().'abilities' );
	}

	public function update_abilities() {
		if( $this->input->is_ajax_request() ){

			$items = $this->input->post( 'item' );
			if( $items ){
				for( $i = 0; $i < count( $items ); $i++ ){
					$where = array( 
									'ability_id' => $items[$i]
									,'job_id' => $this->user_job_id
								  );
					$this->abilities_model->updateJobAbility( array( 'active' => $this->input->post( 'state' ) ), $where );
				}
			}

			$log = array( 
							'user_id'	=> $this->session->userdata( 'user_id' )
							,'module'	=> $this->module
							,'history'	=> 'Updated ability'
						);
			$this->template_library->insert_log( $log );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Abilities has been updated successfully!', 'class' => 'info' ) );
			echo base_url().'abilities';

		}
	}

	public function get_abilities_list() {
		$data['save_url'] = base_url().'abilities/save_abilities';
		$data['attr_list'] = $this->abilities_model->getAllAbilities( 0, 1000 );
		return $this->load->view( 'templates/attribute_list_template', $data, true );
	}

	public function delete_abilities() {
		if( $this->input->is_ajax_request() ){
			if( is_array( $this->input->post('item') ) ){
				$items = $this->input->post('item');
				for( $s = 0; $s < count( $items ); $s++ ){
					$db_data = array( 
								'ability_id' => $items[ $s ]
								,'job_id' => $this->user_job_id
							);
					$this->abilities_model->deleteJobAbility( $db_data );
				}
			}else{
				$db_data = array( 
								'ability_id' => $this->input->post('item')
								,'job_id' => $this->user_job_id
							);
				$this->abilities_model->deleteJobAbility( $db_data );
			}
			
			$log = array( 
							'user_id'	=> $this->session->userdata( 'user_id' )
							,'module'	=> $this->module
							,'history'	=> 'Deleted ability'
						);
			$this->template_library->insert_log( $log );

			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Ability has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'abilities';
		}
	}

}

/* End of file abilities.php */
/* Location: ./application/controllers/abilities.php */