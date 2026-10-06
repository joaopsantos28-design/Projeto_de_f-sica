<?php

namespace Controller;

use Model\PHs;

class PhController
{
    //Faixas de valores aceitáveis para pH, cloro e temperatura
    public const PH_MIN = 6.0;
    public const PH_MAX = 9.0;
    public const CLORO_MIN = 0.2;
    public const CLORO_MAX = 5.0;
    public const TEMP_MIN = 15.0;
    public const TEMP_MAX = 30.0;
    // Limítes físicos
    public const PH_FISICO_MAX = 14.0;
    public const TEMP_FISICA_MAX = 100.0;
    public const ADEQUADO = 'Adequado';
    public const ABAIXO = 'Abaixo da faixa';
    public const ACIMA = 'Acima da faixa';

    private const NOMES = [
        'ph' => 'pH',
        'cloro' => 'cloro residual',
        'temperatura' => 'temperatura',
        'entrada' => 'concentração de entrada',
        'saida' => 'concentração de saída',

    ];

    private const ARTIGOS = [
        'ph' => 'o pH',
        'cloro' => 'o cloro residual',
        'temperatura' => 'a temperatura',
        'entrada' => 'a concentração de entrada',
        'saida' => 'a concentração de saída',
    ];

    public function __construct(private PHs $PhModel)
    {
    }

    private function erro(string $campo, string $mensagem): array
    {
        return [
            "valid" => false,
            "campo" => $campo,
            "erro" => $mensagem
        ];
    }


    /**
     * Converte texto do formulário (vírgula ou ponto) em float.
     * Retorna null se estiver vazio ou não for número.
     */
    private function toFloat(mixed $value): ?float
    {
        if (is_int($value) || is_float($value)) {
            return is_finite((float) $value) ? (float) $value : null;
        }
        if (is_string($value)) {
            $normalized = str_replace(',', '.', trim($value));
            if (preg_match('/^[+-]?\d+(\.\d+)?$/', $normalized) === 1) {
                return (float) $normalized;
            }
        }
        return null;
    }

    /**
     * Campos obrigatórios não preenchidos.
     * @param array<string, mixed> $campos
     */
    private function verificarCamposVazios(array $campos): array|null
    {
        foreach ($campos as $campo => $valor) {
            if ($valor === null || (is_string($valor) && trim($valor) === '')) {
                return $this->erro($campo, "Campo obrigatório: preencha " . self::ARTIGOS[$campo] . ".");
            }
        }
        return null;
    }

    /**
     * Valores que não são números (ex.: "abc").
     * @param array<string, mixed> $campos
     */

    private function verificarCamposNumericos(array $campos): array|null
    {
        foreach ($campos as $campo => $valor) {
            if ($this->tofloat($valor) === null) {
                return $this->erro($campo, "Valor inválido: informe um número em " . self::NOMES[$campo] . ".");
            }
        }
        return null;

    }

    private function verificarNumerosNegativos(
        float $ph,
        float $cloro_residual,
        float $concentracao_entrada,
        float $concentracao_saida
    ): array|null {
        $valores = [
            'ph' => $ph,
            'cloro' => $cloro_residual,
            'entrada' => $concentracao_entrada,
            'saida' => $concentracao_saida,
        ];

        foreach ($valores as $campo => $valor) {
            if ($valor = 0) {
                return $this->erro($campo, "O valor de " . self::NOMES[$campo] . " não pode ser negativo.");
            }
        }
        return null;
    }

       /**
     * Limites físicos: pH entre 0 e 14; temperatura entre 0 e 100 °C.
     */

        private function verificarLimitesFisicos(float $ph, float $temperatura): array|null{
             if ($ph < 0 || $ph > self::PH_FISICO_MAX) {
            return $this->erro('ph', "Valor impossível: o pH deve estar entre 0 e 14.");
        }
        if ($temperatura < 0 || $temperatura > self::TEMP_FISICA_MAX) {
            return $this->erro('temperatura', "Valor inválido: a temperatura deve estar entre 0 °C e 100 °C.");
        }
        return null;
    }
 
    /**
     * Só a concentração de ENTRADA não pode ser zero (divisão por zero).
     * Saída = 0 é válida (100% de remoção); pH, cloro e temperatura = 0 também.
     */
    private function verifyZeroValues(float $concentracao_entrada): array|null
    {
        if ($concentracao_entrada == 0) {
            return $this->erro('entrada', "A concentração de entrada deve ser maior que zero.");
        }
        return null;
    }
 
    private function verifyOutputGreaterThanInput(float $concentracao_entrada, float $concentracao_saida): array|null
    {
        if ($concentracao_saida > $concentracao_entrada) {
            return $this->erro('saida', "A concentração de saída não pode ser maior que a de entrada.");
        }
        return null;
    }
 
