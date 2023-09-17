<?php
require_once(APPROOT . '/models/PaymentModel.php');
class PaymentController
{
    private $model;

    public function __construct()
    {
        $this->model = new PaymentModel;
    }

    public function index()
    {
        $payments = $this->model->getAll();
        include(APPROOT . '/views/payments/index.php');
    }

    public function create()
    {
        include(APPROOT . '/views/payments/create.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = $_POST['amount'];
            $buyer = $_POST['buyer'];
            $receipt_id = $_POST['receipt_id'];
            $items = $_POST['items'];
            $buyer_email = $_POST['buyer_email'];
            $buyer_ip = $_SERVER['REMOTE_ADDR'];
            $note = $_POST['note'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $hash_key = hash("sha512", "HiZiBiZi" . $_POST['receipt_id']);
            $entry_at = date("Y-m-d");
            $entry_by = $_POST['entry_by'];

            $errors = [];
            if (!is_numeric($amount)) {
                $errors['amount'] = 'Amount should contain only numbers.';
            }

            if (!preg_match('/^[A-Za-z0-9\s]{1,20}$/', $buyer)) {
                $errors['buyer'] = "Buyer should contain only text, spaces, and numbers (up to 20 characters).";
            }

            if (!preg_match('/^[A-Za-z]+$/', $receipt_id)) {
                $errors['receipt_id'] = "Receipt_id should contain only text.";
            }

            if (!filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
                $errors['buyer_email'] = 'Please enter a valid email address.';
            }

            if (str_word_count($note) > 30) {
                $errors['note'] = "Note can't exceed 30 words.";
            }

            if (!preg_match('/^[A-Za-z\s]+$/', $city)) {
                $errors['city'] = "City should contain only text and spaces.";
            }

            if (!is_numeric($phone)) {
                $errors['phone'] = "Phone should contain only numbers.";
            }

            if (!is_numeric($entry_by)) {
                $errors['entry_by'] = "Entry_by should contain only numbers.";
            }

            if (!empty($errors)) {
                // If there are errors, send a JSON response with errors
                http_response_code(400); // Set HTTP status code to indicate a bad request
                echo json_encode(["error" => true, 'errors' => $errors]);
                exit;
            }

            $this->model->insert($amount, $buyer, $receipt_id, $items, $buyer_email, $buyer_ip, $note, $city, $phone, $hash_key, $entry_at, $entry_by);

            // Respond with a success message
            echo json_encode(["error" => false, 'message' => 'Data submitted successfully.']);

            // Exit the script
            exit;
        }
    }
}