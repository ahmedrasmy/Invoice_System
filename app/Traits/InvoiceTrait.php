<?php
namespace App\Traits;

trait InvoiceTrait
{
    function saveImage($photo,$folder)
    {
        $img=$photo;
        $ext=$img->getClientOriginalExtension();
        $name="invoice- ". uniqid() .".$ext";
        $img->move(public_path($folder),$name);
        return $name;
    }
}  