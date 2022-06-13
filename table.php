<?php
/**
 * Simple file test.php to drop into root of Moodle installation.
 * This is the skeleton code to print a downloadable, paged, sorted table of
 * data from a sql query.
 */
require_once(__DIR__ . '/../../config.php');
require_once("$CFG->libdir/tablelib.php");
require_once($CFG -> dirroot . '/local/googleclass/classes/form/table.php');
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/local/googleclass/table.php');


$courseid = 2;
$querycourse = $DB->get_records_sql('SELECT * FROM {googleclass} WHERE course = ?;',[$courseid]);


$table = new test_table('uniqueid');
// Print the page header
$PAGE->set_title('Testing');
$PAGE->set_heading('Testing table class');
$PAGE->navbar->add('Testing table class', new moodle_url('/local/googleclass/table.php'));
echo $OUTPUT->header();

// Work out the sql for the table.


$table->set_sql('id,datestart,dateend,duration', "{googleclass}", 'course=:course',['course'=>$courseid]);

$table->define_baseurl("$CFG->wwwroot/local/googleclass/table.php");


$table->out(40, true);

foreach($querycourse as $n){
    echo $n->id;
    //Insertar 1 por 1 
}

if(isset($_POST['submit'])){
    echo 'SE ELIMINO';
}


echo $OUTPUT->footer();

