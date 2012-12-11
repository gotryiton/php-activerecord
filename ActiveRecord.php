<?php
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
	die('PHP ActiveRecord requires PHP 5.3 or higher');

define('PHP_ACTIVERECORD_VERSION_ID','1.0');

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_PREPEND'))
	define('PHP_ACTIVERECORD_AUTOLOAD_PREPEND',true);

require 'lib/ActiveRecord/Singleton.php';
require 'lib/ActiveRecord/Config.php';
require 'lib/ActiveRecord/Utils.php';
require 'lib/ActiveRecord/DateTime.php';
require 'lib/ActiveRecord/Model.php';
require 'lib/ActiveRecord/Errors.php';
require 'lib/ActiveRecord/Table.php';
require 'lib/ActiveRecord/Column.php';
require 'lib/ActiveRecord/ConnectionManager.php';
require 'lib/ActiveRecord/Connection.php';
require 'lib/ActiveRecord/SQLBuilder.php';
require 'lib/ActiveRecord/Reflections.php';
require 'lib/ActiveRecord/Inflector.php';
require 'lib/ActiveRecord/StandardInflector.php';
require 'lib/ActiveRecord/CallBack.php';
require 'lib/ActiveRecord/ActiveRecordException.php';
require 'lib/ActiveRecord/ConfigException.php';
require 'lib/ActiveRecord/DatabaseException.php';
require 'lib/ActiveRecord/ExpressionsException.php';
require 'lib/ActiveRecord/HasManyThroughAssociationException.php';
require 'lib/ActiveRecord/ModelException.php';
require 'lib/ActiveRecord/ReadOnlyException.php';
require 'lib/ActiveRecord/RecordNotFound.php';
require 'lib/ActiveRecord/RelationshipException.php';
require 'lib/ActiveRecord/UndefinedPropertyException.php';
require 'lib/ActiveRecord/ValidationsArgumentError.php';
require 'lib/ActiveRecord/Cache.php';
require 'lib/ActiveRecord/InterfaceRelationship.php';
require 'lib/ActiveRecord/AbstractRelationship.php';
require 'lib/ActiveRecord/HasAndBelongsToMany.php';
require 'lib/ActiveRecord/HasMany.php';
require 'lib/ActiveRecord/HasOne.php';
require 'lib/ActiveRecord/BelongsTo.php';

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_DISABLE'))
	spl_autoload_register('activerecord_autoload',false,PHP_ACTIVERECORD_AUTOLOAD_PREPEND);

function activerecord_autoload($class_name)
{
	$path = ActiveRecord\Config::instance()->get_model_directory();
	$root = realpath(isset($path) ? $path : '.');

	if (($namespaces = ActiveRecord\get_namespaces($class_name)))
	{
		$class_name = array_pop($namespaces);
		$directories = array();

		foreach ($namespaces as $directory)
			$directories[] = $directory;

		$root .= DIRECTORY_SEPARATOR . implode($directories, DIRECTORY_SEPARATOR);
	}

	$file = "$root/$class_name.php";

	if (file_exists($file))
		require $file;
}
?>
