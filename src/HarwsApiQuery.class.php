<?php
/**
 * Base Clase to implement REST Api Calls
 * @author agusquiroga@webq.com.ar
 * @since 05/04/2013
 */
class HarwsApiQuery
{

	/**
	 * Sets debug level
	 * @var boolean
	 */
	protected $debug = false;

	/**
	 * Endpoint URL of the REST server
	 * @var string
	 */
	protected $service_url = null;

	/**
	 * API Key to authenticate the request
	 * @var string
	 */
	protected $api_key = null;

	/**
	 * Sets debug level
	 * @param boolean $flag
	 */
	public function setDebug($flag = false)
	{
		$this->debug = $flag;
	}

	/**
	 * Sets Endpoint URL of the REST server
	 * @param string $url
	 */
	public function setServiceUrl($url)
	{
		if ((substr($url, 1) == '/')) $url = substr($url, 0, -1);
		$this->service_url = $url;
	}

	/**
	 * Gets the present Service URL
	 * @return string
	 */
	public function getServiceUrl()
	{
		return $this->service_url;
	}


	/**
	 * Sets the API key to use in the requests
	 * @param string $key api key
	 * @return null
	 */
	public function setApiKey($key)
	{
		$this->api_key = $key;
	}

	/**
	 * Gets the present API key
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->api_key;
	}

	/**
	 * Constructor
	 * @param string $api_key
	 * @param string $service_url
	 */
	public function __construct($api_key = null, $service_url = null)
	{
		if ($api_key !== null) $this->setApiKey($api_key);
		if ($service_url !== null) $this->setServiceUrl($service_url);
	}

	/**
	 * Query the API
	 * @param string $method method to be called
	 * @param array $params params to be sended to the api method
	 * @return array
	 */
	public function call($method, $params = null)
	{
		if ($this->getServiceUrl() == null)
		{
			throw new Exception('No Service URL endpoint set',__LINE__);
		}
		if ($this->getApiKey() == null)
		{
			throw new Exception('No API key set',__LINE__);
		}
		// default params to be sent
		$_params = array(
				'api_key' => $this->getApiKey()
		);
		if ($params)
		{
			$_params = array_merge($params, $_params);
		}
		if ((substr($method, 0, 1) != '/')) $method = '/'.$method;
		$url = $this->getServiceUrl().$method.((count($_params) > 0) ? '?'.http_build_query($_params) : '');
		$this->log('Calling: '.$url);
		$defaults = array(
				CURLOPT_URL => $url,
				CURLOPT_HEADER => 0,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_TIMEOUT => 10,
				CURLOPT_CONNECTTIMEOUT => 10,
				CURLOPT_SSL_VERIFYPEER => FALSE,
				CURLOPT_SSL_VERIFYHOST => 0,
		);

		$ch = curl_init();
		curl_setopt_array($ch, $defaults);
		if( ! $result = curl_exec($ch))
		{
			$result = curl_error($ch);
		}
		curl_close($ch);
		$this->log('RAW Response: '.var_export($result, true));
		$response = json_decode($result, true);
		if (!is_array($response))
		{
			throw new Exception('Error on response, invalid response received: "'.$response.'"', __LINE__);
		} else {
			if (isset($response['error']))
			{
				$error = isset($response['error']['info']) ? $response['error']['info'] : 'Error no especificado: '.$result;
				$code = isset($response['error']['code']) ? $response['error']['code'] : __LINE__;
				throw new Exception($error, $error_code);
			} else {
				return $response;
			}
		}
		return null;
	}

	/**
	 * Logs a API event
	 * @param string $msg
	 */
	protected function log($msg)
	{
		if ($this->debug)
		{
			echo $msg."\n";
		}
	}

}

/**
 * Represents a pager from a result from the API
 * @author Agusquiroga
 */
class HarwsApiQueryPager
{
	/**
	 * Array containing the preset page
	 * @var array
	 */
	protected $records = array();

	/**
	 * Records included in this page
	 * @var int
	 */
	protected $record_count = 0;

	/**
	 * Total Record Count available in the API
	 * @var int
	 */
	protected $total_record_count = 0;

	/**
	 * Page retrieved from the API
	 * @var int
	 */
	protected $page = 0;

	/**
	 * Total pages found in the API
	 * @var int
	 */
	protected $total_page = 0;

	/**
	 * Indicates the current cursor position
	 * @var int
	 */
	private $cursor_position = -1;

	/**
	 * Sets the object from a response
	 * @param array $api_response
	 */
	public function __construct(array $api_response)
	{
		$this->populate($api_response);
	}

