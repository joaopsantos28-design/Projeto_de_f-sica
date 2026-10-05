<?php

namespace Controller;

use Model\PH;
use Model\PhModel;

class PhController {

    //private $PhModel;

    public function __construct(private PH $PhModel) {
        //$this->Phmodel = new PhModel();
    }

    private function verifyNegativeNumbers(float $ph, float $cloro_residual, float $concentracao_entrada, float $concentracao_saida, float $eficiencia) {
        if($ph < 0 || $cloro_residual < 0 || $concentracao_entrada < 0 || $concentracao_saida < 0) {
            return [
                "ph" => null,
                "BMIrange" => "Os valores devem ser positivos"
            ];
        }
        return null;
    }
    private function verifyZeroValues(float $ph, float $cloro_residual, float $concentracao_entrada, float $concentracao_saida, float $eficiencia) {
        if($ph == 0 || $cloro_residual == 0 || $concentracao_entrada == 0 || $concentracao_saida == 0) {
            return [
                "ph" => null,
                "BMIrange" => "Os valores devem ser maiores que zero"
            ];
        }
        return null;
    }

    public function calculatePh(float $ph, float $cloro_residual, float $temperatura, float $concentracao_entrada, float $concentracao_saida, float $eficiencia) {
        $this->validateData($ph, $cloro_residual, $temperatura, $concentracao_entrada, $concentracao_saida, $eficiencia); 

        $eficiencia = round(($ph + $cloro_residual + $temperatura) * (($concentracao_entrada - $concentracao_saida)/ $concentracao_entrada));

        return [
            "eficiencia" => $eficiencia
        ];
    }

    /**
     * validate input Data.
     * @param float $ph
     * @param float $cloro_residual
     * @param float $concentracao_entrada
     * @param float $concentracao_saida
     * @return array|null 
     */

    public function validateData(float $ph, float $cloro_residual, float $concentracao_entrada, float $concentracao_saida):array|null {
        $negativeValidation = $this->verifyNegativeNumbers($ph, $cloro_residual, $concentracao_saida, $concentracao_saida);
        if ($negativeValidation !== null) {
            return $negativeValidation;
        }

        $zeroValidation = $this->verifyZeroValues($ph, $cloro_residual, $concentracao_entrada, $concentracao_saida);
        if ($zeroValidation !== null) {
            return $zeroValidation;
        }
        return null;
    }
}