<?php namespace Cartalyst\Themes;
/**
 * Part of the Themes package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Themes
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Countable;
use ArrayAccess;
use ArrayIterator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\NamespacedItemResolver;
use Illuminate\View\Environment;
use IteratorAggregate;

class ThemeBag implements ArrayAccess, Countable, IteratorAggregate {

	/**
	 * Array of all registered themes.
	 *
	 * @var array
	 */
	protected $themes = array();

	/**
	 * The active registered theme instance.
	 *
	 * @var Cartalyst\Themes\ThemeInterface
	 */
	protected $active;

	/**
	 * The fallback registered theme instance.
	 *
	 * @var Cartalyst\Themes\ThemeInterface
	 */
	protected $fallback;

	/**
	 * Filesystem instance.
	 *
	 * @var Illuminate\Filesystem\Filesystem
	 */
	protected $filesystem;

	/**
	 * View environment instance.
	 *
	 * @var Illuminate\View\View
	 */
	protected $view;

	/**
	 * Array of theme paths.
	 *
	 * @var array
	 */
	protected $paths = array();

	/**
	 * The packages path, relative to the
	 * theme path.
	 *
	 * @var string
	 */
	public $packagesPath = 'packages';

	/**
	 * The namespaces path, relative to the
	 * theme path.
	 *
	 * @var string
	 */
	public $namespacesPath = 'namespaces';

	/**
	 * The views path, relative to the theme
	 * / section path.
	 *
	 * @var string
	 */
	public $viewsPath = 'views';

	/**
	 * The assets path, relative to the theme
	 * / section path.
	 *
	 * @var string
	 */
	public $assetsPath = 'assets';

	/**
	 * The name of the class used when creating theme
	 * instances.
	 *
	 * @var string
	 */
	protected $themeClass = 'Cartalyst\Themes\Theme';

	/**
	 * The folder depth for areas which hold themes.
	 *
	 * @var int
	 */
	protected $areaDepth = 1;

	/**
	 * The max folder depth for themes themselves within their
	 * respective areas. We set it to "2" to account for a
	 * "vendor/theme" structure. Feel free to set it at
	 * whatever you like, but all your themes must
	 * follow this scheme.
	 *
	 * It must be unified so that the theme publisher can find
	 * the various components to be published and push them to
	 * their respective areas within a theme (which may be
	 * configured to be different than the location the files
	 * are being published from [such as the "package path"]).
	 *
	 * @var int
	 */
	protected $maxThemeDepth = 2;

	/**
	 * Much the same as folder depth for themes, this is
	 * the max folder depth within each theme that a section
	 * may consume. A section is either a namespace or a
	 * package.
	 *
	 * @var int
	 */
	protected $maxSectionDepth = 2;

	/**
	 * Creates a new theme bag instance.
	 *
	 * @param  Illuminate\Filesystem\Filesystem  $filesystem
	 * @param  array  $paths
	 * @return void
	 */
	public function __construct(Filesystem $filesystem, array $paths)
	{
		$this->filesystem = $filesystem;
		$this->paths      = $paths;
	}

	/**
	 * Registers a theme with the them bag. You may
	 * provide either a theme instance, the slug of the
	 * theme or the theme's physical path as an argument.
	 *
	 * @param  $mixed  $theme
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function register($theme)
	{
		if ($theme instanceof ThemeInterface)
		{
			return $this->themes[$theme->getSlug()] = $theme;
		}

		if ( ! is_string($theme))
		{
			throw new \InvalidArgumentException('Attempting to register theme with ['.gettype($theme).'] argument.');
		}

		if (starts_with($theme, 'path: '))
		{
			return $this->registerAtPath(substr($theme, 6));
		}

		return $this->locateAndRegister($theme);
	}

	/**
	 * Registers a theme at the given path.
	 *
	 * @param  string  $path
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function registerAtPath($path)
	{
		$theme = $this->createTheme($path);
		return $this->register($theme);
	}

	/**
	 * Locates a theme by the given slug in the registered
	 * paths and registers it.
	 *
	 * @param  string  $slug
	 * @return Cartalyst\Themes\ThemeInterfacde
	 */
	public function locateAndRegister($slug)
	{
		$resolver = new NamespacedItemResolver;
		list($area, $key) = $resolver->parseKey($slug);

		foreach ($this->paths as $path)
		{
			$themePath = $this->getThemePath($path, $key, $area);

			if ($this->filesystem->isDirectory($themePath))
			{
				$theme = $this->createTheme($themePath);
				return $this->register($theme);
			}
		}

		throw new \RuntimeException("Could not resolve theme [$slug].");
	}

	/**
	 * Ensures a theme is registered.
	 *
	 * @param  mixed  $theme
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function ensureRegistered($theme)
	{
		if ($theme instanceof ThemeInterface)
		{
			if ( ! isset($this[$theme->getSlug()]))
			{
				return $this->register($theme);
			}

			return $theme;
		}

		if ( ! isset($this[$theme]))
		{
			return $this->register($theme);
		}

		return $this[$theme];
	}

	/**
	 * Make a view with the option to specify which theme you'd
	 * like to use.
	 *
	 * @param  string  $name
	 * @param  array   $data
	 * @param  mixed   $theme
	 * @return Illuminate\View\View
	 */
	public function view($name, $data = array(), $theme = null)
	{
		if ( ! isset($this->view))
		{
			throw new \RuntimeException("Cannot make view [$name] from theme bag as view environment has not been bound.");
		}

		if ( ! $theme)
		{
			return $this->view->make($name, $data);
		}

		$existingActive = $this->getActiveOrFail();
		$tempActive     = $this->ensureRegistered($theme);
		$this->setActive($tempActive);

		$view = $this->view->make($name, $data);
		$this->setActive($existingActive);

		return $view;
	}

	/**
	 * Returns the cascaded view paths for the active theme and all
	 * of it's parents right up to the fallback theme.
	 *
	 * @param  Cartalyst\Themes\ThemeInterface  $theme
	 * @return array
	 */
	public function getCascadedViewPaths($theme = null)
	{
		return $this->getCascadedPaths('getViewsPath', null, $theme);
	}

	/**
	 * Returns the cascaded view paths for a package in the active theme
	 * and all of it's parents right up to the fallback theme.
	 *
	 * @param  string  $package
	 * @param  Cartalyst\Themes\ThemeInterface  $theme
	 * @return array
	 */
	public function getCascadedPackageViewPaths($package, $theme = null)
	{
		return $this->getCascadedPaths('getPackageViewsPath', $package, $theme);
	}

	/**
	 * Returns the cascaded view paths for a namespace in the active theme
	 * and all of it's parents right up to the fallback theme.
	 *
	 * @param  string  $namespace
	 * @param  Cartalyst\Themes\ThemeInterface  $theme
	 * @return array
	 */
	public function getCascadedNamespaceViewPaths($namespace, $theme = null)
	{
		return $this->getCascadedPaths('getNamespaceViewsPath', $namespace, $theme);
	}

	/**
	 * Returns the cascaded asset paths for the active theme and all
	 * of it's parents right up to the fallback theme.
	 *
	 * @param  Cartalyst\Themes\ThemeInterface  $theme
	 * @return array
	 */
	public function getCascadedAssetPaths($theme = null)
	{
		return $this->getCascadedPaths('getAssetsPath', null, $theme);
	}

	/**
	 * Returns the cascaded asset paths for a package in the active theme
	 * and all of it's parents right up to the fallback theme.
	 *
	 * @param  string  $package
	 * @param  Cartalyst\Themes\ThemeInterface  $theme
	 * @return array
	 */
	public function getCascadedPackageAssetPaths($package, $theme = null)
	{
		return $this->getCascadedPaths('getPackageAssetsPath', $package, $theme);
	}

	/**
	 * Returns the cascaded asset paths for a namespace in the active theme
	 * and all of it's parents right up to the fallback theme.
	 *
	 * @param  string  $namespace
	 * @param  Cartalyst\Themes\ThemeInterface  $theme
	 * @return array
	 */
	public function getCascadedNamespaceAssetPaths($namespace, $theme = null)
	{
		return $this->getCascadedPaths('getNamespaceAssetsPath', $namespace, $theme);
	}

	/**
	 * Returns the active theme.
	 *
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function getActive()
	{
		return $this->active;
	}

	/**
	 * Returns the active theme if it exists. If
	 * it doesn't, an Exception will be thrown.
	 *
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function getActiveOrFail()
	{
		if ( ! $active = $this->getActive())
		{
			throw new \RuntimeException("No active theme has been set.");
		}

		return $active;
	}

	/**
	 * Sets the active theme.
	 *
	 * @param  mixed  $active
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function setActive($active)
	{
		$active = $this->ensureRegistered($active);

		if ( ! isset($this->themes[$active->getSlug()]))
		{
			$this->register($active);
		}

		$this->active = $active;
	}

	/**
	 * Returns the fallback theme.
	 *
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function getFallback()
	{
		return $this->fallback;
	}

	/**
	 * Sets the fallback theme.
	 *
	 * @param  mixed  $fallback
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function setFallback($fallback)
	{
		$fallback = $this->ensureRegistered($fallback);

		if ( ! isset($this->themes[$fallback->getSlug()]))
		{
			$this->register($fallback);
		}

		$this->fallback = $fallback;
	}

	/**
	 * Gets the default packages path relative to each theme.
	 *
	 * @return string
	 */
	public function getPackagesPath()
	{
		return $this->packagesPath;
	}

	/**
	 * Sets the default packages path relative to each theme.
	 *
	 * @param  string  $packagesPath
	 * @return void
	 */
	public function setPackagesPath($packagesPath)
	{
		$this->packagesPath = $packagesPath;
	}

	/**
	 * Gets the default namespaces path relative to each theme.
	 *
	 * @return string
	 */
	public function getNamespacesPath()
	{
		return $this->namespacesPath;
	}

	/**
	 * Sets the default namespaces path relative to each theme.
	 *
	 * @param  string  $packagesPath
	 * @return void
	 */
	public function setNamespacesPath($namespacesPath)
	{
		$this->namespacesPath = $namespacesPath;
	}

	/**
	 * Gets the default views path relative to each theme / section.
	 *
	 * @return string
	 */
	public function getViewsPath()
	{
		return $this->viewsPath;
	}

	/**
	 * Sets the default views path relative to each theme / section.
	 *
	 * @param  string  $packagesPath
	 * @return void
	 */
	public function setViewsPath($viewsPath)
	{
		$this->viewsPath = $viewsPath;
	}

	/**
	 * Gets the default assets path relative to each theme / section.
	 *
	 * @return string
	 */
	public function getAssetsPath()
	{
		return $this->assetsPath;
	}

	/**
	 * Sets the default assets path relative to each theme / section.
	 *
	 * @param  string  $packagesPath
	 * @return void
	 */
	public function setAssetsPath($assetsPath)
	{
		$this->assetsPath = $assetsPath;
	}

	/**
	 * Sets the theme class.
	 *
	 * @param  string  $themeClass
	 * @return void
	 */
	public function setThemeClass($themeClass)
	{
		$this->themeClass = $themeClass;
	}

	/**
	 * Get an iterator for the items.
	 *
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->themes);
	}

	/**
	 * Count the number of items in the collection.
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->themes);
	}

	/**
	 * Determine if an item exists at an offset.
	 *
	 * @param  mixed  $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->themes);
	}

	/**
	 * Get an item at a given offset.
	 *
	 * @param  mixed  $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->themes[$key];
	}

	/**
	 * Set the item at a given offset.
	 *
	 * @param  mixed  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		$this->register($value);
	}

	/**
	 * Unset the item at a given offset.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function offsetUnset($key)
	{
		unset($this->themes[$key]);
	}

	/**
	 * Creates a new theme class instance.
	 *
	 * @return Cartalyst\Themes\ThemeInterface
	 */
	public function createTheme($path)
	{
		$class = '\\'.ltrim($this->themeClass, '\\');

		return new $class($this, $path);
	}

	/**
	 * Get the folder depth for areas.
	 *
	 * @return int
	 */
	public function getAreaDepth()
	{
		return $this->areaDepth;
	}

	/**
	 * Set the folder depth for areas.
	 *
	 * @param  int  $areaDepth
	 * @return void
	 */
	public function setAreaDepth($areaDepth)
	{
		$this->areaDepth = $areaDepth;
	}

	/**
	 * Get the max folder depth for themes.
	 *
	 * @return int
	 */
	public function getMaxThemeDepth()
	{
		return $this->maxThemeDepth;
	}

	/**
	 * Set the max folder depth for themes.
	 *
	 * @param  int  $maxThemeDepth
	 * @return void
	 */
	public function setMaxThemeDepth($maxThemeDepth)
	{
		$this->maxThemeDepth = $maxThemeDepth;
	}

	/**
	 * Get the max folder depth for sections.
	 *
	 * @return int
	 */
	public function getMaxSectionDepth()
	{
		return $this->maxSectionDepth;
	}

	/**
	 * Set the max folder depth for sections.
	 *
	 * @param  int  $maxSectionDepth
	 * @return void
	 */
	public function setMaxSectionDepth($maxSectionDepth)
	{
		$this->maxSectionDepth = $maxSectionDepth;
	}

	/**
	 * Get the view environment.
	 *
	 * @return Illuminate\View\Environment
	 */
	public function getViewEnvironment()
	{
		return $this->view;
	}

	/**
	 * Set the view environment.
	 *
	 * @param  Illuminate\View\Environment  $view
	 * @return void
	 */
	public function setViewEnvironment(Environment $view)
	{
		$this->view = $view;
	}

	/**
	 * Get the filesystem associated with the theme bag.
	 *
	 * @return Illuminate\Filesystem\Filesystem
	 */
	public function getFilesystem()
	{
		return $this->filesystem;
	}

	/**
	 * Return the theme paths.
	 *
	 * @return array
	 */
	public function getPaths()
	{
		return $this->paths;
	}

	/**
	 * Gets cascaded paths by calling a method on the
	 * active theme, it's parents and the fallback theme.
	 *
	 * @param  string  $method
	 * @param  string  $argument
	 * @return array   $paths
	 */
	protected function getCascadedPaths($method, $argument = null, $theme = null)
	{
		$paths  = array();
		$looped = array();

		if ($theme === null)
		{
			$current = $active = $this->getActiveOrFail();
		}
		else
		{
			$current = $this->ensureRegistered($theme);
		}

		while (true)
		{
			// Add the current "views path" to the array
			// of paths
			$paths[]  = $current->$method($argument);
			$looped[] = $current;

			// If there is no parent theme, we will break our loop
			if ( ! $parentSlug = $current->getParentSlug()) break;

			// If the parent slug exists and we haven't registered
			// the theme, we will automatically register it now.
			if ( ! isset($this[$parentSlug])) $this->register($parentSlug);

			// If the parent is the fallback theme, break our loop
			// as we'll add it's path on at the end.
			if (($parent = $this[$parentSlug]) === $this->getFallback()) break;

			// Assign the current theme to the parent
			$current  = $parent;
		}

		// If we have a fallback theme and we haven't looped through it (i.e.,
		// it is not the direct parent of any theme or is it the theme the
		// cascaded paths were requested for) we will append it's path to the
		// array of paths.
		if ($fallback = $this->getFallback() and ! in_array($fallback, $looped))
		{
			$paths[] = $fallback->$method($argument);
		}

		return $paths;
	}

	/**
	 * Returns the theme path for a theme with
	 * the given key and area in the base path provided.
	 *
	 * @param  string  $path
	 * @param  string  $key
	 * @param  string  $area
	 * @return string
	 */
	protected function getThemePath($path, $key, $area = null)
	{
		$split = '/(\/|\\\)/';

		if (($keyCount = count(preg_split($split, $key))) > $this->maxThemeDepth)
		{
			throw new \RuntimeException("Theme had folder depth of [$keyCount] however it must be less than or equal to [{$this->maxThemeDepth}].");
		}

		if (isset($area))
		{
			if (($areaCount = count(preg_split($split, $area))) != $this->areaDepth)
			{
				throw new \RuntimeException("Theme area had folder depth of [$areaCount] however it must match [{$this->areaDepth}].");
			}

			return "$path/$area/$key";
		}

		return "$path/$key";
	}

}
