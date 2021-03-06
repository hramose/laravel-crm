<?php

class Clients_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{
		return View::make('home.clients')
			->with('title', 'Alle klanten')
			->with('clients', Clients::all());
	}
	
	public function get_view($id)
	{
		//$comments = Clients::find(1)->contacts->get();
		//echo '<pre>'; print_r($comments); echo '</pre>';
		return View::make('home.client')
			->with('title', 'Klant')
			->with('client', Clients::find($id))
			->with('contacts', Contacts::where('company_id', '=', $id)->get());			
	}
	
	public function get_new()
	{
		return 'I am group id ';
	}
	
	public function action_edit()
	{
		return 'henk';
	}
	
	public function get_edit_contact($id)
	{
		return View::make('home.contact_edit')
			->with('title', 'Edit contact')
			->with('contact', Contacts::find($id));
	}
	
	public function get_add_contact($id)
	{
		return View::make('home.contact_add')
			->with('client', Clients::find($id));
	}
	
	public function post_contact()
	{
		$cid = Input::get('client_id');
		$validation = Contacts::validate(Input::all());
		
		if($validation->fails()) {
			return Redirect::to_route('add_contact', $cid)->with_errors($validation);
		} else {
			Contacts::insert( array(
				'company_id'=>$cid,
				'name'=>Input::get('name'),
				'email'=>Input::get('email'),
				'telephone'=>Input::get('telephone'),
				'job_title'=>Input::get('job_title')
			));
			
			return Redirect::to_route('client', $cid)->with('message', 'Contact persoon is toegevoegd!');
		}
	}
	
	public function get_edit($id)
	{
		return View::make('home.clients_edit')
			->with('title','Edit client')
			->with('client', Clients::find($id));
	}
	
	public function put_update()
	{
		$id = Input::get('id');
		$validation = Clients::validate(Input::all());
		
		if($validation->fails()) {
			return Redirect::to_route('edit_client', $id)->with_errors($validation);
		} else {
			Clients::update($id, array(
				'name'=>Input::get('name')
			));
			
			return Redirect::to_route('clients', $id)->with('message', 'Client changed');
		}
	}
	
	public function put_update_contact()
	{
		$id = Input::get('id');
		$cid = Input::get('client_id');
		$validation = Contacts::validate(Input::all());
		
		if($validation->fails()) {
			return Redirect::to_route('edit_contact', $id)->with_errors($validation);
		} else {
			Contacts::update($id, array(
				'name'=>Input::get('name'),
				'email'=>Input::get('email'),
				'telephone'=>Input::get('telephone'),
				'job_title'=>Input::get('job_title')
			));
			
			return Redirect::to_route('client', $cid)->with('message', 'Contact persoon is aangepast!');
		}
	}

}