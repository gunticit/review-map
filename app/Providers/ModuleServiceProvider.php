<?php
 
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
 
class ModuleServiceProvider extends ServiceProvider{
  /**
     * registerModules
     *
     * @return void
     */
    public function boot()
    { 
       foreach ($this->getModules() as $module) {
            if (!$module) continue;
            $this->registerModuleMigrations($module);
            $this->mapModuleRoutes($module);
            $this->defineNamespaceModuleViews($module);
            $this->mergerConfig($module);
            $this->registerModuleHelpers($module);
        }
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
    
    protected function module_path($path) {
        $modulePath = app_path() .'/Modules/'. DIRECTORY_SEPARATOR. $path;
        return $modulePath; 
    }
 
    /**
     * @return array
     */
    public function getModules(): array
    {
        return array_map('basename', File::directories(__DIR__. '/../Modules/'));
    }
    
    /**
     * Register paths to be published by the publish command.
     *
     * @param string $module
     * @return void
     */
    protected function registerModuleMigrations(string $module): void
    {
        $this->loadMigrationsFrom($this->module_path($module . DIRECTORY_SEPARATOR . 'Migrations'));
    }
    
        /**
     * Define the "module" routes for the application.
     *
     * @param string $module
     * @return void
     */
    protected function mapModuleRoutes(string $module): void
    {        
        $namespace = str_replace('/', '\\', $module);
        $routerWebPath = $this->module_path($module . DIRECTORY_SEPARATOR . 'Routers/web.php');
        if (file_exists($routerWebPath)) {
            $this->mapWebRoutes($namespace, $routerWebPath);
        }
    }
 
    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *  @param $namespace
     * @param  $path
     * @return void
     */
    protected function mapWebRoutes($namespace, $path)
    {
        Route::middleware('web')
            ->namespace("App\Modules\\{$namespace}\\Controllers")
            ->group($path);
    }
 
    /**
     * Define namespace the "module" views for the application.
     *
     * @param string $module
     * @return void
     */
    protected function defineNamespaceModuleViews(string $module): void
    {
        $this->loadViewsFrom($this->module_path($module . DIRECTORY_SEPARATOR . 'Views'), $module);
    }
    
    protected function mergerConfig(string $module): void
    {
        $path = $this->module_path($module . DIRECTORY_SEPARATOR . 'Config/constants.php');
        if(file_exists($path)){
            $this->mergeConfigFrom($path,'constants');
        }
    }
 
    protected function registerModuleHelpers(string $module): void
    {
        foreach (glob($this->module_path($module . DIRECTORY_SEPARATOR . 'Helpers/*.php')) as $filename){
            require_once($filename);
        }
    }
}