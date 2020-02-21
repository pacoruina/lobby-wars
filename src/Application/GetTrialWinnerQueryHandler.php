<?php
declare(strict_types=1);

namespace LobbyWars\Application;

class GetTrialWinnerQueryHandler
{
    const TIE_TRIAL = 'TIE_TRIAL';

    public function __invoke(GetTrialWinnerQuery $query): GetTrialWinnerResponse
    {
        if ($query->getDefendantContract()->getPoints() > $query->getPlaintiffContract()->getPoints()) {
            $winnerId = $query->getDefendantContract()->getId();
        } elseif ($query->getDefendantContract()->getPoints() < $query->getPlaintiffContract()->getPoints()) {
            $winnerId = $query->getPlaintiffContract()->getId();
        } else {
            $winnerId = self::TIE_TRIAL;
        }

        return new GetTrialWinnerResponse($winnerId);
    }
}
