<?php
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
	die('PHP ActiveRecord requires PHP 5.3 or higher');

define('PHP_ACTIVERECORD_VERSION_ID','1.0');

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_PREPEND'))
	define('PHP_ACTIVERECORD_AUTOLOAD_PREPEND',true);

require 'lib/Singleton.php';
require 'lib/Config.php';
require 'lib/Utils.php';
require 'lib/DateTime.php';
require 'lib/Model.php';
require 'lib/Errors.php';
require 'lib/Table.php';
require 'lib/ConnectionManager.php';
require 'lib/Connection.php';
require 'lib/SQLBuilder.php';
require 'lib/Reflections.php';
require 'lib/Inflector.php';
require 'lib/StandardInflector.php';
require 'lib/CallBack.php';
require 'lib/ActiveRecordException.php';
require 'lib/ConfigException.php';
require 'lib/DatabaseException.php';
require 'lib/ExpressionsException.php';
require 'lib/HasManyThroughAssociationException.php';
require 'lib/ModelException.php';
require 'lib/ReadOnlyException.php';
require 'lib/RecordNotFound.php';
require 'lib/RelationshipException.php';
require 'lib/UndefinedPropertyException.php';
require 'lib/ValidationsArgumentError.php';
require 'lib/Cache.php';
require 'lib/InterfaceRelationship.php';
require 'lib/AbstractRelationship.php';
require 'lib/HasAndBelongsToMany.php';
require 'lib/HasMany.php';
require 'lib/HasOne.php';
require 'lib/BelongsTo.php';

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
