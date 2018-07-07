<?php
/**
 * Gets the messages(SMSs) sent by CaCxSMS as a POST request.
 *
 */
function get_message()
{
    $msgrpl = "";
    $error = NULL;
    // Set success to false as the default success status
    $success = false;
    /**
     *  Get the phone number that sent the SMS.
     */
    if (isset($_POST['from']))
    {
        $from = $_POST['from'];
    }
    else
    {
        $error = 'The from variable was not set';
    }
    /**
     * Get the SMS aka the message sent.
     */
    if (isset($_POST['message']))
    {
        $message = $_POST['message'];
    }
    else
    {
        $error = 'The message variable was not set';
    }
    /**
     * Get the secret key set on CaCxSMS side
     * for matching on the server side.
     */
    if (isset($_POST['secret']))
    {
        $secret = $_POST['secret'];
    }
    /**
     * Get the timestamp of the SMS
     */
    if(isset($_POST['sent_timestamp']))
    {
        $sent_timestamp = $_POST['sent_timestamp'];
    }
    /**
     * Get the phone number of the device CaCxSMS is
     * installed on.
     */
    if (isset($_POST['sent_to']))
    {
        $sent_to = $_POST['sent_to'];
    }
    /**
     * Get the unique message id
     */
    if (isset($_POST['message_id']))
    {
        $message_id = $_POST['message_id'];
    }
    /**
     * Get device ID
     */
    if (isset($_POST['device_id']))
    {
        $device_id = $_POST['device_id'];
    }
    /**
     * Now we have retrieved the data sent over by CaCxSMS
     * via HTTP. Next thing to do is to do something with
     * the data. Either echo it or write it to a file or even
     * store it in a database. This is entirely up to you.
     * After, return a JSON string back to CaCxSMS to know
     * if the web service received the message successfully or not.
     *
     * In this demo, we are just going to save the data
     * received into a text file.
     *
     */
    if ((strlen($from) > 0) AND (strlen($message) > 0) AND
        (strlen($sent_timestamp) > 0 )
        AND (strlen($message_id) > 0))
    {
        /* The screte key set here is 123456. Make sure you enter
         * that on CaCxSMS.
         */
        if ( ( $secret == '123456'))
        {
            $success = true;
        } else
        {
            $error = "The secret value sent from the device does not match the one on the server";
        }

    if (preg_match_all("/What is cervical cancer/i", $message, $match)){
      $msgrpl = "Cervical cancer is cancer that begins in the uterine cervix, the lower end of the uterus that contacts the upper vagina.";
      }
    else if(preg_match_all("/\bresearch\b|\bdone\b/i", $message, $match)){
        $msgrpl = "Research is ongoing to improve methods to treat cervical cancer, treating precancers and detecting cancers in early, treatable stages.";
        }
    else if(preg_match_all("/\bsurvival\b|\brates\b|\bprognosis\b/i", $message, $match)){
        $msgrpl = "Prognosis for cancers is reported in five-year survival rates and better if detected in early stages than for advanced cancers";
        }
    else if(preg_match_all("/\bsupport\b|\bavailable\b|\bhelp\b/i", $message, $match)){
        $msgrpl = "Support from family, friends, clergy, counselor or group can help you learn and cope with the illness, diagnosis and effects of treatment.";
        }
    else if(preg_match_all("/prevent|\bvaccine\b|\bcure\b/i", $message, $match)){
        $msgrpl = "Cervical cancer can often be prevented with vaccination and modern screening techniques that detect precancerous changes in the cervix.";
        }
    else if(preg_match_all("/\bmethods\b|\btreatment\b|\btreat\b/i", $message, $match)){
        $msgrpl = "Surgery is often performed to remove the cancer, especially in early-stage tumors. Hysterectomy (removal of the uterus) may be performed.";
        }
    else if(preg_match_all("/What is the treatment/i", $message, $match)){
        $msgrpl = "Treatment depends upon many factors, like the stage when it is diagnosed. Surgery, radiation therapy, chemotherapy, and targeted therapy.";
        }
    else if(preg_match_all("/\bget\b|\bcauses\b|\bbrings\b/i", $message, $match)){
        $msgrpl = "All are caused by longstanding infection with one of the HPVs which are very common but not all people with HPV infection develop cancer.";
        }
    else if(preg_match_all("/\bsymptoms\b|\bsigns\b/i", $message, $match)){
        $msgrpl = "May not produce any signs, early stages like precancerous changes do not produce symptoms but may develop when cells start to invade surrounding tissues.";
        }
    else if(preg_match_all("/\brisk\b|\bfactors\b/i", $message, $match)){
        $msgrpl = "Certain risk factors have been identified that increase a woman’s risk like smoking, HIV infection, Overweight.";
        }
    else if(preg_match_all("/\bscreening\b|\bguidelines\b/i", $message, $match)){
        $msgrpl = "It is recommended that all women between the ages of 21 and 65 receive screening every three years.";
        }
    else if(preg_match_all("/\btest\b|\bdiagnose\b|\bdiagnosis\b/i", $message, $match)){
        $msgrpl = "Pap testing is done for screening, If abnormal cells are detected on the Pap smear, a colposcopy procedure is then performed.";
        }
    else if(preg_match_all("/\btest\b|\bdiagnose\b|\bdiagnosis\b/i", $message, $match)){
        $msgrpl = "The stage of any cancer refers to the extent to which it has spread in the body at the time of diagnosis.";
        }
    else
    {
        $msgrpl = "Your message has been received and your cervical cancer awareness will be sent shortly.";
    }

        // now let's write the info sent by CaCxSMS
        //to a file called test.txt
        $string = "From: ".$from."\n";
        $string .= "Message: ".$message."\n";
        $string .= "Timestamp: ".$sent_timestamp."\n";
        $string .= "Messages Id:" .$message_id."\n";
        $string .= "Sent to: ".$sent_to."\n";
        $string .= "Device ID: ".$device_id."\n\n\n";
        write_message_to_file($string);
    }
    /**
     * Comment the code below out if you want to send an instant
     * reply as SMS to the user.
     *
     * This feature requires the "Get reply from server" checked on CaCxSMS.
     */
     send_instant_message($from, $msgrpl);
    /**
      * Now send a JSON formatted string to CaCxSMS to
      * acknowledge that the web service received the message
      */
     $response = json_encode([
        "payload"=> [
            "success"=>$success,
                "error" => $error
            ]
        ]);
     //send_response($response);
}
 
