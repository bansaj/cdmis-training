<?php
// including the database connection file
include_once("config.php");

if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($conx, $_POST['id']);
    
    $household = mysqli_real_escape_string($conx, $_POST['household']);
    $population = mysqli_real_escape_string($conx, $_POST['population']);
    $male_population = mysqli_real_escape_string($conx, $_POST['male_population']);
    $female_population = mysqli_real_escape_string($conx, $_POST['female_population']);
    
    // checking empty fields
    if (empty($household) || empty($population) || empty($male_population) || empty($female_population)) {
        if (empty($household)) {
            echo "<font color='red'>Household field is empty.</font><br/>";
        }
        
        if (empty($population)) {
            echo "<font color='red'>Population field is empty.</font><br/>";
        }
        
        if (empty($male_population)) {
            echo "<font color='red'>Male population field is empty.</font><br/>";
        }
        if (empty($female_population)) {
            echo "<font color='red'>Female population field is empty.</font><br/>";
        }
    } else {
        //updating the table
        $result = mysqli_query($conx, "UPDATE statistics SET household='$household', male_population='$male_population', female_population='$female_population', population='$population' WHERE id=$id");
        
        //redirectig to the display page. In our case, it is index.php
        header("Location: index.php");
    }
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($conx, "SELECT * FROM statistics WHERE id=$id");

while ($res = mysqli_fetch_array($result)) {
    $household = $res['household'];
    $population= $res['population'];
    $male_population = $res['male_population'];
    $female_population = $res['female_population'];
}
?>
<html>
<head>	
	<title>Edit Data</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form1" method="post" action="edit.php">
		<table border="0">
			<tr> 
				<td>Household</td>
				<td><input type="number" name="household" value="<?php echo $household;?>"></td>
			</tr>
			<tr> 
				<td>Population</td>
				<td><input type="number" name="population" value="<?php echo $population;?>"></td>
			</tr>
			<tr> 
				<td>Male Population</td>
				<td><input type="number" name="male_population" value="<?php echo $male_population;?>"></td>
			</tr>
			<tr> 
				<td>Female Population</td>
				<td><input type="number" name="female_population" value="<?php echo $female_population;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
