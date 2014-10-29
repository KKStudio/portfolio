<?php namespace Kkstudio\Portfolio;

class Portfolio extends \App\Module {

	private $repo;

	public function __construct() 
	{
		$this->repo = new Repositories\PortfolioRepository;
	}

	public function projects() {

		$projects = $this->repo->all();

		return $projects;

	}

	public function categories() {

		$categories = $this->repo->categories();

		return $categories;

	}

	public function project($slug) {

		$project = $this->repo->project($slug);

		return $project;
	}
	
}