<?php //var_dump($_SESSION['user']);?>
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_3">
    		       <ul id="category-nav">
    		           <li><a class="active" href="">top 50</a></li>
    		           <?php 
    		           foreach ($collection['categories'] as $key=>$cat ){?>
    		               <li><a href="" <?php if ($collection['name']=='steep' ){ echo("class='".$cat."-to'");} ?>><?php echo $cat; ?></a></li>
    		           <?php } ?>
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
    		           function shuffle_assoc($list) { 
                         if (!is_array($list)) return $list; 

                         $keys = array_keys($list); 
                         shuffle($keys); 
                         $random = array(); 
                         foreach ($keys as $key) { 
                           $random[] = $list[$key]; 
                         }
                         return $random; 
                       }
    		           ?>
    		           <?php $cards= shuffle_assoc($data['event_cards']); foreach ($cards as $card) { //var_dump($card);?>
    		               
    		               <li><a href="" <?php echo 'class="card '.$data['steep'][$card->category_tag_id].'-b'.'"'; ?>><?php echo($card->name);?></a></li>
    		          <?php }?>
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
    $(".card").tipTip({defaultPosition:"right",maxWidth:"auto",content:"click to vote",delay:800});
<<<<<<< HEAD
=======
    $(".card").click(function(){
        //voting stuff
        if(!$(this).hasClass('voted')) {
        	//vote
        	var query_url = "includes/callAPI.php?action=vote/post&event_id="+event_id+"&owner="+owner+"&card_id="+$(this).attr('id');
            $(this).addClass('voted');
            $.ajax({
	            url: query_url,
	            success: function(data){/*uhm ... it worked*/},
	            error: function(data){/*... it didn't*/}
	        });
        } else {
            //unvote
            var query_url = "includes/callAPI.php?action=vote/delete&event_id="+event_id+"&owner="+owner+"&card_id="+$(this).attr('id');
        	$(this).removeClass('voted');
        	$.ajax({
                url: query_url,
                success: function(data){/*uhm ... it worked*/},
                error: function(data){/*... it didn't*/}
            });
        }
    });
>>>>>>> cb62e99d710ef3eb94e48abce556255162f2902b
});
</script>