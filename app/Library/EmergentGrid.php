<?php

namespace App\Library;

class EmergentGrid
{

    protected $m;
    protected $n; 
    
    function __construct($m, $n) {
        $this->m = $m;
        $this->n = $n;
    }
    
    protected $cells = array();

    /**
     * Receives an array list of all live cells, and sets them up
     * 
     * @param array $liveCells
     */
    public function setLiveCells(Array $liveCells) {
        foreach ($liveCells as $cell) {
            $this->addCell($cell[0], $cell[1], true);
        }
    }
    
    /** 
     * Runs through all the live cells, running in a circle around it. This sets
     * up all the contact cells and keeps track of how many live cells a contact
     * cell touches.
     */
    public function buildContactCells() {
        foreach($this->cells as $keyM => $cells) {
            foreach ($cells as $keyN => $cell) {
                $this->_loopLiveCell($keyM, $keyN);
            }
            ksort($this->cells[$keyM]); //make everything in order keywise
        }
        ksort($this->cells);
    }
    
    /**
     * Runs through all the live cells and calculates from the cells being 
     * touched which are now live cells
     */
    public function nextGeneration() {
        
        //store our list of live cells
        $nextGen = array();
        
        //run through all the cells and figure out which ones are live
        foreach($this->cells as $keyM => $cells) {
            foreach ($cells as $keyN => $cell) {
                if ($this->cells[$keyM][$keyN]->isLive()) {
                    $nextGen[] = array($keyM, $keyN);
                }
            }
        }
        
        return $nextGen;
    }
    
    /**
     * Runs around all the cells touching the live cell
     * @param int $m
     * @param int $n
     */
    protected function _loopLiveCell($m, $n) {

        //loop rows
        for ($r = ($m - 1); $r <= ($m + 1); $r++) {
            
            //outside of bounds skip it
            if ($r < 0 || $r >= $this->m) continue;

            //loop cells
            for ($c = ($n -1); $c <= ($n + 1); $c++) {

                //outside of bounds skip it
                if ($c < 0 || $c >= $this->n) continue;
                
                //current live cell, skip it
                if ($r == $m && $c == $n) continue;

                //check if we already have a cell object created
                if (!array_key_exists($r, $this->cells) || !array_key_exists($c, $this->cells[$r])) {
                    $this->cells[$r][$c] = new EmergentCell($r, $c, false);
                }
                
                $this->cells[$r][$c]->increment(); //add 1 for count
                
            }
        }
    }
    
    
    public function addCell($m, $n, $live = false) {
        $cell = new EmergentCell($m, $n, $live);
        $this->cells[$m][$n] = $cell;
    }

}

class EmergentCell
{

    protected $m;
    protected $n;
    protected $live = false;
    protected $count = 0;
    
    function __construct($m, $n, $live) {
        $this->setM($m);
        $this->setN($n);
        $this->setLive($live);
    }
    
    public function getLive() {
        return $this->live;
    }

    public function setLive($live) {
        $this->live = $live;
    }

    public function getCount() {
        return $this->count;
    }

    public function increment() {
        $this->count++;
    }

    public function getM() {
        return $this->m;
    }

    public function setM($m) {
        $this->m = $m;
    }

    public function getN() {
        return $this->n;
    }

    public function setN($n) {
        $this->n = $n;
    }

    /**
     * Check if the current cell should be live
     * <2 == Off
     *  2 == Same State
     *  3 == ON
     * >3 == Off
     */
    public function isLive() {
        
        if ($this->getCount() < 2) {
            return false;
        }
        
        if ($this->getCount() == 2) {
            return $this->getLive();
        }
        
        if ($this->getCount() == 3) {
            return true;
        }
        
        if ($this->getCount() > 3) {
            return false;
        }
    }
}
