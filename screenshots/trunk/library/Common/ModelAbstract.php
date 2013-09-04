<?php


/**
 * Abstract class representing a domain model.
 * 
 * This should not be aware of underlying database/adapter,
 * just of the mapper
 *
 */
class Common_ModelAbstract {
	protected $_mapper;
	protected $_mapperType;
	
	/**
	 * Constructor
	 * 
	 * @param array $options
	 */
	public function __construct(array $options = null)
	{
		$this->_mapper = Zend_Registry::get($this->_mapperType);
		
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
	
	/**
	 * Magic method setter
	 * 
	 * @param string $name
	 * @param string $value
	 * @throws Exception
	 */
	public function __set($name, $value) {
		$property = '_' . $name;
		if (!property_exists($this, $property)) {
			throw new Exception('Invalid property');
		} else {
			$method = 'set' . $name;
			if (method_exists($this, $method)) {
				$this->$method($value);
			} else {
				$this->$property = $value;
			}
		}
	}

	/**
	 * Magic method getter
	 * 
	 * @param string $name
	 * @throws Exception
	 */
	public function __get($name) {
		$property = '_' . $name;
		if (!property_exists($this, $property)) {
			throw new Exception('Invalid property');
		} else {
			$method = 'get' . $name;
			if (method_exists($this, $method)) {
				return $this->$method();
			} else {
				return $this->$property;
			}
		}
	}
	
	/**
	 * returns a field value formatted for use in a url
	 * 
	 * @param string $field
	 * @return string
	 */
	public function urlify($field) {
		$result = $this->$field;
		$result = strtolower($result);
		$result = preg_replace('/[^\w\d_ -]/si', '', $result);
		$result = preg_replace('/\s+/', '-', $result);
		return $result;
	}

	/**
	 * Initializes object properties
	 *
	 * @param  Array    $options  initial values
	 * @return 
	 */
	protected function setOptions(array $options) {
		foreach ($options as $key => $value) {
			if (!empty($value) && property_exists($this, "_" . $key))
				$this->$key = $value;
		}
	}
}