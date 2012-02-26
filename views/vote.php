<?php //var_dump($top50);?>
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_3">
    		       <ul id="category-nav">
    		           <li><a id="top50" class="active" href="">top 50</a></li>
                       <?php foreach($collection['categories'] as $cat_id=>$category){
                           if ($collection['name']=='steep' ){
                               $steepclass = $category."-to";
                     	    } else{
                     	       $steepclass='';
                     	    }
                     	    $clean_cat = dirify($category);
                           echo "<li><a href='' id='$clean_cat' class='$steepclass'>$category</a></li>";
                       } ?>
    		       </ul>
    		</div>
    		<div class="grid_1 align_right">
    				<a href="index.php?do=driver" class="button blue large">+ add driver</a>
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
<script src="assets/js/indyone-TipTip-06dc274/jquery.tipTip.minified.js" type="text/javascript"></script>
<!--	Load the tiptip stylesheet. -->
<link rel="stylesheet" href="assets/js/indyone-TipTip-06dc274/tipTip.css" type="text/css" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
	var event_id=<?php echo $event->id;?>;
	var owner=<?php echo $_SESSION['user']->id;?>;
	$('#category-nav li a').click(function(){
        if(!$(this).hasClass('active')) {
            $('#category-nav li a').removeClass('active');
            $(this).addClass('active');
            $('#vote-cloud li').hide();   
            var class_to_show = $(this).attr('id');
            $('#vote-cloud li.'+class_to_show).show();
        }
    });
    function votedStatus(elem){
        var title = 'hi';
        return title;
    }
    $(".card").tipTip({defaultPosition:"right",maxWidth:"auto",cssClass:"alternative",
        content:function() {
        if(!$(this).hasClass('voted')) {
    		  return('click to vote');
    	} else {
    	     return('click to remove vote');
    	}}
    	});
    $(".card").click(function(){
        //voting stuff
        var currcard = $(this);
        if(!currcard.hasClass('voted')) {
        	//vote
        	var query_url = "includes/callAPI.php?action=vote/post&event_id="+event_id+"&owner="+owner+"&card_id="+$(this).attr('id');
            //$(this).tipTip({content:"click to unvote"});
            $.ajax({
	            url: query_url,
	            success: function(data){/*uhm ... it worked*/
	                currcard.addClass('voted');
	                currcard.tipTip('hide');
                    currcard.tipTip('show');
	            },
	            error: function(data){/*... it didn't*/}
	        });
        } else {
            //unvote
            var query_url = "includes/callAPI.php?action=vote/delete&event_id="+event_id+"&owner="+owner+"&card_id="+$(this).attr('id');
        	$.ajax({
                url: query_url,
                success: function(data){/*uhm ... it worked*/
                       currcard.removeClass('voted');
                       currcard.tipTip('hide');
                       currcard.tipTip('show');
                    },
                error: function(data){/*... it didn't*/}
            });
        }
    });
});
</script>