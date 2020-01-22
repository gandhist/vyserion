<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Chris Harvey
 * @license			MIT License
 * @link			https://github.com/chrisnharvey/CodeIgniter-PDF-Generator-Library
 */
//require_once(dirname(__FILE__) . '/dompdf/dompdf_config.inc.php');
require_once(APPPATH."libraries/dompdf/autoload.inc.php");

use Dompdf\Options;
use Dompdf\Dompdf;
class Pdf extends Dompdf
{
	/**
	 * Get an instance of CodeIgniter
	 *
	 * @access	protected
	 * @return	void
	 */
	protected function ci()
	{
		return get_instance();
	}
	/**
	 * Load a CodeIgniter view into domPDF
	 *
	 * @access	public
	 * @param	string	$view The view to load
	 * @param	array	$data The view data
	 * @return	void
	 */
	public function load_view($view, $data = array())
	{
		ini_set('memory_limit', '1000M');
		
		$html = $this->ci()->load->view($view, $data, TRUE);
		$options = new Options();
		$options->setIsRemoteEnabled(true);

		$this->setOptions($options);
		$this->load_html($html);
        $this->render();
        //$this->stream("laporan.pdf", array('Attachment'=>0));
	}
	public function download($view, $data = array())
	{
		$html = $this->ci()->load->view($view, $data, TRUE);
	
		$this->load_html($html);
        $this->render();
        $this->stream("laporan.pdf", array('Attachment'=>1));
	}
	// for direct donwload without showing the file into browser
	/*$pdfroot  = dirname(dirname(__FILE__));
        $pdfroot .= '/slip/';
        $nik = $data['emp_attrb'][0]['empcode'];
		$html = $this->ci()->load->view($view, $data, TRUE);
	
		$this->load_html($html);
        $this->render();
        $output = $this->output();
    	file_put_contents($nik.'.pdf', $output);
        //$this->stream("laporan.pdf", array('Attachment'=>0));*/
}