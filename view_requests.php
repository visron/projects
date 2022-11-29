<?php
include 'header.php';
require_once('classes/ListDisplay.class.php');
$list = new listDisplay();
require_once('classes/Admins.class.php');
$admin = new Admin();
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Requests</a></li>
        <li class="active"><a href="#">All Trips</a></li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Requests</span>
                </div>
                <div><a href="new_request.php" class="btn btn-primary ajax-link">New Request</a>&nbsp;</div>
                </br>
                <div class="table-light-green">
                    <?php
                    $current_page = 1;
                    if (isset($_GET['page'])) {
                        $current_page = $_GET['page'];
                    }
                    $total_rows = $list->count_rows('requests', '');
                    $rows_per_page = 15;
                    $total_pages = $list->total_pages($total_rows, $rows_per_page);
                    $start_row = $list->page_to_row($current_page, $rows_per_page);
                    //$list->draw_pager("", $total_pages, $current_page); 
                    ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                        id="jq-datatables-example">
                        <thead>
                            <tr>
                                <th width="193">Name</th>
                                <th width="100">Number</th>
                                <th width="105">Time Ordered</th>
                                <th width="86">From</th>
                                <th width="86">To</th>
                                <th width="86">Status</th>

                                <th width="283">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_REQUEST['id'])) {
                                $id = $_REQUEST['id'];
                                $items = $list->paged_result('requests', "WHERE ID = '$id'");
                            } else {
                                $items = $list->paged_result('requests', "WHERE is_active <> 0");

                            }
                            $count = count($items);

                            if ($count == 0) {
                                echo 'No records';
                                $numRow = 0;
                            } else {
                                $conf = "if(confirm('Please confirm you want to delete this item')){ return true;}else{return false;}";
                                foreach ($items as $it) {
                                    $username = "Admin";
                            
                                    echo '<tr>
								<td>' . $it['Name'] . '</td>
								<td>' . $it['Number'] . '</td>
								<td class="center">' . date('D-M-Y: h:m:s', strtotime($it['Timestamp'])) . '</td>
								<td class="center">' . $it['Pickup'] . '</td>
								<td class="center">' . $it['Destination'] . '</td>
								<td class="center">' . $it['Status'] . '</td>
                                                                
								<td class="center">
									<a class="btn btn-info" href="edit_requests.php?id=' . $it['ID'] . '">
										<i class="fa fa-edit icon-white"></i>  
										Edit											
									</a>
									<a onClick="' . $conf . '" class="btn btn-danger" href="exec/requests-exec.php?tag=delete&id=' . $it['ID'] . '">
										<i class="fa fa-trash-o icon-white"></i> 
										Delete
									</a>
								</td>
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
            $('#jq-datatables-example_wrapper .table-caption').text('Tasks');
            $('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
        });
    </script>
</div>
</div>
<?php
include 'footer.php';
?>