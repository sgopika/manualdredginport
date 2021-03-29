
<meta content="text/html; charset=utf-8" >
<head>

<style>
</style>
</head>
<body >

<?php 
 	error_reporting(0);
 
        $attributes = array("class" => "form-horizontal", "id" => "mastertable_print", "name" => "mastertable_print"); 	
?>
		


<div align="center"  style="font-size:22px;">KIV SURVEY MASTER TABLES</div>
<br/>
<div align="left"  style="font-size:14px;"><strong>Appendix 1</strong></div>
<div align="left"  style="font-size:14px;"><strong>Name:</strong> KIV Survey Master Table Data List</div>
<div align="left"  style="font-size:14px;"><strong>Total Number of Tables:</strong> <?php echo $numberof_tables; ?> </div>
<br>
<table border="0" style="none; ">

<!--<table align="center" class="table table-striped table-bordered table-hover" cellspacing="2" border="0"   style=" border-collapse: none; "   >--> <!--cellpadding="4"-->

<!--<tr>
<td colspan="4" align="center"><img src="<?php echo base_url('assets/images/gov-icon.png');?>" alt=""></td>
</tr>


<tr>
  <td  colspan="4"  style="font-size:16px;">Appendix 1</td>
</tr>

<tr>
  <td  colspan="4"  style="font-size:16px;">Name: KIV Survey Master Table Data List</td>
</tr>

<tr>
  <td  colspan="4"  style="font-size:16px;">Total Number of Tables: <?php echo $numberof_tables; ?> </td>
</tr>
-->
<?php $i=1; foreach($mastertable as $master_table){ 
$table_name=$master_table['mastertable_name'];

$helper_table=$this->Master_model->get_specific_table($table_name);

//not to list user and user type table
if($table_name!='kiv_user_master' && $table_name!='kiv_user_type_master'){
?>

<tr>
<td style="font-size:16px;"><strong><?php echo $i.". ".$master_table['mastertable_mal_name']." (".$master_table['mastertable_name'].")";?>
</strong></td>
</tr>
<?php } ?>
<tr>
<td>
<table allign="left" border="1" cellspacing="10" cellpadding="6" style="border-collapse: collapse;">

<!------------------------------------------table data starts----------------------------------->

<?php 
$tab_det_heading	= explode('_',$table_name);
$tab_head_val		= $tab_det_heading[1];
if($tab_head_val!="user"){
?>

<tr>
  <td style="font-size:12px;">Sl No</td>
  <td style="font-size:12px;"><?php echo ucfirst($tab_head_val); ?> Name</td>
  <td style="font-size:12px;"><?php echo ucfirst($tab_head_val); ?> Code</td>
  <td style="font-size:12px;"><?php echo ucfirst($tab_head_val); ?> Status</td>
</tr>
<?php if(count($helper_table)==0){ ?>
<tr>
  <td style="font-size:12px;"><?php echo "-"; ?></td>
  <td style="font-size:12px;"><?php echo "-"; ?></td>
  <td style="font-size:12px;"><?php echo "-"; ?></td>
  <td style="font-size:12px;"><?php echo "-"; ?></td>
</tr>
<?php } ?>


<?php foreach($helper_table as $table){

$tab_det	= explode('_',$table_name);
$tab_det_val	= $tab_det[1];
$tab_det_val2	= $tab_det[2];

if($tab_det_val2 != "master"){$tab_det_val=$tab_det_val."_".$tab_det_val2;}

$tab_sl=$tab_det_val."_sl";
$sl	= $table[$tab_sl];

$tab_name=$tab_det_val."_name";
$name	= $table[$tab_name];

$tab_code=$tab_det_val."_code";
$code	= $table[$tab_code];

$tab_status=$tab_det_val."_status";
$status	= $table[$tab_status];
?>


<tr>
  <td style="font-size:12px;"><?php echo $sl;if($sl==''){echo "-";} ?></td>
  <td style="font-size:12px;"><?php echo $name;if($name==''){echo "-";} ?></td>
  <td style="font-size:12px;"><?php echo $code;if($code==''){echo "-";} ?></td>
  <td style="font-size:12px;"><?php echo $status;if($status==''){echo "-";} ?></td>
</tr>
<?php } }?>
<!-------------------------------------------table data end--------------------------------------->


</table> 
</td>
</tr>
<br>
<?php $i++; } ?> 

</table>

</body>
