<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skills extends CI_Controller {
	protected $user_job_id;
	protected $skill_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'skills_model' );

		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Skill list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'skills' 
																					,$this->skills_model->getTotalSkills( JOB_SKILLS, array( 'job_id' => $this->user_job_id ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
																				);
		$template_param['attributes'] = $this->skills_model->getAllJobSkills( $offset, PER_PAGE, array( 'job_id' => $this->user_job_id ) );

		# Template meta data
		$template_param['heading']			= 'Job Skills for <i>'.$this->session->userdata( 'job_title' ).'</i>';
		$template_param['table_heading']	= array(
														'Skill Code'
														,'Skill Name'
														,'Skill Description'
														,'Active'
													);
		$template_param['add_link']			= base_url().'skills/new_skills';
		$template_param['delete_url']		= base_url().'skills/delete_skills';
		$template_param['update_url']		= base_url().'skills/update_skills';
		$template_param['add_link_text']	= 'Add Skill';
		$template_param['counter']	= $offset;
		$template_param['key']	= 'skill_id';


		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['attr_selection']	= $this->get_skills_list();
		$template_param['content']			= 'templates/job_attribute_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function new_skills() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() )
			$this->save_skill( 'new' );

		$template_param['action'] = 'Add New';
		$template_param['content']= 'skills';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_skills() {
		$job_skill = array( 
							'job_id' => $this->user_job_id
							,'active' => 'Yes'
						  );
		$items = $this->input->post( 'item' );
		if( $items ){
			for( $i = 0; $i < count( $items ); $i++ ){
				$skill = array( 'skill_id' => $items[$i] );
				$this->skills_model->saveNewJobSkill( array_merge( $skill, $job_skill ) );
			}
		}
		$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New skill has been added successfully!', 'class' => 'info' ) );
		redirect( base_url().'skills' );
	}

	public function update_skills() {
		if( $this->input->is_ajax_request() ){

			$items = $this->input->post( 'item' );
			if( $items ){
				for( $i = 0; $i < count( $items ); $i++ ){
					$where = array( 
									'skill_id' => $items[$i]
									,'job_id' => $this->user_job_id
								  );
					$this->skills_model->updateJobSkill( array( 'active' => $this->input->post( 'state' ) ), $where );
				}
			}

			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Skills has been updated successfully!', 'class' => 'info' ) );
			echo base_url().'skills';

		}
	}

	public function get_skills_list() {
		$data['save_url'] = base_url().'skills/save_skills';
		$data['attr_list'] = $this->skills_model->getAllSkills( 0, 1000 );
		return $this->load->view( 'templates/attribute_list_template', $data, true );
	}

	public function delete_skills() {
		if( $this->input->is_ajax_request() ){
			if( is_array( $this->input->post('item') ) ){
				$items = $this->input->post('item');
				for( $s = 0; $s < count( $items ); $s++ ){
					$db_data = array( 
								'skill_id' => $items[ $s ]
								,'job_id' => $this->user_job_id
							);
					$this->skills_model->deleteJobSkill( $db_data );
				}
			}else{
				$db_data = array( 
								'skill_id' => $this->input->post('item')
								,'job_id' => $this->user_job_id
							);
				$this->skills_model->deleteJobSkill( $db_data );
			}
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Skill has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'skills';
		}
	}

}

/* End of file skills.php */
/* Location: ./application/controllers/skills.php */