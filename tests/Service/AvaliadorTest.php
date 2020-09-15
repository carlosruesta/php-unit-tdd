<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{

    private Avaliador $leiloeiro;

    public function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao  $leilao)
    {

        // Act - When / Executamos o código a ser testado
        $this->leiloeiro->avalia($leilao);

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(2500, $this->leiloeiro->getMaiorValor());

    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao  $leilao)
    {
        // Act - When / Executamos o código a ser testado
        $this->leiloeiro->avalia($leilao);

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(1000, $this->leiloeiro->getMenorValor());

    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveRetornarOsTresMaioresValores(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioresLances();
        self::assertCount(3, $maiores);
        self::assertEquals(2500, $maiores[0]->getValor());
        self::assertEquals(2000, $maiores[1]->getValor());
        self::assertEquals(1500, $maiores[2]->getValor());

    }

    public function testLeilaoVazioNaoPodeSerAvaliadoForma1()
    {
        try {
            $leilao = new Leilao('Fusca Azul');
            $this->leiloeiro->avalia($leilao);

            static::fail('Exceção deveria ter sido lançada');
        } catch (\DomainException $exception) {
            static::assertEquals(
                'Não é possível avaliar leilão vazio',
                $exception->getMessage());
        }
    }

    public function testLeilaoVazioNaoPodeSerAvaliadoForma2()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Não é possível avaliar leilão vazio');

        $leilao = new Leilao("Fusca Azul");
        $this->leiloeiro->avalia($leilao);
    }

    public function testLeilaoFinalizadoNaoPodeSerAvaliado()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Leilão já finalizado');

        $leilao = new Leilao('Fiat 147 0KM');
        $leilao->recebeLance(new Lance(new Usuario('Teste'), 2000));
        $leilao->finaliza();

        $this->leiloeiro->avalia($leilao);
        
    }

    /**
     *  Arrange - Given / Preparamos os cenários do testes
     *  Dados para os testes
     */

    public function obtemLeiloes()
    {
        return [
            $this->leilaoEmOrdemCrescente()['lances-ordem-crescente'],
            $this->leilaoEmOrdemDecrescente()['lances-ordem-decrescente'],
            $this->leilaoEmOrdemAleatoria()['lances-ordem-aleatoria']
        ];
    }

    /**
     * @return array
     */
    public function leilaoEmOrdemCrescente(): array
    {
        // Arrange - Given / Preparamos o cenário do teste
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $luiz = new Usuario('Luiz');
        $jose = new Usuario('Jose');

        $leilao->recebeLance(new Lance($jose, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($luiz, 2500));

        return ['lances-ordem-crescente' => [$leilao]];
    }

    /**
     * @return array
     */
    public function leilaoEmOrdemDecrescente(): array
    {
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $luiz = new Usuario('Luiz');
        $jose = new Usuario('Jose');

        $leilao->recebeLance(new Lance($luiz, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($jose, 1000));

        return ['lances-ordem-decrescente' => [$leilao]];
    }

    /**
     * @return array
     */
    public function leilaoEmOrdemAleatoria(): array
    {
        // Arrange - Given / Preparamos o cenário do teste
        $leilao = new Leilao('Fiat 147 0km');
        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $luiz = new Usuario('Luiz');
        $jose = new Usuario('Jose');

        $leilao->recebeLance(new Lance($luiz, 1500));
        $leilao->recebeLance(new Lance($joao, 2500));
        $leilao->recebeLance(new Lance($jose, 1000));
        $leilao->recebeLance(new Lance($maria, 2000));

        return ['lances-ordem-aleatoria' => [$leilao]];
    }
}