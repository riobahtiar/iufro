<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';
$euser_barcode = $_GET['brcd'];
global $wpdb;
$query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$euser_barcode}'";
$user_detail = $wpdb->
    get_row($query, ARRAY_A);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title></title>
    <link href="<?php echo plugins_url(); ?>/ss-event-dates/assets/bootstrap.min.css" rel="stylesheet">
    </head>
    <body style="padding: 17px">
        <!-- User Changer -->
        <p class="bg-primary">
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" type="post">
                <h4>
                    User Type Changer
                </h4>
                <input name="do_model" type="hidden" value="do_membership">
                    <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                        <div class="form-group">
                            <label for="user_type">
                                User Type
                            </label>
                            <select class="form-control" name="user_type">
                                <option value="free_type">
                                    Free
                                </option>
                                <option value="participant_type">
                                    Participant
                                </option>
                                <option value="author_type">
                                    Author
                                </option>
                            </select>
                        </div>
                        <button class="btn btn-primary" type="submit">
                            Change
                        </button>
                    </input>
                </input>
            </form>
        </p>
        <!-- User Changer -->
<hr>
        <?php if ($user_detail['euser_doc_status'] == null) {?>
        <h4>
            Document Status:
            <strong>
                Unverified
            </strong>
        </h4>
        <!--  Approved -->
        <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_process.php'; ?>" type="post">
            <input name="do_model" type="hidden" value="do_doc_approved">
                <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                    <button class="btn btn-primary" type="submit">
                        Approved
                    </button>
                </input>
            </input>
        </form>
        <br>
            <!--  Rejected -->
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_process.php'; ?>" type="post">

                <input name="do_model" type="hidden" value="do_doc_rejected">
                <textarea class="form-control" rows="3" placeholder="Reason for rejection" name="reason"></textarea>
                    <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                        <button class="btn btn-danger" type="submit">
                            Rejected
                        </button>
                    </input>
                </input>
            </form>
            <?php } elseif ($user_detail['euser_doc_status'] == 'approved') {?>
            <h4>
                Document Status:
                <strong>
                    Approved
                </strong>
            </h4>
            <div class="well">
                Make sure you are allowed to show this document to the public (Free User).
            </div>
            <!-- Published -->
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_process.php'; ?>" type="post">
                <input name="do_model" type="hidden" value="do_doc_publish">
                    <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                        <button class="btn btn-primary" type="submit">
                            Publish
                        </button>
                    </input>
                </input>
            </form>
            <?php } elseif ($user_detail['euser_doc_status'] == 'published') {?>
            <h4>
                Document Status:
                <strong>
                    Published
                </strong>
            </h4>
            <div class="well">
                To stop publishing the document. press the button below
            </div>
            <!-- Stop Publish -->
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_process.php'; ?>" type="post">
                <input name="do_model" type="hidden" value="do_doc_unpublish">
                    <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                        <button class="btn btn-danger" type="submit">
                            Un-Publish
                        </button>
                    </input>
                </input>
            </form>
            <?php } elseif ($user_detail['euser_doc_status'] == 'rejected') {?>
            <h4>
                Document Status:
                <strong>
                    Rejected
                </strong>
            </h4>
            <div class="well">
               If you have made a mistake, the button below can re-approve the rejected member.
            </div>
            <!--  Approved -->
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_process.php'; ?>" type="post">
                <input name="do_model" type="hidden" value="do_doc_approved">
                    <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                        <button class="btn btn-danger" type="submit">
                            Approved
                        </button>
                    </input>
                </input>
            </form>
            <?php } elseif ($user_detail['euser_doc_status'] == 'unpublished') {?>
            <h4>
                Document Status:
                <strong>
                    Unpublished
                </strong>
            </h4>
            <div class="well">
               If you have made a mistake, the button below can re-publish the document.
            </div>
			<form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_process.php'; ?>" type="post">
                <input name="do_model" type="hidden" value="do_doc_publish">
                    <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                        <button class="btn btn-primary" type="submit">
                            Publish
                        </button>
                    </input>
                </input>
            </form>
            <?php } else { ?>
            	<strong>Something was wrong, contact Sys Administrator</strong>
            <?php }?>
        </hr>
    </body>
</html>
