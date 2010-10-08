<?php
// $Id: install.inc,v 1.1.2.3 2010/10/05 00:49:56 mikeyp Exp $

/**
 * @file
 * Installation code for MySQL embedded database engine.
 */

/**
 * Specifies installation tasks for MySQL and equivalent databases.
 */
class DatabaseTasks_mysql extends DatabaseTasks {

  /**
   * The PDO driver name for MySQL and equivalent databases.
   *
   * @var string
   */
  protected $pdoDriver = 'mysql';

  /**
   * Returns a human-readable name string for MySQL and equivalent databases.
   */
  public function name() {
    return 'MySQL, MariaDB, or equivalent';
  }
}

