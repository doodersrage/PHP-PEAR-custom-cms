<style>
.row2
{
	background-color:#FFFFFF;
}
</style>
<TABLE style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px" width="100%" border="0"><?php
echo $stcolumn;
$RowIndex     =     0;
for($i=0;  $i<sizeof($Data);$i++){
$RowIndex++;
if ($RowIndex == 2) $RowIndex = 0;
	$Css          =     $RowIndex == 1 ? 'table_even' : 'row2';
	?>
     <TR class="<?php echo $Css;?>"><?php
		foreach ( $Data[$i] as $Dat) {?>
          	<TD>&nbsp;<?php echo $Dat;?></TD>
		<?php } ?>
     </TR><?php
}?>	
</TABLE>
