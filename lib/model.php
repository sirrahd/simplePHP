<?php

class Model
{
	private $errors = array();

	function Model()
    {
		return;
    }

	// Public interface for errors, presents errors and counts
	// and removes them from the object record.
	function getErrors()
	{
		$response = array(
			'count' 	=> $this->errorCount(),
			'details'	=> $this->errors
		);

		$this->clearErrors();

		return $response;
	}

	protected function errorCount()
	{
		return count($this->errors);
	}

	protected function addError($errorName)
	{
		$this->errors[] = $errorName;
	}

	private function clearErrors()
	{
		$this->errors = array();
	}	
}

?>
