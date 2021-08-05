<?php

class Barang extends BaseController{
    
    /**
     * GET ALL DATA
     * 
     * method   : GET
     * endpoint : yourwebsite.com/barang/get
     */
    public function get(?string $id = null): void
    {
        Utility::reqMethodCheck('GET');
        $this->model("barang_model")->getBarang($id);
    }

    /**
     * ADD BARANG
     * 
     * method   : POST
     * endpoint : yourwebsite.com/barang/add
     * 
     * parameter
     *  - name
     *  - quantity
     *  - desk
     */
    public function add(): void
    {
        Utility::reqMethodCheck('POST');
        $validation = [];
        Utility::_methodParser('_post');
        global $_post;
        
        // if parameter missing
        (!isset($_post['name'])    ) ? Utility::response(400,"parameter 'name' is missing")  : '';
        (!isset($_post['quantity'])) ? Utility::response(400,"parameter 'quantity' is missing")  : '';
        (!isset($_post['desk'])    ) ? Utility::response(400,"parameter 'desk' is missing")  : '';
        // not empty
        (strlen($_post['name'])    == 0) ? $validation['name']     = "cannot be empty"  : '';
        (strlen($_post['quantity'])== 0) ? $validation['quantity'] = "cannot be empty"  : '';
        (strlen($_post['desk'])    == 0) ? $validation['desk']     = "cannot be empty"  : '';
        // max length 
        (strlen($_post['name'])    > 100)? $validation['name']    = "max 100 character"  : '';
        (strlen($_post['quantity'])> 11) ? $validation['quantity'] = "max 11 character"  : '';
        (strlen($_post['desk'])    > 255)? $validation['desk']    = "max 255 character"  : '';
        // quantity must number 
        ((bool)preg_match_all('/[A-Za-z,.\\/?><:;\'\"|!@#$%^&*()\-_\+={}\\[\\]`~]/', $_post['quantity']))  ? $validation['quantity']   = "must integer!"  : '';
        
        (!empty($validation)) ? Utility::response(400,$validation) : '';

       $this->model("barang_model")->addBarang($_post);
    }

    /**
     * UPDATE BARANG
     * 
     * method   : POST
     * endpoint : yourwebsite.com/barang/update
     * 
     * parameter
     *  - product_id
     *  - name
     *  - quantity
     *  - desk
     */
    public function update(): void
    {
        Utility::reqMethodCheck('PUT');
        $validation = [];
        parse_str(file_get_contents('php://input'), $_PUT);

        // if parameter missing
        (!isset($_PUT['product_id']))? Utility::response(400,"parameter 'product_id' is missing") : '';
        (!isset($_PUT['name'])    )  ? Utility::response(400,"parameter 'name' is missing")       : '';
        (!isset($_PUT['quantity']))  ? Utility::response(400,"parameter 'quantity' is missing")   : '';
        (!isset($_PUT['desk'])    )  ? Utility::response(400,"parameter 'desk' is missing")       : '';

        // if product not exist
        $this->model("barang_model")->checkBarang($_PUT['product_id']);

        // not empty
        (strlen($_PUT['name'])    == 0) ? $validation['name']     = "cannot be empty"  : '';
        (strlen($_PUT['quantity'])== 0) ? $validation['quantity'] = "cannot be empty"  : '';
        (strlen($_PUT['desk'])    == 0) ? $validation['desk']     = "cannot be empty"  : '';
        // max length 
        (strlen($_PUT['name'])    > 100)? $validation['name']     = "max 100 character" : '';
        (strlen($_PUT['quantity'])> 11) ? $validation['quantity'] = "max 11 character"  : '';
        (strlen($_PUT['desk'])    > 255)? $validation['desk']     = "max 255 character" : '';
        // quantity must number 
        ((bool)preg_match_all('/[A-Za-z,.\\/?><:;\'\"|!@#$%^&*()\-_\+={}\\[\\]`~]/', $_PUT['quantity']))  ? $validation['quantity']   = "must integer!"  : '';
        
        (!empty($validation)) ? Utility::response(400,$validation) : '';

       $this->model("barang_model")->updateBarang($_PUT);
    }

