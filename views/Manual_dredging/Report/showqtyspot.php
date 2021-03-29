<?php

//echo "asasasasas".$balanceton;

if($balanceton!=0){

						if($port_id==26)
						{
						?>

							 <option value="" selected="selected">select</option>
                        	 <option value="3">3</option>
                     		 <option value="5">5</option>
                        	 <option value="7">7</option>
                        	 <option value="10">10</option>
                        	 <option value="16">16</option>
                        	 <option value="18">18</option>
                        	 <option value="21">21</option>
                             <option value="25">25</option>                      	
                        <?php
						}
	 	             else if($port_id==16)
						{
						?>

							 <option value="" selected="selected">select</option>
                        	  <option value="3">3</option>
                     		  <option value="5">5</option>
                        	  <option value="7">7</option>
                        	  <option value="10">10</option>
                        	  <option value="12">12</option>
                        	  <option value="16">16</option> 
                        	  <option value="18">18</option>  
                        	  <option value="21">21</option>
                        	  <option value="25">25</option> 
                        	  <option value="30">30</option>                     	
                        <?php
						}
					else if($port_id==17 || $port_id==24)

						{?>
							<option value="" selected="selected">select</option>
                        	<option value="3">3</option>
					<?php }
                    else if($port_id==10 && ($zone_id==11 || $zone_id==12))

                        {?>
                            <option value="" selected="selected">select</option>
                            <option value="3">3</option>
                            <option value="5">5</option>
                             <option value="7">7</option>
                            <option value="10">10</option>
                            <option value="12">12</option>
                    <?php }
						else
						{
						?>
                        <option value="" selected="selected">select</option>
                        <option value="3">3</option>
                     	<option value="5">5</option>
                       
            		<?php 	}
}

else
{ 
	echo 1;
} ?>