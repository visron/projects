<?php
include 'header.php';
require_once('classes/ListDisplay.class.php');
$list = new listDisplay();
include_once('classes/Tasks.class.php');
$task = new Tasks();
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Trucks</a></li>
        <li class="active"><a href="#">All Trucks</a></li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Trucks</span>
                </div>
                <div><a href="new_project.php" class="btn btn-primary ajax-link">New Trucks</a>&nbsp;</div>
                </br>
                <div class="table-success">
                    <?php
                    $current_page = 1;
                    if (isset($_GET['page'])) {
                        $current_page = $_GET['page'];
                    }
                    $total_rows = $list->count_rows('project', ' WHERE P_STATUS = 1');
                    $rows_per_page = 15;
                    $total_pages = $list->total_pages($total_rows, $rows_per_page);
                    $start_row = $list->page_to_row($current_page, $rows_per_page);
                    //$list->draw_pager("", $total_pages, $current_page); 
                    ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                        <thead>
                            <tr>
                                <th width="193">Name</th>
                                <th width="100">Description</th>
                                <th width="105">Initiate </th>
                                <th width="86">Status</th>
                                <th width="86">Progress</th>
                                <th width="283">Actions</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php
                            $items = $list->paged_result( "project", " WHERE P_STATUS = 1",$start_row, $rows_per_page);
                            $count = count($items);

                            if ($count == 0) {
                                echo 'No records';
                                $numRow = 0;
                            } else {
                                $conf = "if(confirm('Please confirm you want to delete this item')){ return true;}else{return false;}";
                                foreach ($items as $it) {
                                    if ($it['P_STATUS'] == 1) {
                                        $activestate = "ACTIVE";
                                    } else {
                                        $activestate = "INACTIVE";
                                    }
                                   $sum= $task->getTasksSum($it['P_ID']);
                                   $count = $task->getTasksCount($it['P_ID']);
                                   $allcount= $count*100;
                                   $prog = 0;
                                   if($count>0){
                                   $prog = $sum/$count;
                                   }
                                   
                                    echo '<tr>                     <td>' . $it['P_NAME'] . '</td>
								<td>' . $it['P_DESC'] . '</td>
								<td class="center">' . date('d-m-Y', strtotime($it['P_INITIATE_TIME'])) . '</td>
								<td class="center">' . $activestate . '</td>
								<td class="center">' . $prog . '</td>
                                                                    
								<td class="center">
									<a class="btn btn-warning" href="tasks.php?id=' . $it['P_ID'] . '">
										<i class="fa fa-eye icon-white"></i>  
										View											
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
