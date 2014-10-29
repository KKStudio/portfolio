<?php namespace Kkstudio\Portfolio\Repositories;

use Kkstudio\Portfolio\Models\Project as Project;
use Kkstudio\Portfolio\Models\Category as Category;

class PortfolioRepository {

	public function projectById($id) {

		return Project::findOrFail($id);
		
	}

	public function project($slug) {

		return Project::where('slug', $slug)->first();
		
	}

	public function all() {

		return Project::orderBy('position')->get();

	}

	public function fromCategory($id) {

		return Project::orderBy('position')->where('category_id', $id)->get();

	}

	public function category($slug) {

		return Category::where('slug', $slug)->with('projects')->first();

	}

	public function categories() {

		return Category::orderBy('position')->get();
	}

	public function create($slug, $name, $description, $image) {

		return Project::create([

			'slug' => $slug,
			'name' => $name,
			'description' => $description,
			'image' => $image

		]);

	}

}