/**
 * Writes the received responses to a file. This acts as a database.
 */
function write_message_to_file($message)
{
    $myFile = "test.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    @fwrite($fh, $message);
    @fclose($fh);
}
 
/**
 * Implements the task feature. Sends messages to CaCxSMS to be sent as
 * SMS to users.
 */
function send_task()
{
    /**
     * Comment the code below out if you want to send an instant
     * reply as SMS to the user.
     *
     * This feature requires the "Get reply from server" checked on CaCxSMS.
     */
    if (isset($_GET['task']) AND $_GET['task'] === 'send')
    {
        $m = "Sample Task Message";
        $f = "+000-000-0000";
        $s = "true";
        $reply[0] = [
            "to" => $f,
            "message" => $m,
            "uuid" => "1ba368bd-c467-4374-bf28"
        ];
        // Send JSON response back to CaCxSMS
        $response = json_encode(
            ["payload"=>[
                "success"=>$s,
                "task"=>"send",
                "secret" => "123456",
                "messages"=>array_values($reply)]
            ]);
        send_response($response);
    }
}
 
/**
 * This sends an instant response when the server receive messages(SMSs) from
 * CaCxSMS. This requires the settings "Get Reply from Server" enabled on
 * CaCxSMS.
 */
function send_instant_message($to, $msg)
{
    $m = $msg;
    $f = "+000-000-0000";
    $s = true;
    $reply[0] = [
        "to" => $to,
        "message" => $m,
        "uuid" => "1ba368bd-c467-4374-bf28"
    ];
    // Send JSON response back to CaCxSMS
    $response = json_encode(
        ["payload"=>[
            "success"=>$s,
            "task"=>"send",
            "secret" => "123456",
            "messages"=>array_values($reply)]
        ]);
    send_response($response);
}
 
function send_response($response)
{
    // Avoid caching
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    header("Content-type: application/json; charset=utf-8");
    echo $response;
}
 
function get_sent_message_uuids()
{
    $data = file_get_contents('php://input');
    $queued_messages = file_get_contents('php://input');
    // Writing this to a file for demo purposes.
    // In production, you will have to process the JSON string
    // and remove the messages from the database or where ever the
    // messages are stored so the next Task run, the server won't add
    // these messages.
    write_message_to_file($queued_messages."\n\n");
    send_message_uuids_waiting_for_a_delivery_report($queued_messages);
 
}
 
/**
 * Sends message UUIDS to CaCxSMS for their sms delivery status report.
 * When CaCxSMS send messages from the server as SMS to phone numbers, CaCxSMS
 * can send back status delivery report for these messages.
 */
function send_message_uuids_waiting_for_a_delivery_report($queued_messages)
{
    // Send back the received messages UUIDs back to CaCxSMS
    $json_obj = json_decode($queued_messages);
    $response = json_encode(
    [
        "message_uuids"=>$json_obj->queued_messages
    ]);
    send_response($response);
}
 
function send_messages_uuids_for_sms_delivery_report()
{
    if(isset($_GET['task']) AND $_GET['task'] == 'result'){
        $response = json_encode(
        [
            "message_uuids" => ['1ba368bd-c467-4374-bf28']
        ]);
        send_response($response);
    }
 
}
 
/**
 * Get status delivery report on sent messages
 *
 */
function get_sms_delivery_report()
{
    if($_GET['task'] === 'result' AND $_GET['secret']=== '123456')
    {
        $message_results = file_get_contents('php://input');
        write_message_to_file("message ".$message_results."\n\n");
    }
}
 
// Execute functions above
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if(isset($_GET['task']) AND $_GET['task'] === 'result'){
        get_sms_delivery_report();
    }
    else if( isset($_GET['task']) && $_GET['task'] === 'sent')
    {
        get_sent_message_uuids();
    }
    else
    {
        get_message();
    }
}
else
{
    send_task();
    send_messages_uuids_for_sms_delivery_report();
}
