<?php namespace Kkstudio\Portfolio\Controllers;

use Illuminate\Routing\Controller;
use Kkstudio\Portfolio\Models\Portfolio;
use Kkstudio\Portfolio\Repositories\PortfolioRepository;

class PortfolioController extends Controller {

	public function index()
	{
		$projects = m('Portfolio')->projects();

		return v('portfolio.index', [ 'projects' => $projects ]);
	}

	public function show($slug)
	{
		$project = m('Portfolio')->project($slug);

		return v('portfolio.show', [ 'project' => $project ]);
	}

	// Admin

	public function admin(PortfolioRepository $repo) {

		$projects = $repo->all();

		return \View::make('portfolio::admin')->with('portfolio', $projects);

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

		$exists = $projects->project($slug);

		if($exists) {

			\Flash::error('Project with that name already exists.');

			return \Redirect::back()->withInput();

		}

		if(\Input::hasFile('image')) {

			$image_name = \Str::random(32) . \Str::random(32) . '.png';
			$image = \Image::make(\Input::file('image')->getRealPath());

            $image->save(public_path('assets/portfolio/' . $image_name));

            $callback = function ($constraint) { $constraint->upsize(); };
			$image->widen(320, $callback)->heighten(180, $callback);

            $image->save(public_path('assets/portfolio/thumb_' . $image_name));

            $image = $image_name;

		}

		$lp = $projects->max() + 1;

		$project = $projects->create($slug, $name, $description, $image, $lp);

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

		if(\Input::hasFile('image')) {

			$image_name = \Str::random(32) . \Str::random(32) . '.png';
			$image = \Image::make(\Input::file('image')->getRealPath());

            $image->save(public_path('assets/portfolio/' . $image_name));

            $callback = function ($constraint) { $constraint->upsize(); };
			$image->widen(320, $callback)->heighten(180, $callback);

            $image->save(public_path('assets/portfolio/thumb_' . $image_name));

            $project->image = $image_name;

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

		$first = $portfolio->projectById($id1);
		$second = $portfolio->projectById($id2);

		$first->moveAfter($second);

		\Flash::success('Sorted.');

		return \Redirect::back();

	}


}