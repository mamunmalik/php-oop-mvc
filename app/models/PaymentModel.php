<?php
require_once(APPROOT . '/libraries/Database.php');
class PaymentModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function insert($amount, $buyer, $receipt_id, $items, $buyer_email, $buyer_ip, $note, $city, $phone, $hash_key, $entry_at, $entry_by)
    {
        $this->db->query("INSERT INTO payments (amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, hash_key, entry_at, entry_by) VALUES (:amount, :buyer, :receipt_id, :items, :buyer_email, :buyer_ip, :note, :city, :phone, :hash_key, :entry_at, :entry_by)");

        $this->db->bind(':amount', $amount);
        $this->db->bind(':buyer', $buyer);
        $this->db->bind(':receipt_id', $receipt_id);
        $this->db->bind(':items', $items);
        $this->db->bind(':buyer_email', $buyer_email);
        $this->db->bind(':buyer_ip', $buyer_ip);
        $this->db->bind(':note', $note);
        $this->db->bind(':city', $city);
        $this->db->bind(':phone', $phone);
        $this->db->bind(':hash_key', $hash_key);
        $this->db->bind(':entry_at', $entry_at);
        $this->db->bind(':entry_by', $entry_by);

        $this->db->execute();
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM payments");
        return $this->db->resultSet();
    }
}