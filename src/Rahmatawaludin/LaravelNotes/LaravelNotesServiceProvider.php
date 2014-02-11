<?php namespace Rahmatawaludin\LaravelNotes;

use Illuminate\Support\ServiceProvider;

class LaravelNotesServiceProvider extends ServiceProvider {

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
		$this->package('rahmatawaludin/laravel-notes');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['notes'] = $this->app->share(function($app)
	    {
	      return new Commands\NotesCommand($app);
	    });

	    $this->commands(
      		'notes'
      	);
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
