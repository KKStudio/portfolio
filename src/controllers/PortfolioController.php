<?php namespace Kkstudio\Portfolio\Controllers;

use Illuminate\Routing\Controller;
use Kkstudio\Portfolio\Models\Portfolio;
use Kkstudio\Portfolio\Repositories\PortfolioRepository;

class PortfolioController extends Controller {

	public function admin(PortfolioRepository $repo) {

		$projects = $repo->all();

		return \View::make('portfolio::admin')->with('projects', $projects);

	}

	public function create() 
	{
		return \View::make('portfolio::create');
	}

	public function postCreate(PortfolioRepository $projects) 
	{
		if(! \Request::get('name')) {

			\Flash::error('Please provide a name.');

			return \Redirect::back()->withInput();

		}

		$name = \Request::get('name');
		$slug = \Str::slug($name);
		$description = \Request::get('description');
		$image = '';

		$exists = $projects->get($slug);

		if($exists) {

			\Flash::error('Project with that name already exists.');

			return \Redirect::back()->withInput();

		}

		$project = $projects->create($slug, $name, $description, $image);

		\Flash::success('Project created successfully.');

		return \Redirect::to('admin/portfolio');

	}

	public function edit($slug, PortfolioRepository $projects) 
	{
		$project = $projects->project($slug);

		return \View::make('portfolio::edit')->with('project', $project);
	}

	public function postEdit($slug, PortfolioRepository $projects) 
	{
		$project = $projects->project($slug);

		if(! \Request::get('name')) {

			\Flash::error('Please provide a name.');

			return \Redirect::back()->withInput();

		}

		$name = \Request::get('name');
		$slug = \Str::slug($name);
		$description = \Request::get('description');

		$exists = $projects->project($slug);

		if($exists && $exists->id != $project->id) {

			\Flash::error('Project with that name already exists.');

			return \Redirect::back()->withInput();

		}

		$project->name = $name;
		$project->slug = $slug;
		$project->description = $description;	

		$project->save();	

		\Flash::success('Project edited successfully.');

		return \Redirect::to('admin/portfolio/'.$slug.'/edit');

	}

	public function delete($slug, PortfolioRepository $projects) 
	{
		$project = $projects->project($slug);

		return \View::make('portfolio::delete')->with('project', $project);
	}

	public function postDelete($slug, PortfolioRepository $projects) 
	{
		$project = $projects->project($slug);
		$project->delete();

		\Flash::success('Project deleted.');

		return \Redirect::to('admin/portfolio');
	}

	public function swap(PortfolioRepository $portfolio) 
	{

		$id1 = \Request::get('id1');
		$id2 = \Request::get('id2');

		$first = $portfolio->get($id1);
		$second = $portfolio->get($id2);

		$first->moveAfter($second);

		\Flash::success('Sorted.');

		return \Redirect::back();

	}


}