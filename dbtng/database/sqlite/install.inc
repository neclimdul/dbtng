<?php
// $Id: install.inc,v 1.1.2.2 2010/07/21 05:43:57 mikeyp Exp $

/**
 * @file
 * SQLite specific install functions
 */

class DatabaseTasks_sqlite extends DatabaseTasks {
  protected $pdoDriver = 'sqlite';
  public function name() {
    return 'SQLite';
  }
}

