<?phpclass User_Model_Mapper_User{	private $_dbTable;	private $_cache;		public function __construct()	{		$this->_cache  = Zend_Controller_Front::getInstance()								->getParam('bootstrap')								->getResource('cachemanager')								->getCache('frontcore');										$this->_dbTable = new User_Model_DbTable_User();	}		public function find( $id, User_Model_User $user )	{		$rowSet = $this->_dbTable->find( $id );		$row  	= $rowSet->current();		$user->populate( $row );	}		public function fetchAll()	{		$cacheId = 'User_fetchAll';		if( !$rowSet = $this->_cache->load( $cacheId ) ){				$rowSet = $this->_dbTable->fetchAll();			$this->_cache->save($rowSet);		}				$users  = array();		foreach( $rowSet  as $row ){			$user = new User_Model_User( $row );			$users[] = $user;		}		return $users;	}		public function delete( $id )	{						$where = 'id = ' . $id;		if( $this->_dbTable->delete( $where ) ){			$this->_cache->remove('User_fetchAll');			return true;		}		return false;	}		public function save( User_Model_User $user )	{						if( (int) $user->getId() !== 0 ){			$data['nom'] 		= $user->getNom();			$data['prenom'] 	= $user->getPrenom();			$data['email'] 		= $user->getEmail();			$data['telephone'] 	= $user->getTelephone();			$data['civilite'] 	= $user->getCivilite();			$this->_dbTable->update( $data, 'id = ' . $user->getId() );			$this->_cache->remove('User_fetchAll');			return $user->getId();		} else {			// insert			$data['login']    	= $user->getLogin();			$data['password'] 	= $user->getPassword();			$data['nom'] 		= $user->getNom();			$data['prenom'] 	= $user->getPrenom();			$data['email'] 		= $user->getEmail();			$data['telephone'] 	= $user->getTelephone();			$data['civilite'] 	= $user->getCivilite();			$id = $this->_dbTable->insert( $data );			if( $id  ){				$this->_cache->remove('User_fetchAll');				return $id;			}		}		return false;	}	}