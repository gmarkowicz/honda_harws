<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Limited implementation of the REST api class
 * @author Agusquiroga
 */
class MY_REST_Controller extends CI_Controller {

    private $api_key;
    private $_admin_id;
    /**
     * Array que contiene todos los ID de sucursales que el usuario puede ver
     * @var unknown
     */
    public  $_sucursal_id;
    private $_group_api = 52;

    protected $rest_format = NULL; // Set this in a controller to use a default format
    protected $methods = array(); // contains a list of method properties such as limit, log and level
    protected $request = NULL; // Stores accept, language, body, headers, etc
    private $_get_args = array();
    private $_post_args = array();
    private $_put_args = array();
    private $_delete_args = array();
    private $_args = array();
    private $_allow = TRUE;
    // List all supported methods, the first will be the default format
    private $_supported_formats = array(
    		'xml' => 'application/xml',
    		'rawxml' => 'application/xml',
    		'json' => 'application/json',
    		'jsonp' => 'application/json',
    		'serialize' => 'application/vnd.php.serialized',
    		'php' => 'text/plain',
    		'html' => 'text/html',
    		'csv' => 'application/csv'
    );

    public function __construct()
    {
        $this->rest_format = 'json';
        parent::__construct();

        // How is this request being made? POST, DELETE, GET, PUT?
        $this->request->method = $this->_detect_method();

        // Some Methods cant have a body
        $this->request->body = NULL;

        switch ($this->request->method)
        {
        	case 'get':
        		// Grab proper GET variables
        		parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $get);

        		// If there are any, populate $this->_get_args
        		empty($get) OR $this->_get_args = $get;
        		break;

        	case 'post':
        		$this->_post_args = $_POST;

        		// It might be a HTTP body
        		$this->request->body = file_get_contents('php://input');
        		break;

        	case 'put':
        		// It might be a HTTP body
        		$this->request->body = file_get_contents('php://input');

        		// Try and set up our PUT variables anyway in case its not
        		parse_str($this->request->body, $this->_put_args);
        		break;

        	case 'delete':
        		// Set up out PUT variables
        		parse_str(file_get_contents('php://input'), $this->_delete_args);
        		break;
        }

        // Set up our GET variables
        $this->_get_args = array_merge($this->_get_args, $this->uri->ruri_to_assoc());

        // Merge both for one mega-args variable
        $this->_args = array_merge($this->_get_args, $this->_put_args, $this->_post_args, $this->_delete_args);

        // Which format should the data be returned in?
        $this->request->format = $this->_detect_format();

