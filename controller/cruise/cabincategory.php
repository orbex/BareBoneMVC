<?php
/**
 * CabinCategory class controller for SilverJet BareBone.
 *
 * @package BareBone\Controller\Cruise 
 *
 * @author Jeroen Guyt <jeroen@clsystems.nl>
 *
 * @since 0.0.1
 *
 */
  

class ControllerCruiseCabinCategory extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->load->language('cruise/cabincategory');
    	
		$this->document->setTitle($this->language->get('text_cabincategories')); 
		
		$this->load->model('cruise/cabincategory');
		
		$this->getList();
  	}
   
  	public function insert() {
    	$this->load->language('cruise/cabincategory');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('cruise/cabincategory');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cruise_cabincategory->addCabinCategory($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . $this->request->get['filter_title'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('cruise/cabincategory');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('cruise/cabincategory');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_cruise_cabincategory->editCabinCategory($this->request->get['cabin_category_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . $this->request->get['filter_title'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('cruise/cabincategory');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('cruise/cabincategory');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $cabincategory_id) {
				$this->model_cruise_cabincategory->deleteCabinCategory($cabincategory_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . $this->request->get['filter_title'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . $url, 'SSL'));

		}

    	$this->getList();
  	}

  	public function copy() {
    	$this->load->language('cruise/cabincategory');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('cruise/cabincategory');
		
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $cabincategory_id) {
				$this->model_cruise_cabincategory->copyCabinCategory($cabincategory_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . $this->request->get['filter_title'];
			}
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	private function getList() {	
				
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = null;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cc.cabin_category_name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_cruise'),
			'href'      => $this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_cabincategories'),
			'href'      => $this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('cruise/cabincategory/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['copy'] = $this->url->link('cruise/cabincategory/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('cruise/cabincategory/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['cabincategories'] = array();

		$data = array(
			'filter_title'	  => $filter_title, 
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		
		$cabincategories_total = $this->model_cruise_cabincategory->getTotalCabinCategories($data);
			
		$results = $this->model_cruise_cabincategory->getCabinCategories($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('cruise/cabincategory/update', 'token=' . $this->session->data['token'] . '&cabin_category_id=' . $result['cabin_category_id'] . $url, 'SSL')
			);
				
      		$this->data['cabincategories'][] = array(
				'cabin_category_id' 	=> $result['cabin_category_id'],
				'cabin_category_name' 	=> $result['cabin_category_name'],
				'selected'  	=> isset($this->request->post['selected']) && in_array($result['cabin_category_id'], $this->request->post['selected']),
				'action'    	=> $action
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('text_cabincategories');		
				
		$this->data['text_yes'] = $this->language->get('text_yes');		
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');	
		$this->data['text_prices'] = $this->language->get('text_prices');		
			
		$this->data['column_title'] = $this->language->get('column_title');	

		$this->data['column_action'] = $this->language->get('column_action');		
				
		$this->data['button_copy'] = $this->language->get('button_copy');		
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');
		 
 		$this->data['token'] = $this->session->data['token'];
	
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_title'] = $this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . '&sort=cc.cabin_category_name' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
												
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $cabincategories_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_title'] = $filter_title;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'cruise/cabincategory_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] 		= $this->language->get('text_enabled');
    	$this->data['text_disabled'] 		= $this->language->get('text_disabled');
    	$this->data['text_none'] 			= $this->language->get('text_none');
    	$this->data['text_yes'] 			= $this->language->get('text_yes');
    	$this->data['text_no'] 				= $this->language->get('text_no');
		$this->data['text_select_all'] 		= $this->language->get('text_select_all');
		$this->data['text_unselect_all'] 	= $this->language->get('text_unselect_all');
		$this->data['text_plus'] 			= $this->language->get('text_plus');
		$this->data['text_minus'] 			= $this->language->get('text_minus');
		$this->data['text_default'] 		= $this->language->get('text_default');
		$this->data['text_image_manager'] 	= $this->language->get('text_image_manager');
		$this->data['text_browse'] 			= $this->language->get('text_browse');
		$this->data['text_clear'] 			= $this->language->get('text_clear');
		$this->data['text_option'] 			= $this->language->get('text_option');
		$this->data['text_option_value'] 	= $this->language->get('text_option_value');
		$this->data['text_select'] 			= $this->language->get('text_select');
		$this->data['text_none'] 			= $this->language->get('text_none');
		$this->data['text_percent'] 		= $this->language->get('text_percent');
		$this->data['text_amount'] 			= $this->language->get('text_amount');

		$this->data['entry_title'] 			= $this->language->get('entry_title');
				
    	$this->data['button_save'] 		= $this->language->get('button_save');
    	$this->data['button_cancel'] 	= $this->language->get('button_cancel');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
		 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

		$url = '';
			
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . $this->request->get['filter_title'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_cruise'),
			'href'      => $this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
									
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['cabin_category_id'])) {
			$this->data['action'] = $this->url->link('cruise/cabincategory/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('cruise/cabincategory/update', 'token=' . $this->session->data['token'] . '&cabin_category_id=' . $this->request->get['cabin_category_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('cruise/cabincategory', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['cabin_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$cabincategory_info = $this->model_cruise_cabincategory->getCabinCategory($this->request->get['cabin_category_id']);
    	}

		if (isset($this->request->post['cabin_category_name'])) {
      		$this->data['cabin_category_name'] = $this->request->post['cabin_category_name'];
    	} elseif (!empty($cabincategory_info)) {
			$this->data['cabin_category_name'] = $cabincategory_info['cabin_category_name'];
		} else {
      		$this->data['cabin_category_name'] = '';
    	}
				
		$this->template = 'cruise/cabincategory_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'cruise/cabincategory')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if (strlen($this->request->post['cabin_category_name']) < 1 || !isset($this->request->post['cabin_category_name']) ) {
      		$this->error['cabin_category_name'] = $this->language->get('cabin_category_name');
    	}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
    	if (!$this->error) {
			return true;
    	} else {
      		return false;
    	}
  	}
	
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'cruise/cabincategory')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
  	
  	private function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'cruise/cabincategory')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
}
?>