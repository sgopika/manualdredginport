<?php 
if(!empty($buk_data))
{
 ?>
<td  style="color: #1816AC;font-weight: bold; font-size: 12;">Balance Ton :-</td>
<td style=" font-size: 12; color: #1816AC;font-weight: bold;"><?php foreach($buk_data as $sp)
				 { echo $sp['daily_log_balance']; }?></td>
<?php
}
else
{?> 
<td></td><td></td>
<?php
}
?>