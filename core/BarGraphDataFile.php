<?php
$die = false;
$link = @mysql_connect('localhost', 'root', '') or ($die = true);
if($die)
{
    echo '<h3>Database connection error!!!</h3>';
    echo 'A connection to the Database could not be established.<br />';
    echo 'Please check your username, password, database name and host.<br />';
    echo 'Also make sure <i>mysql.class.php</i> is rightly configured!<br /><br />';
}
mysql_select_db('test');
include_once 'php-ofc-library/open-flash-chart.php';
$query = mysql_query('select distinct Marks, Name from test_openflash');
While($queryRow = mysql_fetch_array($query, MYSQL_ASSOC))
{
    $dataForGraph[] = intval($queryRow['Marks']);
    $XAxisLabel[] = $queryRow['Name'];
}
$title = new title( 'The marks obtained by students as of : '.date("D M d Y").' are' );
$title->set_style( '{color: #567300; font-size: 14px}' );
$chart = new open_flash_chart();
$chart->set_title( $title );
$x_axis_labels = new x_axis_labels();
$x_axis_labels->set_labels($XAxisLabel);
$y_axis = new y_axis();
$x_axis = new x_axis();
$y_axis->set_range( 0, 100, 10 );
$x_axis->set_labels ($x_axis_labels);
$chart->set_x_axis( $x_axis );
$chart->add_y_axis( $y_axis );
 
$bar = new bar_glass();
$bar->colour('#BF3B69');
$bar->key('Marks obtained', 12);
$bar->set_values($dataForGraph);
$chart->add_element($bar);
mysql_close($link);
echo $chart->toPrettyString();
?>