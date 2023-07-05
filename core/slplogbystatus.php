<?php 
require 'conn.php';
$qa=mysql_query("select concat('SLP',person_id) as SLPID,p_name,count(1) as counts from tbl_sponsorer sp join tbl_salesperson slp on slp.person_id=sp.sales_person_id group by p_name order by SLPID asc");
?>
<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid #ddd;
}
</style>
<table >
<tr>
	<th>#</th>
	<th>SLPID</th>
	<th>SLP NAME</th>
	<th>SPONSOR COUNT</th>	
</tr>
<?php 
$sr1=1;
while($re=mysql_fetch_assoc($qa)){
?>
<tr>
	<td><?php echo $sr1; ?></td>
	<td><?php echo $re['SLPID'];; ?></td>
	<td><?php echo $re['p_name']; ?></td>
	<td><?php echo $re['counts']; ?></td>
</tr>
<?php 
$sr1++;
}

?>
</table>
<hr/>
<?php 

$q=mysql_query("select concat('SLP',person_id) as SLPID,p_name,v_status, count(v_status) as counts from tbl_sponsorer sp join tbl_salesperson slp on slp.person_id=sp.sales_person_id group by p_name,v_status order by SLPID asc");
?>
<table >
<tr>
	<th>#</th>
	<th>SLPID</th>
	<th>SLP NAME</th>
	<th>SPONSOR STATUS</th>		
	<th>SPONSOR COUNT</th>		
	
</tr>
<?php 
$sr=1;
while($r=mysql_fetch_assoc($q)){
?>
<tr>
	<td><?php echo $sr; ?></td>
	<td><?php echo $r['SLPID'];; ?></td>
	<td><?php echo $r['p_name']; ?></td>
	<td><?php echo $r['v_status']; ?></td>		
	<td><?php echo $r['counts']; ?></td>
</tr>
<?php 
$sr++;
}
mysql_close();
?>
</table>
