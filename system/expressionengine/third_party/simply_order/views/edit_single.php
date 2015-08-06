<h1>Drag and drop entries from the left hand side to the right hand side.</h1>

<script type="text/javascript">
    function maurizio(){
	var order = $("#sortable2").sortable("serialize");
	return order;
    };
    
    $(document).ready(function(){
	$(function() {
	    $("#sortable1, #sortable2").sortable({ 
		opacity: 0.6,
		cursor: 'move',
		connectWith: ".connectedSortable",
		start: function( event, ui ){
			console.log($('#sortable2').height()+60);
			$('#sortable2').height($('#sortable2').height()+60);
		},
		stop: function( event, ui ){
			$('#sortable2').removeAttr('style');
		}
	    });
	});
		
    });
</script>
<h3>Current entries in the channel:</h3>

<ul id="sortable1" class="connectedSortable">
    <li class="ui-state-default">Entries you have:</li>
    <?php foreach ($entries->result_array() as $single_one) {
    	$hide = false;
    if (isset($old_entries) && $old_entries) {
    	    foreach ($old_entries->result_array() as $old_entry) {
    	    	if(strcmp ($old_entry['entry_id'], $single_one['entry_id'])==0){
    	    		$hide = true;
    	    	}
    	    }
	} 
	if($hide != true){
	?>

        <li id="entry_id_<?php echo $single_one['entry_id']; ?>" class="ui-state-default">
	    <?php 
	    echo form_hidden('entry_id', $single_one['entry_id']);
	    echo form_input('title', $single_one['title'], 'readonly');
	    ?>
        </li>
    <?php }
} ?>
</ul>

<?php 
$attributes = array(
    'id' => 'ordering',
);
echo form_open($form_action, $attributes);
?>
<fieldset><legend>Drag and drop elements here:</legend>
    <input type="hidden" name="site_id" value="<?php echo $site_id; ?>"/>
    <input type="hidden" name="id_simply" value="<?php echo $id_simply; ?>"/>
    <ul id="sortable2" class="connectedSortable">
	<?php 
	if (isset($old_entries) && $old_entries) {
	    foreach (array_reverse($old_entries->result_array()) as $old_entry) {
		?>
	        <li id="entry_id_<?php echo $old_entry['entry_id']; ?>" class="ui-state-default">
		    <?php 
		    echo form_hidden('entry_id', $old_entry['entry_id']);
		    echo form_input('title', $old_entry['title'], 'readonly');
		    ?>
	        </li>

	    <?php }
	} ?>
    </ul>

    <input type="hidden" id="entry_order" name="entry_order" value="" />

    <input type="submit" name="submit" value="Submit" class="submit" onclick="document.getElementById('entry_order').value=maurizio()">
</fieldset>
<?php echo form_close(); ?>