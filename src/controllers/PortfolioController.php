<?php namespace Kkstudio\Portfolio\Controllers;

use Illuminate\Routing\Controller;
use Kkstudio\Portfolio\Models\Portfolio;
use Kkstudio\Portfolio\Repositories\PortfolioRepository;

class PortfolioController extends Controller {

	protected $repo;

	public function __construct(PortfolioRepository $repo)
	{
		$this->repo = $repo;
	}

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

	public function admin() {

		$projects = $this->repo->all();

		return \View::make('portfolio::admin')->with('portfolio', $projects);

	}

	public function create() 
	{
		return \View::make('portfolio::create');
	}

	public function postCreate() 
	{
		if(! \Request::get('name')) {

			\Flash::error('Podaj nazwę projektu.');

			return \Redirect::back()->withInput();

		}

		$name = \Request::get('name');
		$slug = \Str::slug($name);
		$description = \Request::get('description');
		$image = '';

		$exists = $this->repo->project($slug);

		if($exists) {

			\Flash::error('Projekt o tej nazwie już istnieje.');

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

		$lp = $this->repo->max() + 1;

		$project = $this->repo->create($slug, $name, $description, $image, $lp);

		\Flash::success('Pomyślnie stworzono projekt.');

		return \Redirect::to('admin/portfolio');

	}

	public function edit($slug) 
	{
		$project = $this->repo->project($slug);

		return \View::make('portfolio::edit')->with('project', $project);
	}

	public function postEdit($slug) 
	{
		$project = $this->repo->project($slug);

		if(! \Request::get('name')) {

			\Flash::error('Musisz podać nazwę projektu.');

			return \Redirect::back()->withInput();

		}

		$name = \Request::get('name');
		$slug = \Str::slug($name);
		$description = \Request::get('description');

		$exists = $this->repo->project($slug);

		if($exists && $exists->id != $project->id) {

			\Flash::error('Projekt o tej nazwie już istnieje.');

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

		\Flash::success('Pomyślnie edytowano projekt.');

		return \Redirect::to('admin/portfolio/'.$slug.'/edit');

	}

	public function delete($slug) 
	{
		$project = $this->repo->project($slug);

		return \View::make('portfolio::delete')->with('project', $project);
	}

	public function postDelete($slug) 
	{
		$project = $this->repo->project($slug);
		$project->delete();

		\Flash::success('Projektu usunięty.');

		return \Redirect::to('admin/portfolio');
	}

	public function swap() 
	{

		$id1 = \Request::get('id1');
		$id2 = \Request::get('id2');

		$first = $portfolio->projectById($id1);
		$second = $portfolio->projectById($id2);

		$first->moveAfter($second);

		\Flash::success('Posortowano.');

		return \Redirect::back();

	}


}