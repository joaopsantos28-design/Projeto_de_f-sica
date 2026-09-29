<?php

namespace Controller;

use Model\PhModel;

class PhController {

    //private $PhModel;

    public function __construct(private $PhModel) {
        //$this->Phmodel = new PhModel();
    }

    private function verifyNegativeNumbers(float $ph, float $cloro_residual, float $temperatura, float $concentracao_entrada, float $concentracao_saida, float $eficiencia) {
        if($ph < 0 || $cloro_residual < 0 || $temperatura < 0 || $concentracao_entrada < 0 || $concentracao_saida < 0) {
            return [
                "ph" => null,
                "BMIrange" => "Os valores devem ser positivos"
            ];
        }
        return null;
    }
    private function verifyZeroValues(float $ph, float $cloro_residual, float $temperatura, float $concentracao_entrada, float $concentracao_saida, float $eficiencia) {
        if($ph == 0 || $cloro_residual == 0 || $temperatura == 0 || $concentracao_entrada == 0 || $concentracao_saida == 0) {
            return [
                "ph" => null,
                "BMIrange" => "Os valores devem ser maiores que zero"
            ];
        }
        return null;
    }

    public function calculatePh(float $ph, float $cloro_residual, float $temperatura, float $concentracao_entrada, float $concentracao_saida, float $eficiencia) {
        
    }
    
}