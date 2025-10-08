<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyBundle\DataContainer;

use Contao\CoreBundle\Slug\Slug;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;

final readonly class LazyAliasGenerator
{

    public function __construct(
        private Slug $slug,
        private Connection $connection
    )
    {
    }

    public function generate(string $text, ?string $alias, DataContainer $dc, string $field = 'alias', string $integerPrefix = 'id-'): string
    {
        if (is_numeric($alias) || $alias === null || trim($alias) === '') {
            $callback = function (string $slug) use ($dc, $field): bool {
                return $this->exists($slug, $dc->id, $dc->table, $field);
            };

            return $this->slug->generate($text, [], $callback, $integerPrefix);
        }

        if ($this->exists($alias, $dc->id, $dc->table, $field)) {
            throw new \RuntimeException(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $alias));
        }

        if (preg_match('/^[1-9]\d*$/', $alias)) {
            throw new \RuntimeException(sprintf($GLOBALS['TL_LANG']['ERR']['aliasNumeric'], $alias));
        }

        return $alias;
    }

    public function exists(string $alias, int|string $id, string $table, string $field = 'alias'): bool
    {
        $statement = $this->connection
            ->prepare("SELECT COUNT(*) FROM `$table` WHERE `$field` = ? AND id != ?");

        $statement->bindValue(1, $alias);
        $statement->bindValue(2, $id);

        $result = $statement->executeQuery();

        return $result->fetchOne() !== 0;
    }

}
