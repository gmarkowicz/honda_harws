<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Profiler extends CI_Profiler {

	var $doctrine_time;
	var $doctrine_peak_memory;
	var $doctrine_events;
	
	public function set_doctrine_time($time)
	{
		$this->doctrine_time=$time;
	}
	
	public function set_doctrine_peak_memory($peak_memory)
	{
		$this->doctrine_peak_memory=$peak_memory;
	}
	
	public function set_doctrine_events($events)
	{
		$this->doctrine_events=$events;
	}
	
	/**
	 * Compile Queries
	 *
	 * @access	private
	 * @return	string
	 */	
	function _compile_queries()
	{
		
			$output  = "\n\n";
			$output .= '<fieldset style="border:1px solid #0000FF;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee">';
			$output .= "\n";
			$output .= '<legend style="color:#0000FF;">&nbsp;&nbsp;Doctrine&nbsp;&nbsp;</legend>';
			$output .= "\n";		
			$output .= "\n\n<table cellpadding='4' cellspacing='1' border='0' width='100%'>\n";
			$output .="<tr><td width='100%' style='color:#0000FF;font-weight:normal;background-color:#eee;'>
						Total Doctrine Time: ".$this->doctrine_time."<br />
						Peak Memory: ".$this->doctrine_peak_memory."<br />
						<pre>
						".print_r($this->doctrine_events,1)."
						</pre>
						</td></tr>\n";
			$output .= "</table>\n";
			$output .= "</fieldset>";
			
			return $output;
	}

	
	// --------------------------------------------------------------------
	
	
}