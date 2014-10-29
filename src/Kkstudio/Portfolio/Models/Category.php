<?php namespace Kkstudio\Portfolio\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Http\Traits\Sortable as SortableTrait;

class Category extends Eloquent {

	use SortableTrait;

	protected $table = 'kkstudio_portfolio_categories';

	protected $guarded = [ 'id' ];

	public function projects() {

		return $this->hasMany('Kkstudio\Portfolio\Project', 'category_id', 'id');

	}

}