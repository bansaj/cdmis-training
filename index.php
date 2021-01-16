<?php
include_once("config.php");


$statistics_query = "SELECT
	s.id AS ID,
	d.title as district_title,
	m.title as municipality_title,	
	w.title as ward_title,
	s.household AS Household,
	s.population AS Population,
	s.male_population AS Male_population,
	s.female_population AS Female_population
FROM
	statistics AS s
INNER JOIN ward AS w ON s.ward_id = w.id
INNER JOIN municipality as m on w.municipality_id = m.id
INNER JOIN district as d on m.district_id = d.id
order by s.id asc";
$statistics_result = mysqli_query($conx, $statistics_query);
?>

<html>
<head>
  <title>CDMIS Butwal</title>
</head>

<body>
<a href="add.php">Add New Data</a><br/><br/>
	<table width='80%' border=0>
	<tr bgcolor='#CCCCCC'>
		<td>S.N.</td>
		<td>District</td>
		<td>Municipality</td>
		<td>Ward</td>
		<td>Household</td>
		<td>Population</td>
		<td>Male Population</td>
		<td>Female Population</td>
		<td>Update</td>
	</tr>
	<?php
    //while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array
    while ($res = mysqli_fetch_array($statistics_result)) {
        echo "<tr>";
        echo "<td>".$res["ID"]."</td>";
        echo "<td>".$res['district_title']."</td>";
        echo "<td>".$res['municipality_title']."</td>";
        echo "<td>".$res['ward_title']."</td>";
        echo "<td>".$res['Household']."</td>";
        echo "<td>".$res['Population']."</td>";
        echo "<td>".$res['Male_population']."</td>";
        echo "<td>".$res['Female_population']."</td>";
        echo "<td><a href=\"edit.php?id=$res[ID]\">Edit</a> | <a href=\"delete.php?id=$res[ID]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
    }
    ?>
	</table>
</body>
</html>
