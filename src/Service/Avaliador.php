<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Leilao;

class Avaliador
{
    private float $maiorLance = -INF;
    private $menorLance = INF;

    public function avalia(Leilao $leilao): void
    {
        foreach ($leilao->getLances() as $lance) {
            if ($lance->getValor() > $this->maiorLance) {
                $this->maiorLance = $lance->getValor();
            }
            if ($lance->getValor() < $this->menorLance) {
                $this->menorLance = $lance->getValor();
            }
        }
    }

    public function getMaiorValor(): float
    {
        return $this->maiorLance;
    }

    public function getMenorValor(): float
    {
        return $this->menorLance;
    }
}