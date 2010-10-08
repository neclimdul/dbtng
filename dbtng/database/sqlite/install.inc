<?php
// $Id: install.inc,v 1.1.2.3 2010/10/05 00:49:57 mikeyp Exp $

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

