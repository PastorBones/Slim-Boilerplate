<?php

namespace Vendors;

class Autoloader {

	private static $_includePath;
	private static $_namespace;
	private static $_namespaceSeparator = '\\';
	private static $_fileExtension = '.php';

	/**
	 * Sets the base include path for all class files in the namespace of this class loader.
	 *
	 * @param string $includePath
	 */
	public static function setIncludePath($includePath) {
		self::$_includePath = rtrim($includePath, DIRECTORY_SEPARATOR);
	}

	/**
	 * Register's the autoloader to the SPL autoload stack.
	 *
	 * @return	void
	 */
	public static function register() {
		spl_autoload_register('self::load', true, true);
	}

	/**
	 * Loads a class.
	 *
	 * @param   string  $class  Class to load
	 * @return  bool    If it loaded the class
	 */
	public static function load($className) {
		if (null === self::$_namespace || self::$_namespace . self::$_namespaceSeparator === substr($className, 0, strlen(self::$_namespace . self::$_namespaceSeparator))) {
			$fileName = '';
			$namespace = '';
			if (false !== ($lastNsPos = strripos($className, self::$_namespaceSeparator))) {
				$namespace = substr($className, 0, $lastNsPos);
				$className = substr($className, $lastNsPos + 1);
				$fileName = str_replace(self::$_namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
			}
			$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . self::$_fileExtension;

			require (self::$_includePath !== null ? self::$_includePath . DIRECTORY_SEPARATOR : '') . $fileName;
		}
	}

}