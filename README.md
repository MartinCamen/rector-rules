# Rector Rules

> [!IMPORTANT]
> This project is still being developed and breaking changes might occur even between patch versions.
>
> The aim is to follow semantic versioning as soon as possible.

A small set of [Rector](https://getrector.com) rules for keeping doc blocks tidy.

Both rules rewrite the **raw text** of a doc block rather than its parsed representation, because Rector prints doc
blocks while preserving their original line breaks. A rule that has to change the layout has to work on the text.

## Installation

```bash
composer require --dev martincamen/rector.rules
```

## Rules

### SingleLineDocBlockRector

Collapses a doc block holding a single line of content onto one line.

```php
// Before
/**
 * @throws Throwable
 */
public function handle(): void

// After
/** @throws Throwable */
public function handle(): void
```

Register it:

```php
use MartinCamen\RectorRules\SingleLineDocBlockRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([SingleLineDocBlockRector::class]);
```

#### Options

| Option                  | Type   | Default | Description                                                              |
|-------------------------|--------|---------|--------------------------------------------------------------------------|
| `collapse_descriptions` | `bool` | `false` | Also collapse doc blocks holding a plain description instead of an annotation. |
| `max_line_length`       | `int`  | `120`   | Leave a doc block alone when collapsing it would make the line longer than this. Use `0` for no limit. |

```php
->withConfiguredRule(SingleLineDocBlockRector::class, [
    SingleLineDocBlockRector::COLLAPSE_DESCRIPTIONS => true,
    SingleLineDocBlockRector::MAX_LINE_LENGTH       => 100,
]);
```

Passing an unknown option, or one of the wrong type, throws a `Rector\Exception\Configuration\InvalidConfigurationException`.

#### Behaviour

- Applies to classes, interfaces, traits, enums, enum cases, class constants, properties, methods and functions.
- Blank lines inside the doc block are ignored when counting content, so a padded single-line block still collapses.
- Doc blocks with two or more lines of content are left alone.
- Plain descriptions are left alone unless `collapse_descriptions` is enabled.
- The line length check accounts for the indentation of the code being documented.
- Surrounding comments and attributes are preserved.

### MergeThrowsTagsRector

Merges the `@throws` tags of a doc block into a single alphabetically sorted union tag.

```php
// Before
/**
 * @throws SecondException
 * @throws FirstException
 */
public function handle(): void

// After
/**
 * @throws FirstException|SecondException
 */
public function handle(): void
```

Register it:

```php
use MartinCamen\RectorRules\MergeThrowsTagsRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([MergeThrowsTagsRector::class]);
```

#### Behaviour

- Duplicate types are dropped, and an existing union is sorted even when there is nothing to merge with.
- Sorting happens on the **short** class name, which keeps the order stable once Rector imports the names — it does
  that after this rule has run. So `\Zebra\FirstException|\Apple\SecondException` stays in that order.
- A tag carrying more than a type (`@throws FirstException when the order is already paid`) is left alone, along with
  every other tag in that doc block.
- Tags are only merged when written as one uninterrupted block. Tags separated by a blank line or by another tag are
  left alone, because merging them would leave the lines in between stranded.

This rule does not collapse the doc block onto one line. Register both rules to get that in a single pass — the merged
tag is the only line of content left, so `SingleLineDocBlockRector` collapses it:

```php
->withRules([MergeThrowsTagsRector::class, SingleLineDocBlockRector::class]);
```

```php
// Before
/**
 * @throws SecondException
 * @throws FirstException
 */

// After
/** @throws FirstException|SecondException */
```

## Development

```bash
composer check      # phpstan, phpunit, pint and rector
composer test       # phpunit only
composer pint-fix   # apply code style fixes
```

The rules are covered by [Rector's fixture tests](https://getrector.com/documentation/testing-rules). Each rule has a
directory under `tests/Fixture` and a config under `tests/config`, wired together by a test class in `tests/Rector`.

## License

MIT
