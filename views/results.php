<?php //var_dump($event);?>
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_3">
    		       <ul id="category-nav">
       		           <li><a id="top50" class="active" href="">top 50</a></li>
                          <?php foreach($collection['categories'] as $cat_id=>$category){
                              if ($collection['name']=='steep' ){
                                  $steepclass = $category."-to";
                        	    }
                              echo "<li><a href='' id='$category' class='$steepclass'>$category</a></li>";
                          } ?>
       		       </ul>
    		</div>
    		<div class="grid_1 align_right">
    				
    		</div>
	    </div>
    </div>
</div>
<div class="container_4">
	    <div class="grid-wrap" class="clearfix">
    		<div class="grid_4">
    		    <div class="panel">
    		        <ul id="vote-cloud">
                          <?php
                            foreach ( $collection['categories'] as $cat_id=>$category){
                                foreach ($event_cards as $card) { //var_dump($card);
                                    $top = in_array($card->id,$top50)?"top50":"";
                                    //$hide = in_array($card->id,$top50)?"":"style='display:none;'";
                                    if ($collection['name']=='steep' ){
                                          $steepclass = $category.'-b';
                                	} else{
                                	    $steepclass='';
                                	}
                                	$card_cat_id = (int)$card->category_tag_id;
                                	if ($card_cat_id == $cat_id){
                                	    $clean_cat = dirify($category);
                                	    echo("<li class='$top $clean_cat'><a href='' id='$card->id' class='card'>$card->name</a></li>");
                                	}
                                }
                            }?>
        		       </ul>
    		     </div>
    		</div>
	    </div>
</div>
<br /><br />
<!-- Load the tiptip script -->
<script src="assets/js/tipTipv13/jquery.tipTip.minified.js" type="text/javascript"></script>
<!--	Load the tiptip stylesheet. -->
<link rel="stylesheet" href="assets/js/tipTipv13/tipTip.css" type="text/css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
    $('#category-nav li a').click(function(){
        if(!$(this).hasClass('active')) {
            $('#category-nav li a').removeClass('active');
            $(this).addClass('active');
            $('#vote-cloud li').hide();   
            var class_to_show = $(this).attr('id');
            $('#vote-cloud li.'+class_to_show).show();
        }
    });
});
</script>