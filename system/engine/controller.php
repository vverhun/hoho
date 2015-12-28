<?php
abstract class Controller {
	protected $registry;	
	protected $id;
	protected $template;
	protected $children = array();
	protected $data = array();
	protected $output;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
			
	protected function forward($route, $args = array()) {
		return new Action($route, $args);
	}

	protected function redirect($url) {
		header('Location: ' . str_replace('&amp;', '&', $url));
		exit();
	}
	
	protected function render($return = FALSE) {
		foreach ($this->children as $child) {
			$action = new Action($child);
			$file   = $action->getFile();
			$class  = $action->getClass();
			$method = $action->getMethod();
			$args   = $action->getArgs();
		
			if (file_exists($file)) {
				require_once($file);

				$controller = new $class($this->registry);
				
				$controller->index();
				
				$this->data[$controller->id] = $controller->output;
			} else {
				exit('Error: Could not load controller ' . $child . '!');
			}
		}
		
		if ($return) {
			return $this->fetch($this->template);
		} else {
			$this->output = $this->fetch($this->template);
		}
	}

	protected function renderPDF() {
 
        require_once(DIR_SYSTEM.'tcpdf/config/lang/eng.php');
        require_once(DIR_SYSTEM.'tcpdf/tcpdf.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray($l);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 10);
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		
		// add a page
		$pdf->AddPage();

 
		$tablecontent = $this->fetch($this->template);
		
		// output the HTML content
		$pdf->writeHTML($tablecontent, true, false, true, false, '');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$this->output =  $pdf->Output('invoice.pdf', 'I');
		//============================================================+
		// END OF FILE                                                
		//============================================================+
	}
	
	protected function renderPDFIntoFile($template,$filename) {
 
        require_once(DIR_SYSTEM.'tcpdf/config/lang/eng.php');
        require_once(DIR_SYSTEM.'tcpdf/tcpdf.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		//set some language-dependent strings
		$pdf->setLanguageArray($l);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 10);
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		
		// add a page
		$pdf->AddPage();

 
		$tablecontent = $this->fetch($template);
		
		// output the HTML content
		$pdf->writeHTML($tablecontent, true, false, true, false, '');

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('invoice'.$filename.'.pdf', 'F');
		//============================================================+
		// END OF FILE                                                
		//============================================================+
	}
	
	
	protected function fetch($filename) {
		$file = DIR_TEMPLATE . $filename;
    
		if (file_exists($file)) {
			extract($this->data);
			
      		ob_start();
      
	  		require($file);
      
	  		$content = ob_get_contents();

      		ob_end_clean();

      		return $content;
    	} else {
      		exit('Error: Could not load template ' . $file . '!');
    	}
	}
}
?>