	/**
	 * Populates the object from a API response Array
	 * @param array $response
	 */
	protected function populate(array $response)
	{
		if (isset($response['records']))
		{
			$this->setRecords($response['records']);
			$this->setCurrentPage($response['page']);
			$this->setRecordCount($response['record_count']);
			$this->setTotalPages($response['total_pages']);
			$this->setTotalRecordCount($response['total_record_count']);
		} else {
			throw new Exception('No records received in the result given to the pager', __LINE__);
		}
		if (isset($response['page']))
		{
			$this->setCurrentPage($response['page']);
		} else {
			throw new Exception('No page received in the result given to the pager', __LINE__);
		}
		if (isset($response['record_count']))
		{
			$this->setRecordCount($response['record_count']);
		} else {
			throw new Exception('No record_count received in the result given to the pager', __LINE__);
		}
		if (isset($response['total_pages']))
		{
			$this->setTotalPages($response['total_pages']);
		} else {
			throw new Exception('No total_pages received in the result given to the pager', __LINE__);
		}
		if (isset($response['total_record_count']))
		{
			$this->setTotalRecordCount($response['total_record_count']);
		} else {
			throw new Exception('No total_record_count received in the result given to the pager', __LINE__);
		}
	}

	/**
	 * Sets the records used in the page
	 * @param array $records
	 */
	protected function setRecords(array $records)
	{
		$this->records = $records;
	}

	/**
	 * Sets the present page number
	 * @param int $page
	 */
	protected function setCurrentPage($page)
	{
		$this->page = (int) $page;
	}

	/**
	 * Gets the current page number
	 * @return int
	 */
	public function getCurrentPage()
	{
		return $this->page;
	}

	/**
	 * Sets the total pages available
	 * @param int $pages
	 */
	protected function setTotalPages($pages)
	{
		$this->total_page = (int) $pages;
	}

	/**
	 * Gets the total pages available
	 * @return int
	 */
	public function getTotalPages()
	{
		return $this->total_page;
	}

	/**
	 * Sets the record count in the page
	 * @param int $count
	 */
	protected function setRecordCount($count)
	{
		$this->record_count = (int) $count;
	}

	/**
	 * Gets the record count in the page
	 * @return int
	 */
	public function getRecordCount()
	{
		return $this->record_count;
	}

	/**
	 * Gets the presetn cursor position
	 * @return number
	 */
	public function getCursorPosition()
	{
		return $this->cursor_position;
	}

	/**
	 * Move the cursor in one direction
	 * @param int $positions
	 */
	protected function moveCursor($positions)
	{
		$this->cursor_position = $this->cursor_position + (int) $positions;
	}

	/**
	 * Sets the total record count in the api
	 * @param int $count
	 */
	protected function setTotalRecordCount($count)
	{
		$this->total_record_count = (int) $count;
	}

	/**
	 * Gets the total record count in the api
	 * @return int
	 */
	public function getTotalRecordCount()
	{
		return $this->total_record_count;
	}

	/**
	 * Retrieves the next record in the pager or FALSE if none
	 * @return Ambigous <null, array>
	 */
	public function getNext()
	{
		$return = null;
		if ($this->hasNext())
		{
			$this->moveCursor(1);
			$return = $this->records[$this->getCursorPosition()];
		} else {
			$return = false;
		}
		return $return;
	}

	/**
	 * Checks if there´s a next record in the pager
	 * @return boolean
	 */
	public function hasNext()
	{
		return isset($this->records[$this->getCursorPosition() + 1]);
	}

	/**
	 * Checks if there´s a previous record in the pager
	 * @return boolean
	 */
	public function hasPrev()
	{
		return isset($this->records[$this->getCursorPosition() + 1]);
	}

	/**
	 * Gets the next page number or false if none
	 * @return Ambigous <null, array>
	 */
	public function getNextPage()
	{
		$next_page = $this->getCurrentPage() + 1;
		return $next_page > 0 && $next_page <= $this->getTotalPages() ? $next_page : false;
	}

	/**
	 * Gets the prev page number or false if none
	 * @return Ambigous <null, array>
	 */
	public function getPrevPage()
	{
		$prev_page = $this->getCurrentPage() - 1;
		return $prev_page > 0 && $prev_page < $this->getTotalPages() ? $prev_page : false;
	}

	/**
	 * Checks if there´s a next page in the API
	 * @return boolean
	 */
	public function hasNextPage()
	{
		return (bool) $this->getNextPage();
	}

	/**
	 * Checks if there´s a previous page in the API
	 * @return boolean
	 */
	public function hasPrevPage()
	{
		return (bool) $this->getPrevPage();
	}
}