<?php
@session_start();
require_once('classes/ListDisplay.class.php');
$list = new listDisplay();
 include_once('header.php'); ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">User Management</a></li>
        <li class="active"><a href="#">System Users</a></li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">System Users</span>
                </div>
                <div><a href="new_user.php" class="btn btn-primary ajax-link">New User</a>&nbsp;</div>
                </br>
                <div class="table-warning">
                    <?php
                    $current_page = 1;
                    if (isset($_GET['page'])) {
                        $current_page = $_GET['page'];
                    }
                    $total_rows = $list->count_rows('users', ' WHERE U_STATUS = 1');
                    $rows_per_page = 15;
                    $total_pages = $list->total_pages($total_rows, $rows_per_page);
                    $start_row = $list->page_to_row($current_page, $rows_per_page);
                    //$list->draw_pager("", $total_pages, $current_page); 
                    ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                        <thead>
                            <tr>
                                <th width="193">Name</th>
                                <th width="100">Username</th>
                                <th width="283">Email</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php
                            $items = $list->paged_result('users', ' WHERE U_STATUS = 1');
                            $count = count($items);

                            if ($count == 0) {
                                echo 'No records';
                                $numRow = 0;
                            } else {
                                $conf = "if(confirm('Please confirm you want to delete this item')){ return true;}else{return false;}";
                                foreach ($items as $it) {

                                    echo '<tr>
								<td>' . $it['U_NAME'].'</td>
								<td>' . $it['U_FNAME'] . '</td>
								<td>' . $it['U_EMAIL'] . '</td>
								
							</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        init.push(function () {
            $('#jq-datatables-example').dataTable();
            $('#jq-datatables-example_wrapper .table-caption').text('Users');
            $('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
        });
    </script>
</div>
</div>
<?php include_once('footer.php'); ?>