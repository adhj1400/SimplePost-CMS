<?php 
/**
 * Prints users to a table.
 *
 */
include('includes/sp-header.php');
include('includes/sp-topbar.php');
include('includes/sp-sidebar.php'); ?>

<div class="container">
	<div class="row">
		<form action="includes/sp-create_user.php" method="post" >
			<input class="button" type="submit" name="AddUser" value="Add user"/>
		</form>
	</div>
	
	<div class="row">
		<div class="wide-table">
			<div class="inner-box">
				<div class="title-box">Users</div>
				
				<div id="content-grid">
					<table cellspacing="0">
						<col width="10">
  						<col width="20%">
  						<col width="100%">

						<thead>
							<tr class="toprow">
								<td class="column">Avatar</td>
								<td class="column">Username</td>
								<td class="column">Alias</td>
							</tr>
						</thead>

						<tbody>
						<?php
						// Get database entries
						$sql = "SELECT * FROM users";
						$result = $database->query($sql);

						// For each user, print to table
						foreach($result['rows'] as $row)
				      	{
				      		// Set image variables
					      	$trClass;
					      	$userImgSrc = 'resources/sp-core-resources/defaultuser.png';
					      	$imgFormat = "data:image/jpeg;base64,";

					      	if ($row['profileimage'] != null)
				            {
					        	$userImgSrc = $imgFormat . base64_encode(
					        		$row['profileimage']);
					        }

					        if (strcasecmp($row['username'], 
					         	$_SESSION["login_user"]) == 0)  // if user
					        {
					        	$trClass = "wide-focused";
					        }
				            else
				            {
				            	$trClass = "wide";
				            } ?>
				            
				            <!-- User -->
				        	<tr class="<?= $trClass; ?>">
					            <td class='wide'>
						        	<img class='table' src='<?= $userImgSrc; ?>'/>
					       		</td>

				            	<td class='wide'><?= $row['username']; ?></td>
					        	<td class='wide'><?= $row['alias']; ?></td>
					        </tr> <?php
				        } ?>
						</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>
</div>

<!-- End of Content -->
<?php include('includes/sp-footer.php'); ?>
