<?php
// $Id: install.inc,v 1.1.2.2 2010/07/21 05:43:57 mikeyp Exp $

/**
 * @file
 * Installation code for MySQL embedded database engine.
 */


// MySQL specific install functions

class DatabaseTasks_mysql extends DatabaseTasks {
  protected $pdoDriver = 'mysql';
  public function name() {
    return 'MySQL';
  }
}

