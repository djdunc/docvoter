<?php //var_dump($votes); //var_dump($event_cards)?>
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
                            foreach ( $collection['categories'] as $cat_id=>$category){
                                foreach ($votes as $card) { //var_dump($card);
                                    $top = in_array($card->card_id,$top50)?"top50":"";
                                    $hide = in_array($card->card_id,$top50)?"":"style='display:none;'";
                                	$card_cat_id = (int)$card->category_tag_id;
                                	if ($card_cat_id == $cat_id){
                                	    $clean_cat = dirify($category);
                                	    echo("<li class='$top $clean_cat' $hide><a href='' id='$card->card_id' class='card' value='$card->total'>$card->card_title</a></li>");
                                	}
                                	//var_dump($votes[$card->id]);
                                }
                            }?>
        		       </ul>
        		       <?php } else { echo('<h3 class="content no-cap push-down">This event has no drivers to display.');}?>
    		     </div>
    		</div>
	    </div>
</div>
<br /><br />
<!-- Load the poshytip script -->
<script src="assets/js/poshytip-1.1/src/jquery.poshytip.min" type="text/javascript"></script>
<!--	Load the poshytip stylesheet. -->
<link rel="stylesheet" href="assets/js/poshytip-1.1/src/tip-twitter/tip-twitter.css" type="text/css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
    $('#category-nav li a').click(function(){
        if(!$(this).hasClass('active')) {
            $('#category-nav li a').removeClass('active');
            $(this).addClass('active');
            $('#vote-cloud li').hide();   
            var class_to_show = $(this).attr('id');
            $('#vote-cloud li.'+class_to_show).show();
            resizeCards('#vote-cloud li.'+class_to_show+' a');
        }
    });
    Array.max = function( array ){
        return Math.max.apply( Math, array );
    };
    Array.min = function( array ){
        return Math.min.apply( Math, array );
    };
    minSize =13;
    maxSize =38;
    function resizeCards(cards){
        var votes = [];
        $(cards).each(function () {
            votes.push(parseInt($(this).attr('value')));
        });
         // Pull out the minimum and maximum vote count from our tags. 
         //Creating a spread to be used in font size calculations. 
        var maxVote = Array.max(votes);
        var minVote = Array.min(votes);
        spread = maxVote-minVote;
        // Check to see if we have a good spread, if not, set one.
    	if (spread == 0) {
    		spread = 1;
    	}
        $(cards).each(function () {
            var val = $(this).attr('value');
            var txt='';
            if (val == 1) {
                txt = val+' vote';
            }else if (val == 0){
                txt = 'no votes';
            }else {
                var txt = val+' votes';
            }
            fontSize = minSize+(val-minVote)*(maxSize-minSize)/spread;
            $(this).css("fontSize",fontSize);
            $(this).poshytip({
                content: txt,
                className: 'tip-twitter',
                alignTo: 'target',
            	alignX: 'center',
            	alignY: 'bottom',
            	allowTipHover: false,
            	offsetY: 8,
                slide: false
            });
        });
    }
    resizeCards("#vote-cloud li a");
});
</script>