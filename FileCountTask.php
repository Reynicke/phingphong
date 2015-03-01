<?php

require_once "phing/Task.php";

// Example
//  <filecount returnProperty="count">
//      <fileset dir="some/dir" includes="**/*" />
//  </filecount>
//  <echo message="${count}" /> 

/**
 * Class FileCountTask
 * 
 * Counts files in the given filesets
 */
class FileCountTask extends Task {

    protected $filesets = array();
    protected $returnProperty = null;
    
    public function setReturnProperty($str) {
        $this->returnProperty = $str;
    }
    
    public function createFileSet() {
        $num = array_push($this->filesets, new FileSet());
        return $this->filesets[$num-1];
    }
    
    public function init() {
    }

    public function main() {
        $project = $this->getProject();
        $count = 0;
        
        foreach($this->filesets as $fs) {
            $ds = $fs->getDirectoryScanner($project);
            $files = $ds->getIncludedFiles();
            $count += count($files);
        }

        $project->setProperty(
            $this->returnProperty,
            $count
        );
    }
}
