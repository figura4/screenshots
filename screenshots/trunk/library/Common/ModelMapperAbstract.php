<?php

/**
 * Abstract class representing a domain model mapper.
 * 
 * Encasulates db/adapter-specific logic
 *
 */
abstract class Common_ModelMapperAbstract {
	protected $_dbTable;
	protected $_dbTableType;	
	protected $_MappedModelType;
	
	function __construct() {}
	
	/**
	 * Returns the underlying zend db table.
	 * It creates the object the first time the method is called.
	 * 
	 * @throws Exception
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable() {
		if (null === $this->_dbTable) {
			$dbTable = new $this->_dbTableType;
			if (!$dbTable instanceof Zend_Db_Table_Abstract) {
				throw new Exception('Invalid table data gateway provided');
			}
			$this->_dbTable = $dbTable;
		}
		return $this->_dbTable;
	}
	
	/**
	 * Saves the received fields in the underlying table
	 * 
	 * @param array() $data
	 * @return integer $id
	 */
	protected function saveToDb($data) {
		if (empty($data['id'])) {
			unset($data['id']);
		}
		if (key_exists('id', $data)) {
			$id = $data['id'];
			if (key_exists('createdOn', $data)) {
				unset($data['createdOn']);
			}
			
			$this->getDbTable()->update($data, array('id = ?' => $id));
		} else {
			$id = $this->getDbTable()->insert($data);
		}
		return $id;
	}
	
	/**
	 * Deletes the row identified by $id
	 * 
	 * @param int $id
	 */
	public function delete($id) {
		$this->getDbTable()->delete('id = ' . $id);
	}
	
	/**
	 * finds the  row in the db identified by $id
	 * 
	 * @param int $id
	 * @return ModelInterface
	 */
	public function find($id) {
		$model = $this->getDbTable()->find($id)->current();
		if (is_object($model))
			return new $this->_MappedModelType($model->toArray());
		else
			return NULL;
	}
	
	/**
	 * Retrieves all database rows matching the serach criteria.
	 * Returns an array of objects or a paginator
	 * 
	 * @param array $filters
	 * @param int $order
	 * @param string $limit
	 * @param bool $paginated
	 * @param int $itemsPerPage
	 * @return Zend_Paginator|array of modelInterface
	 */
	public function fetchAll($filters = array(), $order = null, $limit = null, $paginated = false, $itemsPerPage = 7) {
		$resultSet = array();
		$select = $this->getDbTable()->select();
	
		if(count($filters) > 0) {
			foreach ($filters as $field => $filter) {
				if ($field == 'pubDate') {
					$select->where($field . ' <= NOW()');
				} else {
					$select->where($field . ' = ?', $filter);
				}
			}
		}
	
		if(null != $order) {
			$select->order($order);
		}

		if(null != $limit) {
			$select->limit($limit, 0);
		}
		
		$rowSet = $this->getDbTable()->fetchAll($select);

		foreach ($rowSet as $row) {
			$resultSet[] = new $this->_MappedModelType($row->toArray());
		}

		if ($paginated) {
			$adapter = new Zend_Paginator_Adapter_Array($resultSet);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($itemsPerPage);
			return $paginator;
		} else {
			return $resultSet;
		}
	}
}