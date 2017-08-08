<?php

	class Issue {

		const attachsPath = 'files/';

		const DATEFORMAT = "Y-m-d H:i:s";

		static private function removeLines( $string ) {
			$string = str_replace(array("\n", "\r","<br>"), '', $string);
			return trim($string);
		}

		public function __construct($f){

			$this->number = $f;
			$this->dir = getcwd() ."/issues/".$f;
			$this->steps = Issue::getContents( $this->dir . "/issue-steps.md");
			$this->expected = Issue::getContents( $this->dir . "/issue-expected.md");
			$this->saw = Issue::getContents( $this->dir . "/issue-saw.md");
			$this->sawShort = strlen( $this->saw ) > 255 ? substr( $this->saw , 0 , 255 ) . " ..." : $this->saw;
			$this->creator = self::removeLines( Issue::getContents( $this->dir . "/issue-creator") );
			$this->creation = (int) Issue::getContents( $this->dir . "/issue-creation");
			$this->creationStr = gmdate( self::DATEFORMAT , $this->creation);

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
				$e = explode('.',$f);
				$edit = $this->getEditDetails( $e , $f );
				$edit->attachs = array();
				$attachs = glob( Issue::attachsPath . $this->number . "." . $e[0] . "*" );
				foreach ( $attachs as $filename ) {
					$a = explode( "." , basename( $filename ) );
					unset( $a[ 0 ] );
					unset( $a[ 1 ] );
					unset( $a[ 2 ] );
					$edit->attachs[ basename( $filename ) ] = implode(".",$a);
				}
				array_push( $this->edits , $edit );
			}
		}

		private function getEditDetails( $e , $f = NULL) {
			if ( $f === NULL ) {
				$f = $e;
				$e = explode('.',$f);
			}
			$result = new \stdClass();
			$result->time = (int) $e[0];
			$result->timeStr = gmdate(self::DATEFORMAT, $result->time);
			$result->who = $e[1];
			$result->assign = $e[2];
			$result->msg = Issue::getContents($this->dir ."/". $f);
			return $result;
		}

		static private function getContents( $f ) {
			$c = file_get_contents( $f );
			//$c = substr($c,14);
			$c = str_replace("\n","<br>",$c);
			return $c;
		}

	}

?>
