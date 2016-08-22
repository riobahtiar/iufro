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

<div class="well">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#membership" aria-controls="membership" role="tab" data-toggle="tab">Membership</a></li>
    <li role="presentation"><a href="#document" aria-controls="document" role="tab" data-toggle="tab">Documents Status</a></li>
    <li role="presentation"><a href="#files" aria-controls="files" role="tab" data-toggle="tab">Abstract</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="membership">
        <!-- User Changer -->
        <p class="user-changer">
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" method="post">
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
        <!-- end User Changer -->        

    </div>
    <div role="tabpanel" class="tab-pane" id="document">
<!-- Document Moderation Changer --> 
        <?php if ($user_detail['euser_doc_status'] == null) {?>
        <h4>
            Document Status:
            <strong>
                Unverified
            </strong>
        </h4>
        <!--  Approved -->
        <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" method="post">
            <input name="do_model" type="hidden" value="do_doc_approved">
            <p>Approve Document? </p>
            <textarea class="form-control" rows="3" placeholder="Reason.." name="reason"></textarea>
            <br>
                <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                    <button class="btn btn-primary" type="submit">
                        Approve
                    </button>
                </input>
            </input>
        </form>
        <br>
            <!--  Rejected -->
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" method="post">

                <input name="do_model" type="hidden" value="do_doc_rejected">
                <p>Reject Document? </p>
                <textarea class="form-control" rows="3" placeholder="Reason.." name="reason"></textarea>
                <br>
                    <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                        <button class="btn btn-danger" type="submit">
                            Reject
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
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" method="post">
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
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" method="post">
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
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" method="post">
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
            <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" method="post">
                <input name="do_model" type="hidden" value="do_doc_publish">
                <input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
                        <button class="btn btn-primary" type="submit">
                            Publish
                        </button>

            </form>
            <?php } else { ?>
                <strong>Something was wrong, contact Sys Administrator</strong>
            <?php }?>
<!-- end Document Moderation Changer --> 
    </div>
    <div role="tabpanel" class="tab-pane" id="files">

<!-- Abstract Revision --> 
<form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_option_process.php'; ?>" method="post" enctype="multipart/form-data">
<input name="do_model" type="hidden" value="do_abstract_revision">
<input name="barcode" type="hidden" value="<?php echo $euser_barcode; ?>">
<div class="form-group">
    <label for="abstract">Upload revised abstract</label>
    <input type="file" name="abstract" id="abstract">
    <p class="help-block">for publication only pdf file</p>
</div>
<input type="submit" name="submit" class="btn btn-default">
</form>
<!-- Abstract Revision --> 
    
    </div>
  </div>

</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
