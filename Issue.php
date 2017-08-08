<?php

	class Issue {

		const ATTACHS_PATH = 'files/';
		const DATEFORMAT = "Y-m-d H:i:s";

		public function __construct( $id , $descriptions = NULL ){

			$this->number = $id;
			$this->dir = getcwd() . "/issues/" . $this->number;
			if ( $descriptions ) {
				$this->steps = $descriptions->steps;
				$this->expected = $descriptions->expected;
				$this->saw = $descriptions->saw;
				mkdir( $this->dir );
				file_put_contents( $this->dir . "/issue-steps.md", $this->steps );
				file_put_contents( $this->dir . "/issue-expected.md", $this->expected );
				file_put_contents( $this->dir . "/issue-saw.md", $this->saw);
				$this->update( $descriptions->assigned , "Created" );
			} else {
				$this->steps = $this->fileGetContentsMD( "issue-steps.md");
				$this->expected = $this->fileGetContentsMD( "issue-expected.md");
				$this->saw = $this->fileGetContentsMD( "issue-saw.md");
			}

			$files = $this->getEditFilesList();

			$first = $this->getEditDetails( reset($files) );
			$this->creator = $first->who;
			$this->creation = $first->time;

			$last = $this->getEditDetails( end($files) );
			$this->assigned = $last->assigned;
			$this->modification = $last->time;
		}

		private function fileGetContentsMD( $file ){
			$content = file_get_contents( $this->dir . '/' . $file);
			$content = str_replace("\n","<br>",$content);
			return $content;
		}

		public function update( $assigned , $msg ){
			$now = time();
			$this->assigned = $assigned;
			file_put_contents( $this->dir . "/" .  $now . "+" . User::$name . "+" . $assigned . ".md" , $msg );
			if ( isset( $_FILES['attach'] ) ) {
				for( $i=0 ; $i < count( $_FILES['attach']['error'] ) ; ++ $i ) {
					if ( $_FILES["attach"]["error"][$i] > 0) {
						continue;
					}
					$targetfilename = Issue::ATTACHS_PATH . $this->number . "." .  $now . "." . $i . "." . $_FILES["attach"]["name"][$i];
					move_uploaded_file( $_FILES["attach"]["tmp_name"][$i], $targetfilename);
				}
			}
		}

		public function sawShort() {
			return strlen( $this->saw ) > 255 ? substr( $this->saw , 0 , 255 ) . " ..." : $this->saw;
		}

		public function getEditFilesList() {
			$d = dir( $this->dir );
			$files = array();
			while (($file = $d->read()) !== false){
				if( in_array( $file[0] , array('i','.') ) ) continue;
				array_push( $files, $file );
			}
			$d->close();
			sort($files);
			return $files;
		}

		public function readEdits() {
			$editFiles = $this->getEditFilesList();
			$this->edits = array();
			foreach ($editFiles as $editFile) {
				array_push( $this->edits , $this->getEditDetails( $editFile ) );
			}
		}


		public function creationToString() {
			return gmdate(self::DATEFORMAT, $this->creation );
		}
		public function modificationToString() {
			return gmdate(self::DATEFORMAT, $this->modification );
		}

		private function getEditDetails( $filename ) {
			$e = explode('+', pathinfo( $filename , PATHINFO_FILENAME ));

			$edit = new \stdClass();
			$edit->time = (int) $e[0];
			$edit->who = $e[1];
			$edit->assigned = $e[2];
			$edit->msg = $this->fileGetContentsMD( $filename );
			$edit->timeStr = gmdate(self::DATEFORMAT, $edit->time );

			$edit->attachs = array();
			$attachs = glob( Issue::ATTACHS_PATH . $this->number . "." . $e[0] . "*" );
			foreach ( $attachs as $attachFilename ) {
				$a = explode( "." , basename( $attachFilename ) );
				unset( $a[ 0 ] );
				unset( $a[ 1 ] );
				unset( $a[ 2 ] );
				$edit->attachs[ basename( $attachFilename ) ] = implode(".",$a);
			}

			return $edit;
		}
	}
