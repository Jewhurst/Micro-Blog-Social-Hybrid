<?php require 'header.php';
if($_POST['btn']=="send-user-message"){ 
	if (isset($_POST['message_text']) && isset($_POST['sender_id']) && isset($_POST['to_id'])){
		$message_text = htmlspecialchars($_POST['message_text']);
		$sender_id = ($_POST['sender_id']);
		$to_id = ($_POST['to_id']);
		//diag($to_id.' '.$sender_id.' '.$message_text);
		try {	
				if($go = $data->sendUserMessage($to_id,$sender_id,$message_text)){
					$data->alert_info($sender_id,1,$to_id,0,'message');
					if($_POST['ref'] == 'main'){
						redirect(1,'./');
					}elseif($_POST['ref'] == 'followtab'){
						redirect(1,'./#messages');					
					}					
				}
		}
		catch(PDOException $e) {
				echo $e->getMessage();
		}
	}
}
?>