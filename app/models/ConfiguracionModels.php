<?php
/**
 * Created by PhpStorm.
 * User: desarrollo
 * Date: 20/12/2016
 * Time: 17:20
 */

namespace App\models;

use DB;
use Auth;

class ConfiguracionModels
{

    static  public function listar()
    {

            $data = DB::table('Configuracion')
            ->first();
        return $data;

        

    }




    static public function editar($tiempo_gracia,$nombre_sistema,$nombre_corto_sistema,$prioridad,$nombre_logo,$base64_img)
    {



        DB::table('Configuracion')
            ->update( ['tiempo_gracia' => $tiempo_gracia, 'nombre_sistema' => $nombre_sistema, 'nombre_corto_sistema' => $nombre_corto_sistema, 'prioridad' => $prioridad, 'path_logo' => $nombre_logo,'base64_img'=>$base64_img]);

    }



    static  public function diasferiados($diaferiadoID=FALSE)
    {

        if(!$diaferiadoID){

           return DB::table('Holiday')->get();


        }
        else
        {
            $data = DB::table('Holiday')
                ->where('Holidayid', $diaferiadoID)
                ->orderBy('Holidayid', 'asc')
                ->first();
            return $data;

        }


    }

    static  public function insertar_diaferiado($nombre,$dia_feriado,$dias){

        DB::table('Holiday')->insert(
            ['Name' => $nombre, 'BDate' => str_replace("-","",$dia_feriado) ,'Days'=>$dias]
        );
    }



    static  public function editar_diaferiado($id_feriado,$nombre,$dia_feriado,$dias){

        DB::table('Holiday')
            ->where('Holidayid', $id_feriado)
            ->update(['Name' => $nombre, 'BDate' => str_replace("-","",$dia_feriado),'Days'=>$dias]);
    }

    static  public function delete_diaferiado($id_feriado){

        DB::table('Holiday')
            ->where('Holidayid', $id_feriado)
            ->delete();
    }


}