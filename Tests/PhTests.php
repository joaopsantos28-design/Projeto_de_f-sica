<?php


use PHPUnit\Framework\TestCase;

use Controller\PhController;
use Model\PHs;

class PhTest extends TestCase
{

    private $mockPhModel; 
    private $phController;

    // Executa ANTES de CADA teste
    protected function setUp(): void
    {
        $this->mockPhModel = $this->createMock(PHs::class);
        $this->phController = new PhController($this->mockPhModel);
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_calculate_a_valid_sample() 
    {
        $result = $this->phController->calcularPh(7.2, 1.0, 25.0, 100.0, 20.0);

        $this->assertTrue($result['valid']);

        $this->assertArrayHasKey('phClass', $result);
        $this->assertArrayHasKey('cloroClass', $result);
        $this->assertArrayHasKey('temperaturaClass', $result);
        $this->assertArrayHasKey('eficiencia', $result);
        $this->assertArrayHasKey('parecer', $result);

        $this->assertEquals('Adequado', $result['phClass']);
        $this->assertEquals('Adequado', $result['cloroClass']);
        $this->assertEquals('Adequado', $result['temperaturaClass']);
        $this->assertEquals(80.0, $result['eficiencia']);
        $this->assertEquals('Amostra adequada', $result['parecer']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_accept_numbers_typed_with_comma() 
    {
        $result = $this->phController->calcularPh('7,2', '1,0', '25', '100', '20');

        $this->assertTrue($result['valid']);
        $this->assertEquals(7.2, $result['ph']);
        $this->assertEquals(80.0, $result['eficiencia']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_accept_valid_values() 
    {
        $this->assertNull($this->phController->validateData(7.0, 1.0, 22.0, 50.0, 10.0));
        $this->assertNull($this->phController->validateData('7,5', '0,5', '18', '200', '40'));
        $this->assertNull($this->phController->validateData(7.0, 1.0, 25.0, 100.0, 0.0));
        $this->assertNull($this->phController->validateData(7.0, 1.0, 25.0, 100.0, 100.0));
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_ph_within_the_reference_range() 
    {
        $this->assertEquals('Adequado', $this->phController->classificarPh(7.0));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_ph_at_the_boundaries() 
    {
        $this->assertEquals('Adequado', $this->phController->classificarPh(6.0));
        $this->assertEquals('Adequado', $this->phController->classificarPh(9.0));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_return_the_ph_classification_in_the_sample_result() 
    {
        $result = $this->phController->calcularPh(7.0, 1.0, 25.0, 100.0, 20.0);

        $this->assertEquals('Adequado', $result['phClass']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_ph_outside_the_reference_range() 
    {
        $this->assertEquals('Abaixo da faixa', $this->phController->classificarPh(5.99));
        $this->assertEquals('Acima da faixa', $this->phController->classificarPh(9.01));
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_chlorine_within_the_reference_range() 
    {
        $this->assertEquals('Adequado', $this->phController->classificarCloro(1.0));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_chlorine_at_the_boundaries() 
    {
        $this->assertEquals('Adequado', $this->phController->classificarCloro(0.2));
        $this->assertEquals('Adequado', $this->phController->classificarCloro(5.0));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_chlorine_outside_the_reference_range() 
    {
        $this->assertEquals('Abaixo da faixa', $this->phController->classificarCloro(0.19));
        $this->assertEquals('Abaixo da faixa', $this->phController->classificarCloro(0.0));
        $this->assertEquals('Acima da faixa', $this->phController->classificarCloro(5.01));
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_a_valid_temperature() 
    {
        $result = $this->phController->calcularPh(7.0, 1.0, 25.0, 100.0, 20.0);

        $this->assertEquals('Adequado', $this->phController->classificarTemperatura(25.0));
        $this->assertEquals('Adequado', $result['temperaturaClass']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_temperature_at_the_boundaries() 
    {
        $this->assertEquals('Adequado', $this->phController->classificarTemperatura(15.0));
        $this->assertEquals('Adequado', $this->phController->classificarTemperatura(30.0));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_classify_temperature_outside_the_defined_criteria()
    {
        $this->assertEquals('Abaixo da faixa', $this->phController->classificarTemperatura(14.9));
        $this->assertEquals('Acima da faixa', $this->phController->classificarTemperatura(30.1));
    }

    // ---------------------------------------------------------------
    // Cenários 14, 15, 16 e 21 — valores inválidos
    // ---------------------------------------------------------------

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_accept_a_physically_invalid_ph() 
    {
        foreach ([-1, '-0,5', 14.01, 15, 'abc'] as $invalidPh) {
            $result = $this->phController->calcularPh($invalidPh, 1.0, 25.0, 100.0, 20.0);

            $this->assertFalse($result['valid']);
            $this->assertEquals('ph', $result['campo']);
            $this->assertArrayHasKey('erro', $result);
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_accept_an_invalid_chlorine()
    {
        foreach ([-0.1, '-2', 'xyz'] as $invalidChlorine) {
            $result = $this->phController->calcularPh(7.0, $invalidChlorine, 25.0, 100.0, 20.0);

            $this->assertFalse($result['valid']);
            $this->assertEquals('cloro', $result['campo']);
            $this->assertArrayHasKey('erro', $result);
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_accept_an_invalid_temperature()
    {
        foreach ([-1, 100.1, 'quente'] as $invalidTemperature) {
            $result = $this->phController->calcularPh(7.0, 1.0, $invalidTemperature, 100.0, 20.0);

            $this->assertFalse($result['valid']);
            $this->assertEquals('temperatura', $result['campo']);
            $this->assertArrayHasKey('erro', $result);
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_accept_the_physical_limits() 
    {
        $this->assertNull($this->phController->validateData(0.0, 1.0, 25.0, 100.0, 20.0));
        $this->assertNull($this->phController->validateData(14.0, 1.0, 25.0, 100.0, 20.0));
        $this->assertNull($this->phController->validateData(7.0, 1.0, 0.0, 100.0, 20.0));
        $this->assertNull($this->phController->validateData(7.0, 1.0, 100.0, 100.0, 20.0));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_present_an_invalid_sample_as_a_valid_result() 
    {
        $result = $this->phController->calcularPh(-1, -1, 500, 100.0, 20.0);

        $this->assertFalse($result['valid']);
        $this->assertEquals('ph', $result['campo']); 

        $this->assertArrayNotHasKey('phClass', $result);
        $this->assertArrayNotHasKey('cloroClass', $result);
        $this->assertArrayNotHasKey('temperaturaClass', $result);
        $this->assertArrayNotHasKey('eficiencia', $result);
        $this->assertArrayNotHasKey('parecer', $result);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_process_a_sample_without_ph() 
    {
        foreach ([null, '', '   '] as $empty) {
            $result = $this->phController->calcularPh($empty, 1.0, 25.0, 100.0, 20.0);

            $this->assertFalse($result['valid']);
            $this->assertEquals('ph', $result['campo']);
            $this->assertEquals('Campo obrigatório: preencha o pH.', $result['erro']);
            $this->assertArrayNotHasKey('parecer', $result);
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_process_a_sample_without_chlorine() 
    {
        foreach ([null, '', '   '] as $empty) {
            $result = $this->phController->calcularPh(7.2, $empty, 25.0, 100.0, 20.0);

            $this->assertFalse($result['valid']);
            $this->assertEquals('cloro', $result['campo']);
            $this->assertEquals('Campo obrigatório: preencha o cloro residual.', $result['erro']);
            $this->assertArrayNotHasKey('parecer', $result);
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_process_a_sample_without_temperature() 
    {
        foreach ([null, '', '   '] as $empty) {
            $result = $this->phController->calcularPh(7.2, 1.0, $empty, 100.0, 20.0);

            $this->assertFalse($result['valid']);
            $this->assertEquals('temperatura', $result['campo']);
            $this->assertEquals('Campo obrigatório: preencha a temperatura.', $result['erro']);
            $this->assertArrayNotHasKey('parecer', $result);
        }
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_calculate_the_biofilter_efficiency()
    {
        $this->assertEquals(80.0, $this->phController->calcularEficiencia(100.0, 20.0));
        $this->assertEquals(50.0, $this->phController->calcularEficiencia(50.0, 25.0));
        $this->assertEquals(100.0, $this->phController->calcularEficiencia(100.0, 0.0));
        $this->assertEquals(0.0, $this->phController->calcularEficiencia(100.0, 100.0));
        $this->assertEquals(66.67, $this->phController->calcularEficiencia(3.0, 1.0));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_divide_by_zero_when_calculating_efficiency()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->phController->calcularEficiencia(0.0, 0.0);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_accept_zero_as_input_concentration()
    {
        $result = $this->phController->calcularPh(7.0, 1.0, 25.0, 0, 0);

        $this->assertFalse($result['valid']);
        $this->assertEquals('entrada', $result['campo']);
        $this->assertArrayNotHasKey('eficiencia', $result);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_accept_negative_concentrations() 
    {
        $result = $this->phController->calcularPh(7.0, 1.0, 25.0, -100, 20);
        $this->assertFalse($result['valid']);
        $this->assertEquals('entrada', $result['campo']);

        $result = $this->phController->calcularPh(7.0, 1.0, 25.0, 100, -20);
        $this->assertFalse($result['valid']);
        $this->assertEquals('saida', $result['campo']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_accept_output_greater_than_input()
    {
        $result = $this->phController->calcularPh(7.0, 1.0, 25.0, 100, 150);

        $this->assertFalse($result['valid']);
        $this->assertEquals('saida', $result['campo']);
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_inadequate_verdict_when_any_parameter_is_outside_the_range()
    {
        $result = $this->phController->calcularPh(5.5, 1.0, 25.0, 100.0, 20.0); // só o pH fora
        $this->assertEquals('Amostra inadequada', $result['parecer']);

        $result = $this->phController->calcularPh(7.0, 0.1, 25.0, 100.0, 20.0); // só o cloro fora
        $this->assertEquals('Amostra inadequada', $result['parecer']);

        $result = $this->phController->calcularPh(7.0, 1.0, 35.0, 100.0, 20.0); // só a temperatura fora
        $this->assertEquals('Amostra inadequada', $result['parecer']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_adequate_verdict_with_all_parameters_at_the_boundaries()
    {
        $result = $this->phController->calcularPh(6.0, 0.2, 15.0, 100.0, 20.0);
        $this->assertEquals('Amostra adequada', $result['parecer']);

        $result = $this->phController->calcularPh(9.0, 5.0, 30.0, 100.0, 20.0);
        $this->assertEquals('Amostra adequada', $result['parecer']);
    }



    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_save_a_valid_sample()
    {
        $this->mockPhModel->expects($this->once())
            ->method('criaPh')
            ->with(7.2, 1.0, 25.0, 100.0, 20.0, 80.0, 'Amostra adequada')
            ->willReturn(true);

        $result = $this->phController->saveSample('7,2', '1', '25', '100', '20');

        $this->assertTrue($result['valid']);
        $this->assertTrue($result['saved']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_report_when_the_database_fails_to_save()
    {
        $this->mockPhModel->method('criaPh')->willReturn(false);

        $result = $this->phController->saveSample(7.0, 1.0, 25.0, 100.0, 20.0);

        $this->assertTrue($result['valid']);
        $this->assertFalse($result['saved']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_save_an_invalid_sample() 
    {
        $this->mockPhModel->expects($this->never())->method('criaPh');

        $result = $this->phController->saveSample('', 1.0, 25.0, 100.0, 20.0);
        $this->assertFalse($result['saved']);

        $result = $this->phController->saveSample(20, 1.0, 25.0, 100.0, 20.0);
        $this->assertFalse($result['saved']);
    }
}
