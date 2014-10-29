<?php namespace Kkstudio\Portfolio\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Http\Traits\Sortable as SortableTrait;

class Project extends Eloquent {

	use SortableTrait;

	protected $table = 'kkstudio_portfolio_projects';

	protected $guarded = [ 'id' ];

	public function category() {

		return $this->belongsTo('Kkstudio\Portfolio\Category', 'category_id', 'id');

	}

}