    /**
     * Valida os dados de entrada.
     * @return array|null null = dados válidos; array = primeiro erro encontrado.
     */
    public function validateData(
        mixed $ph,
        mixed $cloro_residual,
        mixed $temperatura,
        mixed $concentracao_entrada,
        mixed $concentracao_saida
    ): array|null {
        $campos = [
            'ph' => $ph,
            'cloro' => $cloro_residual,
            'temperatura' => $temperatura,
            'entrada' => $concentracao_entrada,
            'saida' => $concentracao_saida,
        ];
 
        $erro = $this->verificarcamposvazios($campos);
        if ($erro !== null) {
            return $erro;
        }
 
        $erro = $this->verificarValoresNumericos($campos);
        if ($erro !== null) {
            return $erro;
        }
 
        $n = array_map(fn($valor) => $this->toFloat($valor), $campos);
 
        $erro = $this->verificarNumerosNegativos($n['ph'], $n['cloro'], $n['entrada'], $n['saida']);
        if ($erro !== null) {
            return $erro;
        }
 
        $erro = $this->verificarLimitesFisicos($n['ph'], $n['temperatura']);
        if ($erro !== null) {
            return $erro;
        }
 
        $erro = $this->verificarValoresZerados($n['entrada']);
        if ($erro !== null) {
            return $erro;
        }
 
        return $this->verifyOutputGreaterThanInput($n['entrada'], $n['saida']);
    }
 
    public function classifyPh(float $ph): string
    {
        return $this->classify($ph, self::PH_MIN, self::PH_MAX);
    }
 
    public function classifyCloro(float $cloro_residual): string
    {
        return $this->classify($cloro_residual, self::CLORO_MIN, self::CLORO_MAX);
    }
 
    public function classifyTemperatura(float $temperatura): string
    {
        return $this->classify($temperatura, self::TEMP_MIN, self::TEMP_MAX);
    }
 
    private function classify(float $valor, float $min, float $max): string
    {
        return match (true) {
            $valor < $min => self::ABAIXO,
            $valor > $max => self::ACIMA,
            default => self::ADEQUADO
        };
    }
 
    /**
     * Eficiência do biofiltro em %: (entrada - saída) / entrada * 100.
     * @throws \InvalidArgumentException se a entrada for <= 0
     */
    public function calculateEfficiency(float $concentracao_entrada, float $concentracao_saida): float
    {
        if ($concentracao_entrada <= 0) {
            throw new \InvalidArgumentException("A concentração de entrada deve ser maior que zero.");
        }
 
        return round((($concentracao_entrada - $concentracao_saida) * 100) / $concentracao_entrada, 2);
    }
 
    /**
     * Valida, classifica, calcula a eficiência e gera o parecer final.
     * Se houver erro, retorna só o erro (nada é calculado).
     */
    public function calculatePh(
        mixed $ph,
        mixed $cloro_residual,
        mixed $temperatura,
        mixed $concentracao_entrada,
        mixed $concentracao_saida
    ): array {
        $erro = $this->validateData($ph, $cloro_residual, $temperatura, $concentracao_entrada, $concentracao_saida);
        if ($erro !== null) {
            return $erro; // <- antes o retorno da validação era ignorado
        }
 
        $ph = $this->toFloat($ph);
        $cloro_residual = $this->toFloat($cloro_residual);
        $temperatura = $this->toFloat($temperatura);
        $entrada = $this->toFloat($concentracao_entrada);
        $saida = $this->toFloat($concentracao_saida);
 
        $phClass = $this->classifyPh($ph);
        $cloroClass = $this->classifyCloro($cloro_residual);
        $tempClass = $this->classifyTemperatura($temperatura);
 
        $adequada = $phClass === self::ADEQUADO
            && $cloroClass === self::ADEQUADO
            && $tempClass === self::ADEQUADO;
 
        return [
            "valid" => true,
            "ph" => $ph,
            "cloro" => $cloro_residual,
            "temperatura" => $temperatura,
            "entrada" => $entrada,
            "saida" => $saida,
            "phClass" => $phClass,
            "cloroClass" => $cloroClass,
            "temperaturaClass" => $tempClass,
            "eficiencia" => $this->calculateEfficiency($entrada, $saida),
            "parecer" => $adequada ? "Amostra adequada" : "Amostra inadequada"
        ];
    }
 
    /**
     * Calcula e, somente se os dados forem válidos, salva a amostra.
     */
    public function saveSample(
        mixed $ph,
        mixed $cloro_residual,
        mixed $temperatura,
        mixed $concentracao_entrada,
        mixed $concentracao_saida
    ): array {
        $result = $this->calculatePh($ph, $cloro_residual, $temperatura, $concentracao_entrada, $concentracao_saida);
 
        if (!$result['valid']) {
            $result['saved'] = false;
            return $result;
        }
 
        $result['saved'] = $this->PhModel->createPH(
            $result['ph'],
            $result['cloro'],
            $result['temperatura'],
            $result['entrada'],
            $result['saida'],
            $result['eficiencia'],
            $result['parecer']
        );
 
        return $result;
 
    }

}