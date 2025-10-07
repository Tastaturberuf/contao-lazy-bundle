<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyBundle\Contao;

use Contao\Model;
use InvalidArgumentException;

final readonly class ContaoConfig
{

    /**
     * Registers a model class for use within the application.
     *
     * This method ensures that the provided model class exists, is a subclass of the base `Model` class,
     * and optionally forces registration even if it is already registered.
     * The model will be assigned to the global `$GLOBALS['TL_MODELS']` array using its table name as the key.
     *
     * @param string $model The fully qualified class name of the model to register.
     * @param bool $force Optional. Whether to overwrite an existing registration. Defaults to false.
     *
     * @throws InvalidArgumentException If the class does not exist.
     * @throws InvalidArgumentException If the class is not a subclass of Model.
     * @throws InvalidArgumentException If the model is already registered and the force flag is false.
     */
    public static function registerModel(string $model, bool $force = false): void
    {
        if (!class_exists($model)) {
            throw new InvalidArgumentException(sprintf('Class "%s" does not exist.', $model));
        }

        if (!is_a($model, Model::class, true)) {
            throw new InvalidArgumentException(sprintf('Invalid model class "%s". Must be a subclass of %s.', $model, Model::class));
        }

        $table = $model::getTable();

        if (array_key_exists($table, $GLOBALS['TL_MODELS'] ?? []) && !$force) {
            throw new InvalidArgumentException(sprintf('Model "%s" is already registered.', $model));
        }

        $GLOBALS['TL_MODELS'][$table] = $model;
    }

    public static function registerModels(...$models): void
    {
        foreach ($models as $model) {
            self::registerModel($model);
        }
    }

}
