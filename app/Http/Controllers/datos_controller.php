<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\emp_ciudad_ubigeo;
use App\Models\emp_tarifario_grupo_tarifa;
use App\Models\emp_tarifario_grupos;
use App\Models\emp_terminal;

/**
 * @OA\Info(
 *     title="Prueba técnica Nemias Vasquez",
 *     version="1.0.0",
 *     description="Se realiza la prueba técnica para optimizar el lenguaje php con laravel 11",
 *     @OA\Contact(
 *         email="nemiasvasquezs@hotmail.com"
 *     )
 * )
 * 
 */

class datos_controller extends Controller
{


    /**
     * @OA\Get(
     *     path="/prueba",
     *     summary="Prueba de funcionamiento del API",
     *     description="Vaidar que el api envíe información",
     *     tags={"datos"},
     *     @OA\Response(
     *         response=200,
     *         description="[]",
     *     ),
     * )
     */
    public function prueba()
    {
        return response()->json(['datos' => []]);
    }
    public function funct_traerDatos_module()
    {
        $data = $this->traerDatos();
        return $data;
    }

    /**
     * @OA\Get(
     *     path="/traerDatos",
     *     summary="Se obtienen los datos registrados en base.",
     *     description="Prueba principal de la entrevista técnica.",
     *     tags={"datos"},
     *     @OA\Response(
     *         response=200,
     *         description="Entrega de los datos",
     *     ),
     * )
     */
    public function traerDatos()
    {
        //$terminales = $this->db->select("SELECT ter_id, ter_nombre, ter_ubigeo FROM emp_terminal where ter_nombre!='...'");
        $terminales = emp_terminal::where('ter_nombre', '!=', '...')->select('ter_id', 'ter_nombre', 'ter_ubigeo')->get();

        /*
        $distritos = $this->db->select("
                SELECT DISTINCT ubi_departamento,ubi_provincia, ubi_distrito, ubi_id
                FROM emp_ciudad_ubigeo
                WHERE (ubi_distrito != ''
                    AND ubi_distid IN ( SELECT DISTINCT ta_id_distrito FROM `emp_tarifario_grupos` ))");
        $count_terminales = count($terminales);
        */

        $distritos = emp_ciudad_ubigeo::where('ubi_distrito', '!=', '')
            ->select('ubi_departamento', 'ubi_provincia', 'ubi_distrito', 'ubi_id')->distinct()->get();

        $count_terminales = count($terminales);

        for ($i = 0; $i < $count_terminales; $i++) {
            $datos[$terminales[$i]->ter_id] = [
                "name" => $terminales[$i]->ter_nombre,
                "distritos" => $this->traerDist($terminales[$i]->ter_id)
            ];
        }
        return $datos;
    }


    public function traerDist($id)
    {
        #$ubigeo = $this->db->select("SELECT ter_ubigeo FROM emp_terminal where ter_id = $id")[0]->ter_ubigeo;
        $ubigeo = emp_terminal::where('ter_id', '==', $id)->select('ter_ubigeo')->get();

        #$dep_id = $this->db->select("SELECT ubi_depid FROM emp_ciudad_ubigeo WHERE ubi_id = $ubigeo")[0]->ubi_depid;

        $dep_id = emp_ciudad_ubigeo::where('ubi_id', '==', $ubigeo)->select('ubi_depid')->get();

        #$prov_id = $this->db->select("SELECT ubi_provid FROM emp_ciudad_ubigeo WHERE ubi_id = $ubigeo")[0]->ubi_provid;

        $prov_id = emp_ciudad_ubigeo::where('ubi_id', '==', $ubigeo)->select('ubi_provid')->get();

        /*
            $distritos = $this->db->select("
                    SELECT DISTINCT ubi_distrito, ubi_id
                    FROM emp_ciudad_ubigeo
                    WHERE (
                        ubi_depid = $dep_id
                        AND ubi_provid = $prov_id AND ubi_distrito != ''
                        AND ubi_distid IN (
                                SELECT DISTINCT ta_id_distrito
                                FROM `emp_tarifario_grupos`
                                WHERE ta_id_departamento = $dep_id  AND ta_id_provincia = $prov_id
                        )
                    )");

        */
        $distritos = emp_ciudad_ubigeo::where('ubi_depid', '==', $dep_id)
            ->where('ubi_provid', '==', $prov_id)
            ->where('ubi_distrito', '!=', '')
            ->select('ubi_distrito', 'ubi_id')->distinct()->get();

        $count_distritos = count($distritos);
        for ($i = 0; $i < $count_distritos; $i++) {
            $data[] = [
                "ubi_distrito" => $distritos[$i]->ubi_distrito,
                "ubi_id" => $distritos[$i]->ubi_id,
                "tarifa_recojo" => $this->traerTarifa($distritos[$i]->ubi_id, 'recojo'),
                "tarifa_reparto" => $this->traerTarifa($distritos[$i]->ubi_id, 'reparto')
            ];
        }
        return $data??[];
    }

    public function traerTarifa($ubi_id, $tipo)
    {
        //$ubi_id_int = gettype($ubi_id);
        $pos = strpos($ubi_id, '1501');
        $msj = '';
        if ($pos !== false) {
            if ($tipo == 'recojo') {
                $gt_id = $this->db->select("SELECT ta_id_tarifa FROM emp_tarifario_grupos WHERE ta_ubigeo = $ubi_id")[0]->ta_id_tarifa;
                $msj = 'lima-recojo';
            } elseif ($tipo == 'reparto') {
                $gt_id = $this->db->select("SELECT ta_id_tarifa_reparto FROM emp_tarifario_grupos WHERE ta_ubigeo = $ubi_id")[0]->ta_id_tarifa_reparto;
                $msj = 'lima-reparto';
            }
        }
        $gt_id = $this->db->select("SELECT ta_id_tarifa FROM emp_tarifario_grupos WHERE ta_ubigeo = $ubi_id")[0]->ta_id_tarifa;
        $gt_id = (int) (trim($gt_id));
        $tarifas = $this->db->select("SELECT gt_tarifas FROM emp_tarifario_grupo_tarifa WHERE gt_id = " . $gt_id)[0]->gt_tarifas;

        return json_decode($tarifas, true);
    }
}
