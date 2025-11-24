<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends MY_Controller
{
	private $data = [];
	protected $session;
	public function __construct()
	{
		parent::__construct();

		$model_list = [
			'management/Management_model' => 'mModel',
		];
		$this->load->library('email');

		$email_config = array(
			'starttls' => true,
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'karlmarie.alob@gmail.com',
			// 'smtp_pass' => 'eagl viur fngq skjw',
			'smtp_pass' => 'svkf hjjk xidb hhdz',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n",
		);
		
		$this->email->initialize($email_config);
		$this->load->model($model_list);
	}

    public function check_expiry()
    {
        $items = $this->mModel->get_items_expiry();

		if(!empty($items)){

			$user_email = "alm3z4501@gmail.com";
            $message  = "<h3>Stock Expiry Notification</h3>";
			$message .= "<p>The following items are expiring within the next 14 days:</p>";
			$message .= "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse: collapse;'>";
			$message .= "<tr>
			                <th style='background:#f2f2f2;'>Item Name</th>
			                <th style='background:#f2f2f2;'>Expiry Date</th>
			                <th style='background:#f2f2f2;'>Quantity</th>
			             </tr>";

			foreach ($items as $stock) {
			    $message .= "<tr>
			                    <td>{$stock->item_name}</td>
			                    <td>{$stock->item_expiry_date}</td>
			                    <td>{$stock->quantity}</td>
			                 </tr>";
			}

			$message .= "</table>";
			$message .= "<p style='margin-top:20px;'>Please take appropriate action.</p>";
			$message .= "<p>— Inventory System</p>";

			$this->email->from('karlmarie@gmail.com', 'Inventory System');
			$this->email->to($user_email);
			$this->email->subject('Stock Expiry Alert');
			$this->email->message($message);
			$this->email->set_mailtype("html");
			$this->email->send();
        }
    }

}