<td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $sixqty=$this->look_up_model->get_monthlyqty($row->product_id,$sixmonth)
                       ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $fiveqty=$this->look_up_model->get_monthlyqty($row->product_id,$fivemonth); ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $fourqty=$this->look_up_model->get_monthlyqty($row->product_id,$fourmonth); ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $threeqty=$this->look_up_model->get_monthlyqty($row->product_id,$threemonth); ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $twoqty=$this->look_up_model->get_monthlyqty($row->product_id,$twomonth); ?></td>
                    <td style="text-align:center;<?php echo $color; ?>">
                      <?php echo $oneqty=$this->look_up_model->get_monthlyqty($row->product_id,$onemonth); ?></td>
                    <td style="vertical-align: text-top;text-align:center;<?php echo $color; ?>">
                      <?php  echo $sixqty+$fiveqty+$fourqty+$threeqty+$twoqty+$oneqty; ?></td>