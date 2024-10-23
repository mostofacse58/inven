<div class="right-content-show">
    <div class="body-of-content">
       <article class="niceBg">
           <h2 class="uk-heading-bullet"><?php echo $info->title; ?></h2>
           <p>
            <?php echo $info->description; ?>
           </p>
            
            <?php if (isset($info->file_1) && !empty($info->file_1)) { ?>
            <p>
            <b>Step 1:</b> 
           </p>
           <img src="<?php echo base_url();?>sop/<?php echo $info->file_1; ?>">
           <?php } ?>
             <?php if (isset($info->file_2) && !empty($info->file_2)) { ?>
            <p>
            <b>Step 2:</b> 
           </p>
           <img src="<?php echo base_url();?>sop/<?php echo $info->file_2; ?>">
           <?php } ?>
           <?php if (isset($info->file_3) && !empty($info->file_3)) { ?>
            <p>
            <b>Step 3:</b> 
           </p>
           <img src="<?php echo base_url();?>sop/<?php echo $info->file_3; ?>">
           <?php } ?>
       </article>
    </div>
</div>