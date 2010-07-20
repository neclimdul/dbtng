#!/bin/bash
rm -r tmp/dbtng/database
rm -r tmp/dbtng/includes/pager.inc
rm -r tmp/dbtng/includes/tablesort.inc

cvs -d :pserver:anonymous:anonymous@cvs.drupal.org/cvs/drupal export -r $1 -d tmp/dbtng/database drupal/includes/database
cvs -d :pserver:anonymous:anonymous@cvs.drupal.org/cvs/drupal export -r $1 -d tmp/dbtng/includes drupal/includes/pager.inc
cvs -d :pserver:anonymous:anonymous@cvs.drupal.org/cvs/drupal export -r $1 -d tmp/dbtng/includes drupal/includes/tablesort.inc

rsync -avzC tmp/dbtng/database/ dbtng/database/
rsync -avzC tmp/dbtng/includes/ dbtng/includes/