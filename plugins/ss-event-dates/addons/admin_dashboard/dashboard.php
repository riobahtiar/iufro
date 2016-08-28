<?php
// Function to get all value for report page //

global $wpdb;
// gunung kidul
$gkidul_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "gunung-kidul"' );
// Klaten
$klaten_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "klaten"' );
// Mount Merapi
$merapi_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "mount-merapi"' );
// Pekanbaru Single
$pekanbaru_single_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pekanbaru_single"' );
// Pekanbaru Shared
$pekanbaru_shared_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pekanbaru_shared"' );
// Pacitan
$pacitan_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pacitan"' );
// Dinner 
$dinner_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_dinner = "Yes"' );
// all users
$all_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail' );
// attender
$attender = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_onsite_absence = "present"' );
// Paid
$paid = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_payment_status = "Paid-Onsite" OR euser_payment_status = "berhasil-iPaymu" OR euser_payment_status = "Complete-Paypal"' );
// UN-Paid
$unpaid = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_payment_status != "Paid-Onsite" OR euser_payment_status != "berhasil-iPaymu" OR euser_payment_status != "Complete-Paypal"' );
// Participant 
$participant_t = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_meta_type = "   participant_type"' );
// Author
$author_t = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_meta_type = "author_type"' );
?>


        <!-- Container -->
        <div class="container-iuf">
            <!-- Title -->
            <div class="title-iuf">
                <h2>Dashboard</h2>
            </div>
            <!-- End of Title -->

            <!-- Counter Wrap -->
            <div class="counter-iuf">
                <div class="registered-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $all_rows; ?></h1>
                        <p>Total Registered</p>
                    </div>
                </div>
                <div class="attended-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $attender; ?></h1>
                        <p>Total Attended</p>
                    </div>
                </div>
                <div class="paid-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $paid; ?></h1>
                        <p>Paid Member</p>
                    </div>
                </div>
                <div class="participant-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $participant_t; ?></h1>
                        <p>Participant</p>
                    </div>
                </div> 
                <div class="auth-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $author_t; ?></h1>
                        <p>Author</p>
                    </div>
                </div>
                <div class="unpaid-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $unpaid; ?></h1>
                        <p>Unpaid Member</p>
                    </div>
                </div>
            </div>
            <!-- End of Counter Wrap -->

            <!-- Add on facilities -->
            <div class="info-iuf">
                <h2>Add-on facilities</h2>
                <div class="trip-iuf">

                    <div class="mid-trip-iuf">
                        <h3>Mid Trip</h3>
                        <!-- Mid Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Gunung Kidul</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $gkidul_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Mid Trip Item -->
                        <!-- Mid Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Klaten</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $klaten_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Mid Trip Item -->
                        <!-- Mid Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Merapi</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $merapi_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Mid Trip Item -->
                    </div>

                    <div class="post-trip-iuf">
                        <h3>Post Trip</h3>
                        <!-- Post Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Pacitan</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $pacitan_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Post Trip Item -->
                        <!-- Post Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Pekanbaru Shared</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $pekanbaru_shared_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Post Trip Item -->
                        <!-- Post Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Pekanbaru Single</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $pekanbaru_single_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Post Trip Item -->
                    </div>
                </div>
            </div>
            <!-- End of Add on facilities -->
            <!-- Dinner -->
            <div class="dinner-wrap-iuf">
                <div class="dinner-iuf-item">
                    <div class="dinner-iuf">
                        <p>Dinner</p>
                    </div>
                    <div class="dinner-numb-iuf">
                        <p><?php echo $dinner_rows; ?></p>
                    </div>
                </div>
            </div>
            <!-- End of Dinner -->

            <div class="content-wrap-iuf">
                <h3>Content Wrap</h3>
                <a href="#" class="btn-admin-iuf btn-black-iuf">VIEW</a>
            </div>

            <div class="content-wrap-iuf">
                <h3>Content Wrap</h3>
                <a href="#" class="btn-admin-iuf btn-grey-iuf">VIEW</a>
            </div>

        </div>
        <!-- End of Container -->


<script type="text/javascript" src="<?php echo get_site_url() . '/wp-content/plugins/ss-event-dates/assets/js/popup.js' ?>"></script>
<script>
// Activate All PopUp Windows
jQuery('.iufro-popup').popupWindow(); 

</script>

<?php
// end Dashboard
?>