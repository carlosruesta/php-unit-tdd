<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Leilao;

class Avaliador
{
    private float $maiorLance = -INF;

    public function avalia(Leilao $leilao): void
    {
        foreach ($leilao->getLances() as $lance) {
            if ($lance->getValor() > $this->maiorLance) {
                $this->maiorLance = $lance->getValor();
            }
        }
    }

    public function getMaiorValor(): float
    {
        return $this->maiorLance;
    }
}