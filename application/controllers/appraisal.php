<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appraisal extends CI_Controller {
	protected $user_job_id;

	public function __construct() {
		parent::__construct();
		$this->load->model( 'appraisal_model' );

		$this->user_job_id = $this->session->userdata( 'job_id' );
	}

	public function index( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->load->library('user_agent');
		if( $this->agent->is_referral() ) {
			if( preg_match( '/update/', $this->agent->referrer() ) ) {
				$this->session->unset_userdata('app_data-title');
				$cat = $this->appraisal_model->getAppraisalMainCategories();
				foreach ($cat as $val) {
					$this->session->unset_userdata('app_data-'.$val['main_category_id'] );
				}
			}
		}
		# Appraisal list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'appraisal/index' 
																					,$this->appraisal_model->getTotalAppraisal( array( 'job_id' => $this->user_job_id ) )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
								 												);
		$template_param['appraisals'] = $this->appraisal_model->getAllAppraisal( $offset, PER_PAGE, array( 'job_id' => $this->user_job_id ) );

		# Template meta data
		$template_param['counter']	= $offset;
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'templates/appraisal_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function training( $offset = 0 ) {
		# Check user's session
		$this->template_library->check_session( 'user' );
		$this->load->library('user_agent');
		if( $this->agent->is_referral() ) {
			if( preg_match( '/update/', $this->agent->referrer() ) ) {
				$this->session->unset_userdata('app_data-title');
				$cat = $this->appraisal_model->getTrainingAppraisalMainCategories();
				foreach ($cat as $val) {
					$this->session->unset_userdata('app_data-'.$val['main_category_id'] );
				}
			}
		}
		# Appraisal list
		$template_param['pagination'] = $this->template_library->get_pagination(
																					'appraisal/training' 
																					,$this->appraisal_model->getTotalTrainingAppraisal( )
																					,PER_PAGE
																					,'user'
																					,($this->uri->segment(2)) ? $this->uri->segment(2) : 0
								 												);
		$template_param['appraisals'] = $this->appraisal_model->getAllTrainingAppraisal( $offset, PER_PAGE );

		# Template meta data
		$template_param['counter']	= $offset;
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'templates/appraisal_training_template';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function categories( ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		# Appraisal list
		$template_param['main_cat'] = $this->appraisal_model->getAppraisalMainCategories( );

		# Template meta data
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['content']			= 'appraisal_categories';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function add() {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() ){
			$step = $this->input->post( 'step' );
			$this->session->set_userdata( 'app_data-'.$this->input->post('module'), $this->input->post() );

			$cat = $this->appraisal_model->getAppraisalMainCategories();
			$template_param['cat_cnt'] = count( $cat );
			if( $step <= $template_param['cat_cnt'] )
				$template_param['cat'] = $cat[ ( $step - 1 ) ];
			else
				$this->save_appraisal( 'add' );
		}

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['step'] = @$step != '' ? $step + 1 : 1;
		$template_param['action'] = 'Add New Appraisal';
		$template_param['content']= 'add_appraisal';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function training_add() {
		# Check user's session
		$this->template_library->check_session( 'user' );
		if( $this->input->post() ){
			$this->session->set_userdata( 't_app_data', $this->input->post() );

			$this->save_appraisal( 'add_training' );
		}
		$this->load->model('trainings_model');
		$template_param['trainings'] = $this->trainings_model->getAllTrainings( 0, 10000 );
		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['action'] = 'Add New Training Appraisal';
		$template_param['content']= 'add_appraisal_training';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function save_appraisal( $action, $app_id = 0 ) {
		if( $action == 'add' ) {
			$db_data = $this->session->userdata( 'app_data-title' );
			$this->session->unset_userdata('app_data-title');

			$cat = $this->appraisal_model->getAppraisalMainCategories( );
			foreach ($cat as $val) {
				array_push( $db_data, $this->session->userdata( 'app_data-'.$val['main_category_id'] ) );
				$this->session->unset_userdata('app_data-'.$val['main_category_id'] );
			}

			$this->appraisal_model->saveNewAppraisal( $db_data );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New appraisal has been added successfully!', 'class' => 'info' ) );
		}elseif( $action == 'edit' ) {
			$db_data = $this->session->userdata( 'app_data-title' );
			$this->session->unset_userdata('app_data-title');

			$cat = $this->appraisal_model->getAppraisalMainCategories();
			foreach ($cat as $val) {
				array_push( $db_data, $this->session->userdata( 'app_data-'.$val['main_category_id'] ) );
				$this->session->unset_userdata('app_data-'.$val['main_category_id'] );
			}
			$this->appraisal_model->updateAppraisal( $app_id, $db_data );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal has been updated successfully!', 'class' => 'info' ) );
		}elseif( $action == 'add_training' ) {
			echo "<pre>";
			$db_data = $this->session->userdata( 't_app_data' );
			$app_data = array(
								 'training_id'		=> $db_data['training']
								,'appraisal_title'	=> $db_data['appraisal_title']
								,'appraisal_desc'	=> $db_data['appraisal_desc']
							 );
			$_app = $this->appraisal_model->addTrainingAppraisal( $app_data );

			$mc_id = array();
			for ( $m = 0; $m < count($db_data['training_mc']); $m++ ) {
				$mc_data = array(
									 'appraisal_id'			=> $_app
									,'main_category_name'	=> $db_data['training_mc'][$m]
									,'percentage'			=> $db_data['percentage'][$m]
								);
				$mc_id[] = $this->appraisal_model->addTrainingAppraisalMainCategories( $mc_data );
			}
			print_r($mc_id);
			foreach ($db_data as $key => $value) {
				if( preg_match('/sub_c/', $key) ){
					$s_ids		= explode('_', $key);
					$main		= $mc_id[1] - 1;
					$sub		= $s_ids[2];
					for( $s = 0; $s < count($value); $s++ ){
						// $subs[$sub] = $this->trainings_model->addTrainingAppraisalSubCategories( 
						// 																		array( 
						// 																				 'main_cat_id' => $mc_id[$main]
						// 																				,'appraisal_id' => $_app
						// 																				,'sub_category_name' => $value[$s]
						// 																			 ) 
						// 																		);
						print_r(array( 
									 'main_cat_id' => $mc_id[$main]
									,'appraisal_id' => $_app
									,'sub_category_name' => $value[$s]
								) );
					}
				}
			}
			print_r($db_data);
			exit();
			// $this->session->unset_userdata('t_app_data');

			$this->appraisal_model->updateAppraisal( $app_id, $db_data );
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal has been updated successfully!', 'class' => 'info' ) );
		}

		redirect( base_url().'appraisal' );
	}

	public function update( $app_id ) {
		# Check user's session
		$this->template_library->check_session( 'user' );

		if( $this->input->post() ){
			$step = $this->input->post( 'step' );
			$this->session->set_userdata( 'app_data-'.$this->input->post('module'), $this->input->post() );

			$cat = $this->appraisal_model->getAppraisalMainCategories( $app_id );
			if( $step <= count( $cat ) ){
				$template_param['cat'] = $cat[ ( $step - 1 ) ];
				$template_param['subs'] = $this->appraisal_model->getFeedbackQuestion( 
																						array( 
																								'q.category' => $cat[ ( $step - 1 ) ]['main_category_id'] 
																								,'sc.appraisal_id' => $app_id
																							) 
																					);
			}
			else
				$this->save_appraisal( 'edit', $app_id );
		}

		if ( !isset( $step ) ) {
			$template_param['appraisal'] = $this->appraisal_model->getAllAppraisal( 0, 1, array( 'appraisal_id' => $app_id ) );
		}

		$template_param['left_side_nav']	= $this->load->view( '_components/left_side_nav', '', true );
		$template_param['step'] = @$step != '' ? $step + 1 : 1;
		$template_param['action'] = 'Update Appraisal';
		$template_param['content']= 'add_appraisal';
		$this->template_library->render( 
											$template_param 
											,'user_header'
											,'user_top'
											,'user_footer'
											,'' 
										);
	}

	public function delete() {
		if( $this->input->is_ajax_request() ){
			$db_data = array( 'appraisal_id' => $this->input->post('item') );
			$this->appraisal_model->deleteAppraisal( $db_data );
			
			$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal has been deleted successfully!', 'class' => 'info' ) );
			echo base_url().'appraisal';
		}
	}

	public function ajax_request( ) {
		if( $this->input->is_ajax_request() ){
			$action = $this->input->post('action');
			if( $action != '' ){ 
				switch ( $action ) {
					case 'add_main_cat':
						$db_data = array(
											'main_category_name' => $this->input->post( 'sub_cat' )
											,'job_id' => $this->user_job_id
										);
						$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New appraisal main category has been added successfully!', 'class' => 'info' ) );
						echo $this->appraisal_model->addAppraisalMainCategories( $db_data );
						break;
					
					case 'add_sub_cat':
						$db_data = array(
											 'main_cat_id'			=> $this->input->post( 'main_id' )
											,'sub_category_name'	=> $this->input->post( 'sub_cat' )
										);
						$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> New appraisal sub category has been added successfully!', 'class' => 'info' ) );
						echo $this->appraisal_model->addAppraisalSubCategories( $db_data );
						break;
					
					case 'remove_sub_cat':
						$db_data = array( 'sub_category_id' => $this->input->post( 'item_id' ) );
						$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal sub category deleted successfully!', 'class' => 'info' ) );
						$this->appraisal_model->removeAppraisalSubCategories( $db_data );
						break;

					case 'update_sub_cat':
						$db_data = array( 'sub_category_name' => $this->input->post( 'item' ) );
						$where = array( 'sub_category_id' => $this->input->post( 'item_id' ) );

						$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal sub category updated successfully!', 'class' => 'info' ) );
						$this->appraisal_model->updateAppraisalSubCategories( $db_data, $where );
						break;

					case 'update_main_cat':
						$db_data = array( 'main_category_name' => $this->input->post( 'item' ) );
						$where = array( 'main_category_id' => $this->input->post( 'item_id' ) );

						$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal main category updated successfully!', 'class' => 'info' ) );
						echo $this->appraisal_model->updateAppraisalMainCategories( $db_data, $where );
						break;
					
					case 'remove_main_cat':
						$db_data = array( 'main_category_id' => $this->input->post( 'item_id' ) );
						$this->session->set_flashdata( 'message', array( 'str' => '<i class="icon-ok"></i> Appraisal main category deleted successfully!', 'class' => 'info' ) );
						$this->appraisal_model->removeAppraisalMainCategories( $db_data );
						break;
					
					
					default:
						# code...
						break;
				}
			}
		}
	}

}

/* End of file appraisal.php */
/* Location: ./application/controllers/appraisal.php */