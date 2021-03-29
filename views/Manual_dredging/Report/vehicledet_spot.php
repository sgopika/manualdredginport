<option value="">select</option>

<?php
if($lorrydet==1 && $portid==10)
{
    ?>

    <option value="1">Zone lorry</option>
    

    <?php

}
 else if($lorrydet==2 && $portid==10)
{
    ?>

    <option value="1">Zone lorry</option>
    <option value="2">KSMDCL lorry</option>
    

    <?php

}
 

else if(($lorrydet==1 || $lorrydet==2 )&& $portid!=10)
{
    ?>
    <option value="1">Zone lorry</option>
       <?php
    
}
else{?>
    <option value="1">Zone lorry</option>
    

    <?php
    }



?>