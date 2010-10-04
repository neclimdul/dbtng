<?php
// $Id: cron.php,v 1.42 2009/02/08 20:27:51 webchick Exp $


/**
 * Rewrite configuration.
 *
 * Using the following keys:
 *
 * - 'functions': name of functions(s) to move.
 * - 'source': Files to rewrite.
 * - 'target': Target filename. Code is appended to existing files. New files
 */

$merge_rename = array(
  'functions' => array(
    'db_driver',
    'db_set_active',
    'db_is_active',
    'db_escape_table',
    'db_distinct_field',
    'db_create_table',
    'db_field_names',
    'db_table_exists',
    'db_column_exists',
    'db_find_tables',
    '_db_create_keys_sql',
    'db_type_map',
    'db_rename_table',
    'db_drop_table',
    'db_add_field',
    'db_drop_field',
    'db_field_set_default',
    'db_field_set_no_default',
    'db_add_primary_key',
    'db_drop_primary_key',
    'db_add_unique_key',
    'db_drop_unique_key',
    'db_add_index',
    'db_drop_index',
    'db_change_field',
    'db_query',
    '_db_query_process_args',
    'db_field_exists',
    'db_index_exists',
    'db_escape_field',
  ),
  'source' => 'dbtng/database/database.inc',
  'target' => 'dbtng/dbtng.module',
  'blank target' => 'module.template',
);
$copy = array(
  'functions' => array(
    'db_insert',
    'db_merge',
    'db_update',
    'db_delete',
    'db_truncate',
    'db_select',
    'db_transaction',
    'db_close',
    'db_condition',
    'db_xor',
    'db_and',
    'db_or',
    'db_next_id',
    'db_like',
  ),
);


$remove = array(
  'functions' => array(
    'db_placeholders',
    'db_type_placeholder',
    '_db_check_install_needed',
    '_db_rewrite_sql',
    'db_rewrite_sql',
    '_db_error_page',
    'db_fetch_object',
    'db_fetch_array',
    'db_result',
    'db_query_range',
    'db_query_temporary',
    'db_last_insert_id',
    'db_affected_rows',
    'db_ignore_slave',
    'update_sql',
    'db_autoload',
  ),
  'source' => 'dbtng/database/database.inc',
);

/**
 * Do the merging
 */

// Fetch the source file content.
$content = file_get_contents($merge_rename['source']);

// Retrieve code to move and rename
$rename = array();

foreach ($merge_rename['functions'] as $function) {
  // Dunno why, but this only matches 1 function. Who cares, while() helps. 21/05/2009 sun
  $s = '@
(?:^/\*\*(?:(?!\*\*).)+?\*/\s+)?                       # Optional PHPDoc
^function\ ' . $function . '\(.*?\)  # Function name + arguments
(?:(?!^\}).)+?                                         # Function body
^\}                                                    # Closing function body
\s+                                                    # White-space to next function
@smx';
  while (preg_match($s, $content, $matches) && !empty($matches[0])) {
    $rename[] = $matches[0];
    
    $content = str_replace($matches[0], '', $content);
  }
}

// Retrieve code to copy
$move = array();

foreach ($copy['functions'] as $function) {
  // Dunno why, but this only matches 1 function. Who cares, while() helps. 21/05/2009 sun
  $s = '@
(?:^/\*\*(?:(?!\*\*).)+?\*/\s+)?                       # Optional PHPDoc
^function\ ' . $function . '\(.*?\)  # Function name + arguments
(?:(?!^\}).)+?                                         # Function body
^\}                                                    # Closing function body
\s+                                                    # White-space to next function
@smx';
  while (preg_match($s, $content, $matches) && !empty($matches[0])) {
    $move[] = $matches[0];
    
    $content = str_replace($matches[0], '', $content);
  }
}

// Delete code
foreach ($remove['functions'] as $function) {
  // Dunno why, but this only matches 1 function. Who cares, while() helps. 21/05/2009 sun
  $s = '@
(?:^/\*\*(?:(?!\*\*).)+?\*/\s+)?                       # Optional PHPDoc
^function\ ' . $function . '\(.*?\)  # Function name + arguments
(?:(?!^\}).)+?                                         # Function body
^\}                                                    # Closing function body
\s+                                                    # White-space to next function
@smx';
  while (preg_match($s, $content, $matches) && !empty($matches[0])) {
    $content = str_replace($matches[0], '', $content);
  }
}

if (!empty($move)) {
  // Write target file. (dbtng.module)
  // Get the template
  $newcontent = file_get_contents($merge_rename['blank target']);
  // Rename the content to be renamed
  $renamecontent = implode('', $rename);
  $renamecontent = str_replace(' db_', ' dbtng_', $renamecontent);
  $renamecontent = str_replace(' _db_', ' _dbtng_', $renamecontent);
  // Prepare the moved content
  $movecontent = implode('', $move);
  // Write the module file
  $newcontent = $newcontent . $movecontent . $renamecontent;
  file_put_contents($merge_rename['target'], $newcontent);

  // Remove code from source file.
  file_put_contents($merge_rename['source'], $content);  
}
