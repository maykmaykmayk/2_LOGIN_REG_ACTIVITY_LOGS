<?php 
require_once "core/dbConfig.php";
require_once "core/models.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Job Application</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
    <body>
        <h2>Grisola Law Firm Applicant Editing Page</h2>

        <input type="submit" value="Return to homepage" onclick="window.location.href='index.php'">
        <br><br>

        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>

        <h2 style="color: red;"> DELETE THIS APPLICATION? </h2>

        <table>
            <tr>
                <th>Applicant ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Email Address</th>
                <th>Contact Number</th>
                <th>Date Added</th>
            </tr>

            <?php $applicantData = getApplicantByID($pdo, $_GET['applicantID'])['querySet']; ?>
            <tr>
                <td><?php echo $applicantData['applicantID']?></td>
                <td><?php echo $applicantData['first_name']?></td>
		        <td><?php echo $applicantData['last_name']?></td>
                <td><?php echo $applicantData['age']?></td>
                <td><?php echo $applicantData['gender']?></td>
                <td><?php echo $applicantData['email']?></td>
                <td><?php echo $applicantData['contact_info']?></td>
                <td><?php echo $applicantData['date_added']?></td>
            </tr>
        </table>

        <form action="core/handleForms.php?applicantID=<?php echo $_GET['applicantID']; ?>" method="POST">
            <input type="submit" name="deleteApplicantBtn" value="Delete applicant">
            <input type="submit" value="Cancel" onclick="window.location.href='index.php'">
        </form>
    </body>
</html>