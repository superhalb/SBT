<?php

	class Issue {
	
		public function __construct($f){
		
			$this->number = $f;
			$this->dir = getcwd() ."/issues/".$f;
			$this->steps = Issue::getContents( $this->dir . "/issue-steps.php");
			$this->expected = Issue::getContents( $this->dir . "/issue-expected.php");
			$this->saw = Issue::getContents( $this->dir . "/issue-saw.php");
			$this->creator = Issue::getContents( $this->dir . "/issue-creator.php");
			$this->creation = (int) Issue::getContents( $this->dir . "/issue-creation.php");
			$this->creationStr = gmdate('Y-m-d', $this->creation);
			
			$d = dir( $this->dir );
			$files = array();
			while (($file = $d->read()) !== false){ 
				if( in_array( $file[0] , array('i','.') ) ) continue; 
				array_push( $files, $file );
			}
			$d->close(); 
			sort($files);
			
			$last = $this->getEditDetails( end($files) );
			$this->assigned = $last->assign;
			$this->modification = $last->time;
			$this->modificationStr = $last->timeStr;
		}
		
		public function readEdits() {
			$d = dir( $this->dir );
			$files = array();
			while (($file = $d->read()) !== false){ 
				if( in_array( $file[0] , array('i','.') ) ) continue; 
				array_push( $files, $file );
			}
			$d->close(); 
			sort($files);
			$this->edits = array();
			foreach($files as $f) {
				array_push( $this->edits , $this->getEditDetails( $f ) );
			}
		}
		
		private function getEditDetails( $f ) {
			$e = explode('.',$f);
			$result->time = (int) $e[0];
			$result->timeStr = gmdate('Y-m-d', $result->time);
			$result->who = $e[1];
			$result->assign = $e[2];
			$result->msg = Issue::getContents($this->dir ."/". $f);
			return $result;
		}

		static private function getContents( $f ) {
			$c = file_get_contents( $f );
			$c = substr($c,14);
			$c = str_replace("\n","<br>",$c);
			return $c;
		}
		
	}

?>