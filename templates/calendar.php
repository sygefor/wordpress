<script>
    var sessions = <?php echo json_encode($sessions); ?>;
    var trainingLink = <?php echo json_encode(get_page_link(get_option("sygefor3_training_page")));?>;
    var theme = <?php echo json_encode(stripslashes($_GET['theme'])); ?>;
</script>

<div id='calendar'></div>