    /**
     * PENGAJUAN
     * 
     * method   : POST
     * endpoint : yourwebsite.com/barang/pengajuan
     * 
     * parameter
     *  - admin
     *  - quantity
     *  - desk
     */
    public function pengajuan(): void
    {
        Utility::reqMethodCheck('POST');
        $validation = [];
        parse_str(file_get_contents('php://input'), $_post);
        // if parameter missing
        (!isset($_post['product_name'])   ) ? Utility::response(400,"parameter 'product_name' is missing")   : '';
        (!isset($_post['admin'])   ) ? Utility::response(400,"parameter 'admin' is missing")   : '';
        (!isset($_post['quantity'])) ? Utility::response(400,"parameter 'quantity' is missing"): '';
        (!isset($_post['desk'])    ) ? Utility::response(400,"parameter 'desk' is missing")    : '';
        // not empty
        (strlen($_post['product_name'])   == 0) ? $validation['product_name']    = "cannot be empty"  : '';
        (strlen($_post['admin'])   == 0) ? $validation['admin']    = "cannot be empty"  : '';
        (strlen($_post['quantity'])== 0) ? $validation['quantity'] = "cannot be empty"  : '';
        (strlen($_post['desk'])    == 0) ? $validation['desk']     = "cannot be empty"  : '';
        // max length 
        (strlen($_post['product_name'])   > 100)? $validation['product_name']     = "max 100 character"  : '';
        (strlen($_post['admin'])   > 100)? $validation['admin']     = "max 100 character"  : '';
        (strlen($_post['quantity'])> 11)  ? $validation['quantity'] = "max 11 character" : '';
        (strlen($_post['desk'])    > 255) ? $validation['desk']     = "max 255 character" : '';
        // quantity must number 
        ((bool)preg_match_all('/[A-Za-z,.\\/?><:;\'\"|!@#$%^&*()\-_\+={}\\[\\]`~]/', $_post['quantity']))  ? $validation['quantity']   = "must integer!"  : '';
        
        (!empty($validation)) ? Utility::response(400,$validation) : '';

       $this->model("barang_model")->pengajuan($_post);
    }

    /**
     * PENGAMBILAN
     * 
     * method   : PUT
     * endpoint : yourwebsite.com/barang/pengambilan
     * 
     * parameter
     *  - product_id
     *  - admin
     *  - quantity
     *  - desk
     */
    public function pengambilan(): void
    {
        Utility::reqMethodCheck('PUT');
        parse_str(file_get_contents('php://input'), $_PUT);

        $validation = [];
        // if parameter missing
        (!isset($_PUT['product_id'])) ? Utility::response(400,"parameter 'product_id' is missing") : '';
        (!isset($_PUT['admin']))    ? Utility::response(400,"parameter 'admin' is missing")   : '';
        (!isset($_PUT['quantity'])) ? Utility::response(400,"parameter 'quantity' is missing"): '';
        (!isset($_PUT['desk']))     ? Utility::response(400,"parameter 'desk' is missing")    : '';

        // not empty
        (strlen($_PUT['product_id']) == 0) ? $validation['product_id']= "cannot be empty"  : '';
        (strlen($_PUT['admin'])      == 0) ? $validation['admin']     = "cannot be empty"  : '';
        (strlen($_PUT['quantity'])   == 0) ? $validation['quantity']  = "cannot be empty"  : '';
        (strlen($_PUT['desk'])       == 0) ? $validation['desk']      = "cannot be empty"  : '';

        // max length 
        (strlen($_PUT['admin'])   > 100)? $validation['admin']    = "max 100 character" : '';
        (strlen($_PUT['quantity'])> 11) ? $validation['quantity'] = "max 11 character"  : '';
        (strlen($_PUT['desk'])    > 255)? $validation['desk']     = "max 255 character" : '';

        // quantity must number 
        ((bool)preg_match_all('/[A-Za-z,.\\/?><:;\'\"|!@#$%^&*()\-_\+={}\\[\\]`~]/', $_PUT['quantity']))  ? $validation['quantity']   = "must integer!"  : '';
        
        (!empty($validation)) ? Utility::response(400,$validation) : '';

       $this->model("barang_model")->pengambilanBarang($_PUT);
    }

    /**
     * HAPUS BARANG
     * 
     * method   : DELETE
     * endpoint : yourwebsite.com/barang/hapus
     * 
     * parameter
     *  - product_id
     */
    public function hapus(): void
    {
        Utility::reqMethodCheck('DELETE');
        parse_str(file_get_contents('php://input'), $_DELETE);

        $validation = [];
        // if parameter missing
        (!isset($_DELETE['product_id']))      ? Utility::response(400,"parameter 'product_id' is missing"):'';
        // not empty
        (strlen($_DELETE['product_id']) == 0) ? Utility::response(400,"'product_id' cannot be empty") 
        : '';
        // if product not exist
        $this->model("barang_model")->checkBarang($_DELETE['product_id']);

       $this->model("barang_model")->hapusbBarang($_DELETE['product_id']);
    }

}

?>