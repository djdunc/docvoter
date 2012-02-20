[EVENT]

EDIT OR CREATE IF NO EVENT IS SET

<?php //var_dump($collections);?>

<script type="text/javascript">
$.ajax("includes/callAPI?action=event/get&id=3", {
    success: function(data){
        var data; try { data = $.parseJSON(data); } catch (err) { data = data; }

        //do stuff with data here
        //data either contains requested object or error string
        console.log(data);
        
    },
    error: function(data){ /*console.log(data);*/ }
});
</script>