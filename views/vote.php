<?php //var_dump($top50);?>
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_3">
    		       <ul id="category-nav">
    		           <li><a id="top50" class="active" href="">top 50</a></li><?php foreach($collection['categories'] as $cat_id=>$category){
                           if ($collection['name']=='steep' ){
                               $steepclass = $category."-to";
                     	    } else{
                     	       $steepclass = $category;
                     	    }
                     	    $clean_cat = dirify($category);
                           echo "<li><a href='' id='$clean_cat' class='$steepclass'>$category</a></li>";
                       } ?>
    		       </ul>
    		</div>
    		<div class="grid_1 align_right add-driver">
    				<a href="index.php?do=card&event=<?php echo $event->id?>" class="button blue large">+ add driver</a>
    		</div>
	    </div>
    </div>
</div>
<div class="container_4">
	    <div class="grid-wrap" class="clearfix">
    		<div class="grid_4">
    		    <div class="panel">
    		       <?php if (count($event_cards)){?>
    		       <ul id="vote-cloud">
                      <?php
                      $date_order_cards = array_reverse($event_cards);
                        foreach ( $collection['categories'] as $cat_id=>$category){
                            foreach ($date_order_cards as $card) {
                                $top = in_array($card->id,$top50)?"top50":"";
                                $hide = in_array($card->id,$top50)?"":"style='display:none;'";
                            	$card_cat_id = (int)$card->category_tag_id;
                            	if ($card_cat_id == $cat_id){
                            	    $clean_cat = dirify($category);
                            	    echo("<li class='$top $clean_cat' $hide><a href='' class='card' id='$card->id' alt='$card->name'>$card->name</a></li>");
                            	}
                            }
                        }?>
    		       </ul>
    		       <?php } else { echo('<h3 class="content no-cap push-down">This event has no drivers yet. <a href="index.php?do=card&event='.$event->id.'">+ add your driver here</a>.</h3>');}?>
    		     </div>
    		</div>
	    </div>
</div>
<br /><br />
<!-- Load the poshytip script -->
<script src="assets/js/poshytip-1.1/src/jquery.poshytip.min.js" type="text/javascript"></script>
<!--	Load the poshytip stylesheet. -->
<link rel="stylesheet" href="assets/js/poshytip-1.1/src/tip-twitter/tip-twitter.css" type="text/css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	var event_id=<?php echo $event->id;?>;
	var owner=<?php echo $_SESSION['user']->id;?>;
	//navigation
	$('#category-nav li a').click(function(){
        if(!$(this).hasClass('active')) {
            $('#category-nav li a').removeClass('active');
            $(this).addClass('active');
            $('#vote-cloud li').hide();   
            var class_to_show = $(this).attr('id');
            $('#vote-cloud li.'+class_to_show).show();
        }
    });
    //tooltip
    $('.card').poshytip({
        content: 'click to vote',
        className: 'tip-twitter',
        alignTo: 'target',
    	alignX: 'center',
    	alignY: 'bottom',
    	allowTipHover: false,
    	offsetY: 8,	
        slide: false
    });
    $(".card").click(function(){
        //voting stuff
        var currcard = $(this);
        if(!currcard.hasClass('voted')) {
        	//vote
        	var query_url = "includes/callAPI.php?action=vote/post&event_id="+event_id+"&owner="+owner+"&card_id="+$(this).attr('id');
            currcard.poshytip('update', 'sending...');
            $.ajax({
	            url: query_url,
	            success: function(data){/*... it worked*/
	                currcard.addClass('voted');
	                currcard.poshytip('update', 'click to cancel');
	            },
	            error: function(data){/*... it didn't: reverse tip*/
	                currcard.poshytip('update', 'click to vote');
	                currcard.poshytip('update', 'there was an error sending vote, please try again later',true);
	            }
	        });
        } else {
            //unvote
            var query_url = "includes/callAPI.php?action=vote/delete&event_id="+event_id+"&owner="+owner+"&card_id="+$(this).attr('id');
            currcard.poshytip('update', 'removing...');
        	$.ajax({
                url: query_url,
                success: function(data){/*... it worked*/
                       currcard.removeClass('voted');
                       currcard.poshytip('update', 'click to vote');
                    },
                error: function(data){/*... it didn't*/
                    currcard.poshytip('update', 'click to cancel');
                       currcard.poshytip('update', 'there was an error removing vote, please try again later',true);
                }
            });
        }
    });
});
</script>