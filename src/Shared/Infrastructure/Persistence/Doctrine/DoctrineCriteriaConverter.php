<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterField;
use Shared\Domain\Criteria\OrderBy;

use function array_key_exists;
use function array_map;

final class DoctrineCriteriaConverter
{
    private Criteria $criteria;
    private array $criteriaToDoctrineFields;
    private array $hydrators;

    public function __construct(Criteria $criteria, array $criteriaToDoctrineFields = [], array $hydrators = [])
    {
        $this->criteria = $criteria;
        $this->criteriaToDoctrineFields = $criteriaToDoctrineFields;
        $this->hydrators = $hydrators;
    }

    public static function convert(
        Criteria $criteria,
        array $criteriaToDoctrineFields = [],
        array $hydrators = []
    ): DoctrineCriteria {
        $converter = new self($criteria, $criteriaToDoctrineFields, $hydrators);

        return $converter->convertToDoctrineCriteria();
    }

    public static function convertToCount(
        Criteria $criteria,
        array $criteriaToDoctrineFields = [],
        array $hydrators = []
    ): DoctrineCriteria {
        $converter = new self($criteria, $criteriaToDoctrineFields, $hydrators);

        return $converter->convertToDoctrineCriteriaToCount();
    }

    public function convertToDoctrineCriteria(): DoctrineCriteria
    {
        return new DoctrineCriteria(
            $this->buildExpression($this->criteria),
            $this->formatOrder($this->criteria),
            $this->criteria->offset(),
            $this->criteria->limit()
        );
    }

    private function convertToDoctrineCriteriaToCount(): DoctrineCriteria
    {
        return new DoctrineCriteria($this->buildExpression($this->criteria), $this->formatOrder($this->criteria));
    }

    private function buildExpression(Criteria $criteria): ?CompositeExpression
    {
        if (!$criteria->hasFilters()) {
            return null;
        }

        return new CompositeExpression(
            CompositeExpression::TYPE_AND,
            array_map($this->buildComparison(), $criteria->plainFilters())
        );
    }

    private function buildComparison(): callable
    {
        return function (Filter $filter): Comparison {
            $field = $this->mapFieldValue($filter->field());
            $value = $this->existsHydratorFor($field) ?
                $this->hydrate($field, $filter->value()->value()) :
                $filter->value()->value();

            return new Comparison($field, $filter->operator()->value(), $value);
        };
    }

    private function mapFieldValue(FilterField $field): string
    {
        return array_key_exists($field->value(), $this->criteriaToDoctrineFields) ?
            $this->criteriaToDoctrineFields[$field->value()] :
            $field->value();
    }

    private function existsHydratorFor(string $field): bool
    {
        return array_key_exists($field, $this->hydrators);
    }

    private function hydrate(string $field, string $value)
    {
        return $this->hydrators[$field]($value);
    }

    private function formatOrder(Criteria $criteria): ?array
    {
        if (!$criteria->hasOrder()) {
            return null;
        }

        return [$this->mapOrderBy($criteria->order()->by()) => $criteria->order()->type()];
    }

    private function mapOrderBy(OrderBy $field): string
    {
        return array_key_exists($field->value(), $this->criteriaToDoctrineFields) ?
            $this->criteriaToDoctrineFields[$field->value()] :
            $field->value();
    }
}
