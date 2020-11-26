<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Buyer extends Model
{
    protected $guarded = ['created_at', 'updated_at'];
    protected $primaryKey = null;
    public $incrementing = false;

    public static function setTextStruk($data){
        $connector = new WindowsPrintConnector('Printer Kasir');
        $printer = new Printer($connector);


        $total = $data['total_harga']+$data['ongkir'];
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Toko Sederhana Mangunreja\n");
        $printer->text("================================\n"); //32 character
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("\n");
        $printer->text("Nama     : ".$data['nama']."\n");
        $printer->text("No Struk : ".$data['kode']."\n");
        $printer->setLineSpacing(30);
        $printer->text("--------------------------------\n");
        foreach($data['barang'] as $text){
            $printer->text("$text\n"); //sisakan 20 character
        }
        $printer->text("--------------------------------\n");
        $printer->text("Total Harga         Rp ".number_format($data['total_harga'], 0, ',', '.')."\n");
        $printer->text("Ongkir              Rp ".number_format($data['ongkir'], 0, ',', '.')."\n");
        $printer->text("--------------------------------\n");
        $printer->text("Jumlah              Rp ".number_format($total, 0, ',', '.')."\n\n\n\n");
        // $printer->text("Total Bayar         Rp 350.000\n");
        // $printer->text("--------------------------------\n");
        // $printer->text("Kembalian           Rp. 10.000\n");
        // $printer->text("\n");
        // $printer->text("================================\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terima kasih\n");
        $printer->text("atas kunjunganya ^-^\n");
        $printer->text("\n\n\n");
        $printer->cut(Printer::CUT_PARTIAL);
        $printer->close();
    }

    public static function setText($string, $max){
        $size = strlen($string);
        $space = $max - $size;
        if($space >= 0){
            for($i = 1; $i <= $space+1; $i++){
                $string .= ' ';
            }
        }else{
            $string = substr($string, 0, $max+1);
        }
        return $string;
    }

    public static function max($score, $max){
        if(strlen($score) > $max){
            $max = strlen($score);
        }
        return $max;
    }
}
