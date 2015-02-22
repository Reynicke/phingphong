<?php

require_once "phing/Task.php";

// Example
//  <fileset dir="some/dir" includes="**/*" id="files" />
//  <filesmodified before='60' modified="isModified">
//      <fileset refid="files" />
//  </filesmodified>

/**
 * Class FilesModifiedTask
 * 
 * Checks if the given files where modified in the last x seconds.
 * Defined as filesmodified task
 */
class FilesModifiedTask extends Task {

    protected $tStamp;
    protected $before = 60;
    protected $filesets = array();
    protected $modified = null;
    
    public function setBefore($int) {
        $this->before = $int;
    }
    
    public function setModified($str) {
        $this->modified = $str;
    }
    
    public function createFileSet() {
        $num = array_push($this->filesets, new FileSet());
        return $this->filesets[$num-1];
    }
    
    public function init() {
        $this->tStamp = time();
    }

    public function main() {
        $project = $this->getProject();
        $isModified = false;
        
        foreach($this->filesets as $fs) {
            $ds = $fs->getDirectoryScanner($project);
            $files = $ds->getIncludedFiles();
            $dir =  $fs->getDir($this->project)->getPath();
            
            foreach($files as $file){
                $filePath = $dir.DIRECTORY_SEPARATOR.$file;

                if ($this->tStamp - filemtime($filePath) < $this->before) {
                    $this->log("$filePath: modification time is newer than " . ($this->before) . 'sec');
                    $isModified = true;
                    break;
                }
            }
            
            if ($isModified) break;
        }

        $project->setProperty(
            $this->modified,
            $isModified
        );
    }
}
