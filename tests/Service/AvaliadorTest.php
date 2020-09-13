<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    /**
     * @dataProvider obtemLeiloes
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao  $leilao)
    {

        $leiloeiro = new Avaliador();

        // Act - When / Executamos o código a ser testado
        $leiloeiro->avalia($leilao);

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(2500, $leiloeiro->getMaiorValor());

    }

    /**
     * @dataProvider obtemLeiloes
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao  $leilao)
    {
        $leiloeiro = new Avaliador();

        // Act - When / Executamos o código a ser testado
        $leiloeiro->avalia($leilao);

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(1000, $leiloeiro->getMenorValor());

    }

    /**
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveRetornarOsTresMaioresValores(Leilao $leilao)
    {
        $avaliador = new Avaliador();

        $avaliador->avalia($leilao);

        $maiores = $avaliador->getMaioresLances();
        self::assertCount(3, $maiores);
        self::assertEquals(2500, $maiores[0]->getValor());
        self::assertEquals(2000, $maiores[1]->getValor());
        self::assertEquals(1500, $maiores[2]->getValor());

    }

    public function obtemLeiloes()
    {
        return [
            $this->leilaoEmOrdemCrescente()[0],
            $this->leilaoEmOrdemDecrescente()[0],
            $this->leilaoEmOrdemAleatoria()[0]
        ];
    }

    /**
     * @return Leilao[]
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

        return [[$leilao]];
    }

    /**
     * @return Leilao[]
     */
    public function leilaoEmOrdemDecrescente(): array
    {
        // Arrange - Given / Preparamos o cenário do teste
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $luiz = new Usuario('Luiz');
        $jose = new Usuario('Jose');

        $leilao->recebeLance(new Lance($luiz, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($jose, 1000));

        return [[$leilao]];
    }

    /**
     * @return Leilao[]
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

        return [[$leilao]];
    }
}