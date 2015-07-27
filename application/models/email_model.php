<?php
require_once APPPATH . 'core/CK_Model.php';

class email_model extends CK_Model {

	public function saveEmail($subject, $content, $recipients, $ccs, $bccs, $wasSent) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$content = "Subject: " . $subject . " Body: " . $content;
		
		if($wasSent)
			$wasSent = "true";
		else
			$wasSent = "false";

		$insertQuery = "insert into communication(content, type, successfully_sent) values (?,?,?)";

		$returnId = $this -> executeReturningId($this -> db, $insertQuery, array($content, "e-mail", $wasSent));

		if ($returnId) {
			$this -> Logger -> info("Salvei o e-mail agora vou salvar os recipientes");
			if ($recipients != NULL) {
				if (!is_array($recipients))
					$recipients = array($recipients);
				foreach ($recipients as $recipient)
					$this -> saveMailRecipient($returnId, $recipient, "recipient");
			}
			if ($ccs != NULL) {
				if (!is_array($ccs))
					$ccs = array($ccs);
				foreach ($ccs as $cc)
					$this -> saveMailRecipient($returnId, $cc, "CC");
			}
			if ($bccs != NULL) {
				if (!is_array($bccs))
					$bccs = array($bccs);
				foreach ($bccs as $bcc)
					$this -> saveMailRecipient($returnId, $bcc, "BCC");
			}
		} else {
			$this -> Logger -> error("Não consegui salvar o e-mail com conteudo: " . $content);
		}

	}

	public function saveMailRecipient($emailId, $recipient, $type) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$insertQuery = "insert into communication_recipient(communication_id, recipient, recipient_type) values (?,?,?)";

		$return = $this -> execute($this -> db, $insertQuery, array($emailId, $recipient, $type));

		if (!$return)
			$this -> Logger -> error("Não pude salvar o recipiente: " . $recipient . " com tipo = " . $type . " e emailId = " . $emailId);
		else
			$this -> Logger -> info("Recipiente salvo com sucesso");

	}

	public function getEmailsSentToUserById($userId) {
		$this -> Logger -> info("Running: " . __METHOD__);

		$sql = "SELECT c.communication_id, c.content, to_char(c.date_sent, 'YYYY-MM-DD HH:mm') as date_sent, 
				c.successfully_sent, c.type FROM communication c 
				INNER JOIN communication_recipient cr on cr.communication_id = c.communication_id
				INNER JOIN person p on p.email = cr.recipient
				WHERE p.person_id = ?
				AND cr.recipient_type = 'recipient'
				ORDER BY date_sent DESC
				LIMIT 30";
		$emails = $this->executeRows($this->db, $sql, array(intval($userId)));

		if(!$emails)
			return array();

		return $emails;
	}

}
?>
