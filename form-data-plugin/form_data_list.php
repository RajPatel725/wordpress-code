<?php
echo "<div style='padding: 15px;'> Welcome Raj";

global $wpdb;
global $table_prefix;
$table_name = $wpdb->prefix . 'form_data';
$sql = "select * from $table_name;";
$result = $wpdb->get_results($sql);

// print_r($result);
?>
<style>
    table {
        margin-top: 1rem;
        border: 1px solid;
        padding: 15px;
    }

    table td {
        border: 1px solid;
        padding: 5px 10px;
    }
</style>
<table>
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Contact No</td>
        <td>Massage</td>
    </tr>

    <?php
    foreach ($result as $list) { ?>
        <!-- echo $list; -->
        <tr>
            <td><?php echo $list->id; ?></td>
            <td><?php echo $list->name; ?></td>
            <td><?php echo $list->contact; ?></td>
            <td><?php echo $list->massage; ?></td>
        </tr>
    <?php } ?>
</table>

<?php
echo '</div>';

