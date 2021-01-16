<?php
  include_once("config.php");

if (isset($_POST['Submit'])) {
    $municipality = mysqli_real_escape_string($conx, $_POST['municipality']);
    $ward = mysqli_real_escape_string($conx, $_POST['ward']);
    $household = mysqli_real_escape_string($conx, $_POST['household']);
    $population = mysqli_real_escape_string($conx, $_POST['population']);
    $male_population = mysqli_real_escape_string($conx, $_POST['male_population']);
    $female_population = mysqli_real_escape_string($conx, $_POST['female_population']);
        
    // checking empty fields
    if (empty($municipality) ||empty($ward) ||empty($household) || empty($population) || empty($male_population) || empty($female_population)) {
        if (empty($municipality)) {
            echo "<font color='red'>Municipality field is empty.</font><br/>";
        }
        if (empty($ward)) {
            echo "<font color='red'>Ward field is empty.</font><br/>";
        }
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
        // if all the fields are filled (not empty)
            
        //insert data to database
        $statics_query = "INSERT INTO statistics(population, male_population, female_population, household, ward_id)
        VALUES(
          '$population',
          '$male_population',
          '$female_population',
          '$household' ,
          (select id from ward where title='$ward' and municipality_id = '$municipality')
        )";
        $result = mysqli_query($conx, $statics_query);
        
        //display success message
        echo "<font color='green'>Data added successfully.";
        echo "<br/><a href='index.php'>View Result</a>";
        exit;
    }
}
?>

<?php
  $municipality_query = "SELECT id, title from municipality";
  $municipality_result = mysqli_query($conx, $municipality_query);
?>
<html>
  <head>
    <title>Add Data</title>
  </head>

  <body>
    <a href="index.php">Home</a>
    <br /><br />

    <form action="add.php" method="post" name="Submit">
      <table width="25%" border="0">
        <tr>
          <td>Municipality</td>
          <td>
              <select name="municipality">
              <?php
                  while ($res = mysqli_fetch_array($municipality_result)) {
                      echo "<option value=".$res["id"].">".$res["title"]."</option>";
                  }
              ?>
              </select>
          </td>
        </tr>
        <tr>
          <td>Ward</td>
          <td><input type="number" name="ward" /></td>
        </tr>
        <tr>
          <td>Household</td>
          <td><input type="number" name="household" /></td>
        </tr>
        <tr>
          <td>Population</td>
          <td><input type="number" name="population" /></td>
        </tr>
        <tr>
          <td>Male Population</td>
          <td><input type="number" name="male_population" /></td>
        </tr>
        <tr>
          <td>Female Population</td>
          <td><input type="number" name="female_population" /></td>
        </tr>

        <tr>
          <td></td>
          <td><input type="submit" name="Submit" value="Add" /></td>
        </tr>
      </table>
    </form>
  </body>
</html>

