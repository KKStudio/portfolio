<?php namespace Kkstudio\Portfolio;

use Illuminate\Support\ServiceProvider;

class PortfolioServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('kkstudio/portfolio');

		\Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {

			\Route::get('portfolio', '\Kkstudio\Portfolio\Controllers\PortfolioController@admin');

			\Route::get('portfolio/create', '\Kkstudio\Portfolio\Controllers\PortfolioController@create');	
			\Route::post('portfolio/create', '\Kkstudio\Portfolio\Controllers\PortfolioController@postCreate');

			\Route::get('portfolio/{id}/edit', '\Kkstudio\Portfolio\Controllers\PortfolioController@edit');
			\Route::post('portfolio/{id}/edit', '\Kkstudio\Portfolio\Controllers\PortfolioController@postEdit');

			\Route::get('portfolio/{id}/delete', '\Kkstudio\Portfolio\Controllers\PortfolioController@delete');
			\Route::post('portfolio/{id}/delete', '\Kkstudio\Portfolio\Controllers\PortfolioController@postDelete');
			
			\Route::post('portfolio/swap', '\Kkstudio\Portfolio\Controllers\PortfolioController@swap');

		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
