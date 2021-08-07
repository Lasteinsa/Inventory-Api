<?php

class Barang_model{
    public $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * CHECK BARANG
     */
    public function checkBarang(string $id): array
    {
        try {
            $this->db->query("SELECT * FROM barang_gudang WHERE id = :id");
            $this->db->bind('id',$id);
            
            if($this->db->singleResult()){
                return $this->db->singleResult();
            }
            else{
                Utility::response(404,"barang dengan id $id tidak ditemukan");
            }
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * GET BARANG
     */
    public function getBarang(?string $id): void
    {
        try {
            if(!is_null($id)){
                $this->db->query("SELECT * FROM barang_gudang WHERE id = :id");
                $this->db->bind('id',$id);
                if($this->db->singleResult()){
                    Utility::response(200,$this->db->singleResult());
                }
                else{
                    Utility::response(404,"barang dengan id $id tidak ditemukan");
                }
            }
            else{
                $this->db->query("SELECT * FROM barang_gudang ORDER BY id DESC");
                Utility::response(200,$this->db->multiResult());
            }
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * GET BARANG MASUK
     */
    public function getBarangMasuk(): void
    {
        try {
            $this->db->query("SELECT * FROM barang_masuk ORDER BY id DESC");
            Utility::response(200,$this->db->multiResult());
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * GET BARANG KELUAR
     */
    public function getBarangKeluar(): void
    {
        try {
            $this->db->query("SELECT barang_keluar.quantity,
                barang_keluar.desk,
                barang_keluar.admin,
                barang_keluar.created_at,
                barang_gudang.name
            FROM barang_keluar  
            INNER JOIN barang_gudang 
            ON (barang_gudang.id = barang_keluar.product_id) ORDER BY barang_keluar.product_id DESC");
            Utility::response(200,$this->db->multiResult());
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * GET PENGAJUAN BARANG
     */
    public function getPengajuan(): void
    {
        try {
            $this->db->query("SELECT * FROM pengajuan ORDER BY id DESC");
            Utility::response(200,$this->db->multiResult());
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * ADD BARANG
     */
    public function addBarang(array $data): void
    {
        try {
            $this->db->query("INSERT INTO barang_gudang(name,quantity,desk) VALUES(:name,:quantity,:desk)");
            $this->db->bind('name'    ,$data['name']);
            $this->db->bind('quantity',$data['quantity']);
            $this->db->bind('desk'    ,$data['desk']);

            if($this->db->execute()){
                $this->db->query("INSERT INTO barang_masuk(name,quantity) VALUES(:name,:quantity)");
                $this->db->bind('name'    ,$data['name']);
                $this->db->bind('quantity',$data['quantity']);
                
                if($this->db->execute()){
                    Utility::response(200,"tambah barang berhasil");
                }
            }
            else{
                Utility::response(500,"tambah barang gagal");
            }
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }
    
    /**
     * UPDATE BARANG
     */
    public function updateBarang(array $data): void
    {
        try {
            $this->db->query("UPDATE barang_gudang SET name = :name, quantity = :quantity, desk = :desk WHERE id = :id");
            $this->db->bind('id'  ,$data['product_id']);
            $this->db->bind('name',$data['name']);
            $this->db->bind('quantity',$data['quantity']);
            $this->db->bind('desk'   ,$data['desk']);

            if($this->db->execute()){
                Utility::response(200,"update barang dengan id ".$data['product_id']." berhasil");
            }
            else{
                Utility::response(500,"update barang dengan id ".$data['product_id']." gagal");
            }
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

    /**
     * PENGAJUAN
     */
    public function pengajuan(array $data): void
    {
        try {
            $this->db->query("INSERT INTO pengajuan(product_name,admin,quantity,desk) VALUES(:product_name,:admin,:quantity,:desk)");
            $this->db->bind('product_name'   ,$data['product_name']);
            $this->db->bind('admin'   ,$data['admin']);
            $this->db->bind('quantity',$data['quantity']);
            $this->db->bind('desk'    ,$data['desk']);

            if($this->db->execute()){
                Utility::response(200,"pengajuan diterima");
            }
            else{
                Utility::response(500,"pengajuan gagal");
            }
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }
    
    /**
     * PENGAMBILAN
     */
    public function pengambilanBarang(array $data): void
    {
        try {
            $this->db->query("INSERT INTO barang_keluar(product_id,quantity,admin,desk) VALUES(:product_id,:quantity,:admin,:desk)");
            $this->db->bind('product_id',$data['product_id']);
            $this->db->bind('admin'     ,$data['admin']);
            $this->db->bind('quantity'  ,$data['quantity']);
            $this->db->bind('desk'      ,$data['desk']);

            if($this->db->execute()){
                $this->db->query("UPDATE barang_gudang SET quantity = quantity-:diambil WHERE id = :id");
                $this->db->bind('id'      ,$data['product_id']);
                $this->db->bind(':diambil',(int)$data['quantity']);

                if($this->db->execute()){
                    Utility::response(200,"pengambilan berhasil");
                }
            }
            else{
                Utility::response(500,"pengambilan gagal");
            }
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }
    
    /**
     * HAPUS BARANG
     */
    public function hapusBarang(string $id): void
    {
        try {
            $this->db->query("DELETE FROM barang_gudang WHERE id = :id");
            $this->db->bind('id',$id);

            if($this->db->execute()){
                Utility::response(200,"hapus barang berhasil");
            }
            else{
                Utility::response(500,"hapus barang gagal");
            }
        }
        catch(Exception $err) {
            Utility::response(500,$err->getMessage());
        }
    }

}

?>