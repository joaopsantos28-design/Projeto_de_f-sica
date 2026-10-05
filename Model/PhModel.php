<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class PHs {
    
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function createPH(float $ph, float $cloro_residual, float $temperatura, float $concentracao_entrada, float $concentracao_saida, float $eficiencia, string $resultado): bool {
        try {
            $sql = "INSERT INTO amostras (ph, cloro_residual, temperatura, concentracao_entrada, concentracao_saida, $eficiencia, $resultado, $data_analise) VALUES (:ph, :cloro_residual, :temperatura, :concentracao_entrada, :concentracao_saida, :reusltado, NOW())";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":ph", $ph, PDO::PARAM_STR);
            $stmt->bindParam(":cloro_residual", $cloro_residual, PDO::PARAM_STR);
            $stmt->bindParam(":temperatura", $temperatura, PDO::PARAM_STR);
            $stmt->bindParam(":concentracao_entrada", $concentracao_entrada, PDO::PARAM_STR);
            $stmt->bindParam(":concentracao_saida", $concentracao_saida, PDO::PARAM_STR);
            $stmt->bindParam(":eficiencia", $eficiencia, PDO::PARAM_STR);
            $stmt->bindParam(":resultado", $resultado, PDO::PARAM_STR);

       } catch(PDOException $error) {
            error_log("Erro ao criar PH:". $error->getMessage());
            return false;
        }

    }
}