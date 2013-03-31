<STYLE type="text/css">
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>

<table>
	<tr>
		<td><b>Client, Survey Report (Still working on this -- Lee)<b></td>
	</tr>
	<tr>
		<td><b>Date:</b></td>
		<td><?php echo date("F j, Y, g:i a"); ?></td>
	</tr>
	<tr>
		<td></td>
	</tr>
		<tr id="titles">
			<td class="tableTd">First Name</td>
			<td class="tableTd">Last Name</td>
                        <td class="tableTd">Middle Name</td>
                        <td class="tableTd">Nickname</td>
                        <td class="tableTd">SSN</td>
                        <td class="tableTd">DOB</td>
                        <td class="tableTd">Phone Number</td>
                        <td class="tableTd">VI Score</td>
		</tr>		
		<?php foreach($rows as $row):
			echo '<tr>';
			echo '<td class="tableTdContent">'.$row['Client']['first_name'].'</td>';
			echo '<td class="tableTdContent">'.$row['Client']['last_name'].'</td>';
                        echo '<td class="tableTdContent">'.$row['Client']['middle_name'].'</td>';
                        echo '<td class="tableTdContent">'.$row['Client']['nickname'].'</td>';
                        echo '<td class="tableTdContent">'.$row['Client']['ssn'].'</td>';
                        echo '<td class="tableTdContent">'.$row['Client']['dob'].'</td>';
                        echo '<td class="tableTdContent">'.$row['Client']['phoneNumber'].'</td>';
                        echo '<td class="tableTdContent">'.$row['Client']['mostRecentViScore'].'</td>';
			echo '</tr>';
			endforeach;
		?>
</table>

