<?php namespace Kkstudio\Portfolio\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Http\Traits\Sortable as SortableTrait;

class Project extends Eloquent {

	use SortableTrait;

	protected $table = 'kkstudio_portfolio_projects';

	protected $guarded = [ 'id' ];

	public function category() {

		return $this->belongsTo('Kkstudio\Portfolio\Models\Category', 'category_id', 'id');

	}

	public function getThumb() {

		$path = public_path('assets/portfolio/thumb_' . $this->image);

		if(is_readable($path)) return asset('assets/portfolio/thumb_' . $this->image);

		return  asset('assets/portfolio/thumb_default.png');

	}

	public function getImage() {

		$path = public_path('assets/portfolio/' . $this->image);

		if(is_readable($path)) return asset('assets/portfolio/' . $this->image);

		return  asset('assets/portfolio/default.png');

	}

}