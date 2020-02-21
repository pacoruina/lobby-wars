<?php
declare(strict_types=1);

namespace LobbyWars\Infrastructure\CliCommand;

use LobbyWars\Domain;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;

class TrialCommand extends Command
{
    const ROLE_KING_SHORTCUT = 'K';
    const ROLE_NOTARY_SHORTCUT = 'N';
    const ROLE_VALIDATOR_SHORTCUT = 'V';
    const ROLE_BLANK_SHORTCUT = '#';

    const VALID_ROLE_SHORTCUTS = [
        self::ROLE_KING_SHORTCUT,
        self::ROLE_NOTARY_SHORTCUT,
        self::ROLE_VALIDATOR_SHORTCUT,
        self::ROLE_BLANK_SHORTCUT,
    ];

    /** @var ContainerInterface */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function composeContract(string $id, string $input): Domain\Contract\Contract
    {
        $signList = [];
        $roleShortcuts = str_split($input);
        foreach ($roleShortcuts as $roleShortcut) {
            if (in_array(strtoupper($roleShortcut), self::VALID_ROLE_SHORTCUTS)) {
                if (self::ROLE_KING_SHORTCUT === strtoupper($roleShortcut)) {
                    $signList[] = new Domain\Contract\Sign(new Domain\Role\King());
                } elseif (self::ROLE_NOTARY_SHORTCUT === strtoupper($roleShortcut)) {
                    $signList[] = new Domain\Contract\Sign(new Domain\Role\Notary());
                } elseif (self::ROLE_VALIDATOR_SHORTCUT === strtoupper($roleShortcut)) {
                    $signList[] = new Domain\Contract\Sign(new Domain\Role\Validator());
                } else {
                    $signList[] = new Domain\Contract\Sign(null);
                }
            } else {
                throw new \InvalidArgumentException(
                    'Invalid role input ' . $roleShortcut . ', valid are ' . implode(',', self::VALID_ROLE_SHORTCUTS)
                );
            }
        }

        return new Domain\Contract\Contract($id, $signList);
    }
}
