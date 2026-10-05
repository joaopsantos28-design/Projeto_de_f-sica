<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class PH {
    
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function createPH(float $ph, float $cloro_residual, float $temperatura, float $concentracao_entrada, float $concentracao_saida, float $eficiencia, string $resultado): bool {
        try {
            $sql = "INSERT INTO amostras (ph, cloro_residual, temperatura, concentracao_entrada, concentracao_saida, $eficiencia, $resultado, $data_analise) VALUES (:ph, :cloro_residual, :temperatura, :concentracao_entrada, :concentracao_saida, :reusltado, NOW())";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":ph", $ph, PDO::PARAM_STR);
            $stmt->bindParam(":ph", $ph, PDO::PARAM_STR);
            $stmt->bindParam(":ph", $ph, PDO::PARAM_STR);
            $stmt->bindParam(":ph", $ph, PDO::PARAM_STR);
            $stmt->bindParam(":ph", $ph, PDO::PARAM_STR);
            $stmt->bindParam(":ph", $ph, PDO::PARAM_STR);
            $stmt->bindParam(":ph", $ph, PDO::PARAM_STR);

       } catch(PDOException $error) {
            error_log("Erro ao criar PH:". $error->getMessage());
            return false;
        }

    }
}