        // Which format should the data be returned in?
        $this->request->lang = $this->_detect_lang();

    }

    /**
     * Genera un mensaje de error
     *
     * @param string $info error information
     * @param int $number error reference number
     * @param int $status HTTP status code to return
     */
    private function responseError($info, $code = 9999, $status = 404)
    {
    	$this->response(array('error'=>array('info'=>$info,'code'=>$code)), $status);
    	die;
    }

    private function validateApiKey()
    {
    	$this->api_key = $this->get('api_key');
    	if (empty($this->api_key))
    	{
    		$this->responseError('Api Key not found', __LINE__, 403);
    	}

    	$admin = new Admin();
    	$admin_result = $admin->get_all()->where('token = ?', $this->api_key)->limit(1)->execute()->toArray();

    	if ($admin_result)
    	{
    		$this->_admin_id = $admin_result[0]['id'];
    		$sucursales = new Admin_M_Sucursal();
    		$sucursales_result = $sucursales->get_all()->addWhere('admin_id = ?', $this->_admin_id)->execute()->toArray();
    		foreach ($sucursales_result as $res)
    		{
    			$this->_sucursal_id[] = $res['sucursal_id'];
    		}
    		$group = new Admin_M_Grupo();
    		$group_result = $group->get_all()->addWhere('admin_id = ?', $this->_admin_id)->addWhere('grupo_id = ?', $this->_group_api)->execute()->toArray();
    		if (!$group_result)
    		{
    			$this->responseError('No permissions available', __LINE__, 403);
    		}
    	}
    	else
    	{
    		$this->responseError('No permissions available', __LINE__, 403);
    	}
    }

    /**
	 * Remap
	 *
	 * Requests are not made to methods directly The request will be for an "object".
	 * this simply maps the object and method to the correct Controller method.
	 */
	public function _remap($object_called)
	{
		$controller_method = $object_called . '_' . $this->request->method;

		// Do we want to log this method (if allowed by config)?
		$log_method = !(isset($this->methods[$controller_method]['log']) AND $this->methods[$controller_method]['log'] == FALSE);

		// Use keys for this method?
		$use_key = !(isset($this->methods[$controller_method]['key']) AND $this->methods[$controller_method]['key'] == FALSE);

		// Get that useless shitty key out of here
		if ($use_key AND $this->validateApiKey())
		{
			$this->responseError('Invalida Api Key', __LINE__, 403);
		}

		// Sure it exists, but can they do anything with it?
		if (!method_exists($this, $controller_method))
		{
			$this->responseError('Invalida Api method', __LINE__, 404);
		}

		try {
			$this->$controller_method();
		} catch (Exception $e)
		{
			if ($e->getCode() == 0)
			{
				$this->responseError(error_get_last(), -1, 501);
			} else {
				$this->responseError($e->getMessage(), $e->getCode(), 501);
			}
		}
	}

	/**
	 * response
	 *
	 * Takes pure data and optionally a status code, then creates the response
	 */
	public function response($data = array(), $http_code = 200)
	{
		$output = null;

		if (empty($data))
		{
			$http_code = 404;
		}

		else
		{
			// If the format method exists, call and return the output in that format
			if (method_exists($this, '_format_'.$this->request->format))
			{
				// Set the correct format header
				header('Content-type: '.$this->_supported_formats[$this->request->format]);

				$formatted_data = $this->{'_format_'.$this->request->format}($data);
				$output = $formatted_data;
			}

			// Format not supported, output directly
			else
			{
				$output = $data;
			}
		}

		header('HTTP/1.1: ' . $http_code);
		header('Status: ' . $http_code);

		exit($output);
	}

	/**
	 * Detect format
	 *
	 * Detect which format should be used to output the data
	 */
	private function _detect_format()
	{
		$pattern = '/\.(' . implode('|', array_keys($this->_supported_formats)) . ')$/';

		// Check if a file extension is used
		if (preg_match($pattern, end($this->_get_args), $matches))
		{
			// The key of the last argument
			$last_key = end(array_keys($this->_get_args));

			// Remove the extension from arguments too
			$this->_get_args[$last_key] = preg_replace($pattern, '', $this->_get_args[$last_key]);
			$this->_args[$last_key] = preg_replace($pattern, '', $this->_args[$last_key]);

			return $matches[1];
		}

		// A format has been passed as an argument in the URL and it is supported
		if (isset($this->_args['format']) AND isset($this->_supported_formats))
		{
			return $this->_args['format'];
		}

		// Otherwise, check the HTTP_ACCEPT (if it exists and we are allowed)
		if ($this->config->item('rest_ignore_http_accept') === FALSE AND $this->input->server('HTTP_ACCEPT'))
		{
			// Check all formats against the HTTP_ACCEPT header
			foreach (array_keys($this->_supported_formats) as $format)
			{
				// Has this format been requested?
				if (strpos($this->input->server('HTTP_ACCEPT'), $format) !== FALSE)
				{
					// If not HTML or XML assume its right and send it on its way
					if ($format != 'html' AND $format != 'xml')
					{

						return $format;
					}

					// HTML or XML have shown up as a match
					else
					{
						// If it is truely HTML, it wont want any XML
						if ($format == 'html' AND strpos($this->input->server('HTTP_ACCEPT'), 'xml') === FALSE)
						{
							return $format;
						}

						// If it is truely XML, it wont want any HTML
						elseif ($format == 'xml' AND strpos($this->input->server('HTTP_ACCEPT'), 'html') === FALSE)
						{
							return $format;
						}
					}
				}
			}
		} // End HTTP_ACCEPT checking
		// Well, none of that has worked! Let's see if the controller has a default
		if (!empty($this->rest_format))
		{
			return $this->rest_format;
		}

		// Just use the default format
		return config_item('rest_default_format');
	}

	/**
	 * Detect language(s)
	 *
	 * What language do they want it in?
	 */
	private function _detect_lang()
	{
		if (!$lang = $this->input->server('HTTP_ACCEPT_LANGUAGE'))
		{
			return NULL;
		}

		// They might have sent a few, make it an array
		if (strpos($lang, ',') !== FALSE)
		{
			$langs = explode(',', $lang);

			$return_langs = array();
			$i = 1;
			foreach ($langs as $lang)
			{
				// Remove weight and strip space
				list($lang) = explode(';', $lang);
				$return_langs[] = trim($lang);
			}

			return $return_langs;
		}

		// Nope, just return the string
		return $lang;
	}

	/**
	 * Detect method
	 *
	 * Detect which method (POST, PUT, GET, DELETE) is being used
	 */
	private function _detect_method()
	{
		$method = strtolower($this->input->server('REQUEST_METHOD'));
		if (in_array($method, array('get', 'delete', 'post', 'put')))
		{
			return $method;
		}

		return 'get';
	}

    // INPUT FUNCTION --------------------------------------------------------------

    public function get($key = NULL, $xss_clean = TRUE)
    {
    	if ($key === NULL)
    	{
    		return $this->_get_args;
    	}

    	return array_key_exists($key, $this->_get_args) ? $this->_xss_clean($this->_get_args[$key], $xss_clean) : FALSE;
    }

    public function post($key = NULL, $xss_clean = TRUE)
    {
    	if ($key === NULL)
    	{
    		return $this->_post_args;
    	}

    	return $this->input->post($key, $xss_clean);
    }

    public function put($key = NULL, $xss_clean = TRUE)
    {
    	if ($key === NULL)
    	{
    		return $this->_put_args;
    	}

    	return array_key_exists($key, $this->_put_args) ? $this->_xss_clean($this->_put_args[$key], $xss_clean) : FALSE;
    }

    public function delete($key = NULL, $xss_clean = TRUE)
    {
    	if ($key === NULL)
    	{
    		return $this->_delete_args;
    	}

    	return array_key_exists($key, $this->_delete_args) ? $this->_xss_clean($this->_delete_args[$key], $xss_clean) : FALSE;
    }

    private function _xss_clean($val, $bool)
    {
    	if (CI_VERSION < 2)
    	{
    		return $bool ? $this->input->xss_clean($val) : $val;
    	}
    	else
    	{
    		$this->load->library('security');
    		return $bool ? $this->security->xss_clean($val) : $val;
    	}
    }

    public function validation_errors()
    {
    	$string = strip_tags($this->form_validation->error_string());

    	return explode("\n", trim($string, "\n"));
    }

    // Force it into an array
    private function _force_loopable($data)
    {
    	// Force it to be something useful
    	if (!is_array($data) AND !is_object($data))
    	{
    		$data = (array) $data;
    	}

    	return $data;
    }

    // FORMATING FUNCTIONS ---------------------------------------------------------
    // Format XML for output
    private function _format_xml($data = array(), $structure = NULL, $basenode = 'xml')
    {
    	// turn off compatibility mode as simple xml throws a wobbly if you don't.
    	if (ini_get('zend.ze1_compatibility_mode') == 1)
    	{
    		ini_set('zend.ze1_compatibility_mode', 0);
    	}

    	if ($structure == NULL)
    	{
    		$structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$basenode />");
    	}

    	// loop through the data passed in.
    	$data = $this->_force_loopable($data);
    	foreach ($data as $key => $value)
    	{
    		// no numeric keys in our xml please!
    		if (is_numeric($key))
    		{
    			// make string key...
    			//$key = "item_". (string) $key;
    			$key = "item";
    		}

    		// replace anything not alpha numeric
    		$key = preg_replace('/[^a-z_]/i', '', $key);

    		// if there is another array found recrusively call this function
    		if (is_array($value) OR is_object($value))
    		{
    			$node = $structure->addChild($key);
    			// recrusive call.
    			$this->_format_xml($value, $node, $basenode);
    		}
    		else
    		{
    			// Actual boolean values need to be converted to numbers
    			is_bool($value) AND $value = (int) $value;

    			// add single node.
    			$value = htmlentities($value, ENT_NOQUOTES, "UTF-8");

    			$UsedKeys[] = $key;

    			$structure->addChild($key, $value);
    		}
    	}

    	// pass back as string. or simple xml object if you want!
    	return $structure->asXML();
    }

    // Format Raw XML for output
    private function _format_rawxml($data = array(), $structure = NULL, $basenode = 'xml')
    {
    	// turn off compatibility mode as simple xml throws a wobbly if you don't.
    	if (ini_get('zend.ze1_compatibility_mode') == 1)
    	{
    		ini_set('zend.ze1_compatibility_mode', 0);
    	}

    	if ($structure == NULL)
    	{
    		$structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$basenode />");
    	}

    	// loop through the data passed in.
    	$data = $this->_force_loopable($data);
    	foreach ($data as $key => $value)
    	{
    		// no numeric keys in our xml please!
    		if (is_numeric($key))
    		{
    			// make string key...
    			//$key = "item_". (string) $key;
    			$key = "item";
    		}

    		// replace anything not alpha numeric
    		$key = preg_replace('/[^a-z0-9_-]/i', '', $key);

    		// if there is another array found recrusively call this function
    		if (is_array($value) OR is_object($value))
    		{
    			$node = $structure->addChild($key);
    			// recrusive call.
    			$this->_format_rawxml($value, $node, $basenode);
    		}
    		else
    		{
    			// Actual boolean values need to be converted to numbers
    			is_bool($value) AND $value = (int) $value;

    			// add single node.
    			$value = htmlentities($value, ENT_NOQUOTES, "UTF-8");

    			$UsedKeys[] = $key;

    			$structure->addChild($key, $value);
    		}
    	}

    	// pass back as string. or simple xml object if you want!
    	return $structure->asXML();
    }

    // Format HTML for output
    private function _format_html($data = array())
    {
    	// Multi-dimentional array
    	if (isset($data[0]))
    	{
    		$headings = array_keys($data[0]);
    	}

    	// Single array
    	else
    	{
    		$headings = array_keys($data);
    		$data = array($data);
    	}

    	$this->load->library('table');

    	$this->table->set_heading($headings);

    	foreach ($data as &$row)
    	{
    		$this->table->add_row($row);
    	}

    	return $this->table->generate();
    }

    // Format HTML for output
    private function _format_csv($data = array())
    {
    	// Multi-dimentional array
    	if (isset($data[0]))
    	{
    		$headings = array_keys($data[0]);
    	}

    	// Single array
    	else
    	{
    		$headings = array_keys($data);
    		$data = array($data);
    	}

    	$output = implode(',', $headings) . "\r\n";
    	foreach ($data as &$row)
    	{
    		$output .= '"' . implode('","', $row) . "\"\r\n";
    	}

    	return $output;
    }

    // Encode as JSON
    private function _format_json($data = array())
    {
    	return json_encode($data);
    }

    // Encode as JSONP
    private function _format_jsonp($data = array())
    {
    	return $this->get('callback') . '(' . json_encode($data) . ')';
    }

    // Encode as Serialized array
    private function _format_serialize($data = array())
    {
    	return serialize($data);
    }

    // Encode raw PHP
    private function _format_php($data = array())
    {
    	return var_export($data, TRUE);
    }

}
?>