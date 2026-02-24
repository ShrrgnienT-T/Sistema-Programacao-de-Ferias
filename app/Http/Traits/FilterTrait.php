<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait FilterTrait
{
    /**
     * Lista de colunas que devem usar pesquisa exata.
     *
     * @var array<int, string>
     */
    protected array $exactMatchFields = [
        'plate_number',
        'lumberLog_picking_list',
    ];

    /**
     * Alias de chaves de filtro para colunas reais.
     * Ex.: ['responsible_doctor_id' => 'responsible']
     *
     * @var array<string, string>
     */
    protected array $filterAliases = [];

    /**
     * Colunas de data que aceitam filtros *_start e *_end.
     * Ex.: ['entry_date']
     *
     * @var array<int, string>
     */
    protected array $rangeDateFields = [];

    /**
     * Colunas do model usadas na busca global via ?search=
     *
     * @var array<int, string>
     */
    protected array $searchableColumns = [];

    /**
     * Relações/colunas usadas na busca global via ?search= no formato relation.column
     *
     * @var array<int, string>
     */
    protected array $searchableRelations = [];

    protected function filter(Builder $query, Request $request): void
    {
        foreach ($request->query() as $key => $value) {
            if ($key === 'page' || ! $request->filled($key)) {
                continue;
            }

            $key = $this->normalizeFilterKey($key);

            if ($key === 'search') {
                $this->handleSearchFilter($query, (string) $value);

                continue;
            }

            if ($this->isRangeDateFilter($key)) {
                $this->handleRangeDateFilter($query, $key, (string) $value);

                continue;
            }

            if (str_contains($key, '.')) {
                [$relation, $field] = explode('.', $key, 2);

                $query->whereHas($relation, function (Builder $subQuery) use ($field, $value) {
                    if (in_array($field, $this->exactMatchFields, true)) {
                        $subQuery->where($field, '=', $value);
                    } else {
                        $subQuery->where($field, 'like', '%'.$value.'%');
                    }
                });

                continue;
            }

            if ($this->isRelationFilter($key)) {
                if ($this->isDateColumn($query, $key)) {
                    $this->handleDateFilter($query, $key, (string) $value);
                } else {
                    $this->handleRelationFilter($query, $key, (string) $value);
                }
            } else {
                if ($this->isDateColumn($query, $key)) {
                    $this->handleDateFilter($query, $key, (string) $value);
                } else {
                    $this->handleColumnFilter($query, $key, (string) $value);
                }
            }
        }
    }

    private function isRelationFilter(string $key): bool
    {
        return str_contains($key, '_');
    }

    private function isDateColumn(Builder $query, string $column): bool
    {
        $model = $query->getModel();
        $schemaBuilder = $model->getConnection()->getSchemaBuilder();
        $table = $model->getTable();

        $columns = $schemaBuilder->getColumnListing($table);

        foreach ($columns as $col) {
            if ($col === $column) {
                $type = $schemaBuilder->getColumnType($table, $col);

                return in_array($type, ['date', 'datetime', 'timestamp'], true);
            }
        }

        return false;
    }

    private function handleRelationFilter(Builder $query, string $key, string $value): void
    {
        if ($key === 'company_name' || $key === 'companies_name') {
            $relation = Str::before($key, '_');
            $query->whereHas($relation, function (Builder $subQuery) use ($value) {
                $subQuery->where('name', 'like', "%{$value}%");
            });

            return;
        }

        [$relation, $field] = $this->parseRelationAndField($key);

        if (method_exists($query->getModel(), $relation)) {
            $this->applySubqueryFilter($query, $relation, $field, $value);

            return;
        }

        $this->handleColumnFilter($query, $key, $value);
    }

    private function handleDateFilter(Builder $query, string $column, string $value): void
    {
        $date = Carbon::parse($value)->format('Y-m-d');
        $query->whereDate($column, $date);
    }

    private function handleColumnFilter(Builder $query, string $column, string $value): void
    {
        if ($this->columnExists($query, $column)) {
            $this->applyColumnFilter($query, $column, $value);
        }
    }

    /**
     * @return array{0:string,1:string}
     */
    private function parseRelationAndField(string $key): array
    {
        $parts = explode('_', $key);
        $relation = array_shift($parts);
        $field = implode('_', $parts);

        return [$relation, $field];
    }

    private function columnExists(Builder $query, string $column): bool
    {
        return $query->getModel()->getConnection()->getSchemaBuilder()
            ->hasColumn($query->getModel()->getTable(), $column);
    }

    protected function applyColumnFilter(Builder $query, string $column, string $value): void
    {
        if (in_array($column, $this->exactMatchFields, true)) {
            $query->where($column, '=', $value);
        } else {
            $query->where($column, 'like', "%{$value}%");
        }
    }

    protected function applySubqueryFilter(Builder $query, string $relation, string $relationKey, string $value): void
    {
        $query->whereHas($relation, function (Builder $subQuery) use ($relationKey, $value) {
            if ($this->isDateColumn($subQuery, $relationKey)) {
                $this->handleDateFilter($subQuery, $relationKey, $value);
            } elseif ($this->columnExists($subQuery, $relationKey)) {
                if (in_array($relationKey, $this->exactMatchFields, true)) {
                    $subQuery->where($relationKey, '=', $value);
                } else {
                    $subQuery->where($relationKey, 'like', "%{$value}%");
                }
            }
        });
    }

    private function normalizeFilterKey(string $key): string
    {
        return $this->filterAliases[$key] ?? $key;
    }

    private function isRangeDateFilter(string $key): bool
    {
        return str_ends_with($key, '_start') || str_ends_with($key, '_end');
    }

    private function handleRangeDateFilter(Builder $query, string $key, string $value): void
    {
        $operator = str_ends_with($key, '_start') ? '>=' : '<=';
        $column = str_replace(['_start', '_end'], '', $key);

        if (! in_array($column, $this->rangeDateFields, true)) {
            return;
        }

        if (! $this->columnExists($query, $column)) {
            return;
        }

        $date = Carbon::parse($value)->format('Y-m-d');
        $query->whereDate($column, $operator, $date);
    }

    private function handleSearchFilter(Builder $query, string $value): void
    {
        $searchValue = trim($value);

        if ($searchValue === '') {
            return;
        }

        if ($this->searchableColumns === [] && $this->searchableRelations === []) {
            return;
        }

        $query->where(function (Builder $searchQuery) use ($searchValue) {
            foreach ($this->searchableColumns as $column) {
                if (! $this->columnExists($searchQuery, $column)) {
                    continue;
                }

                if (in_array($column, $this->exactMatchFields, true)) {
                    $searchQuery->orWhere($column, '=', $searchValue);
                } else {
                    $searchQuery->orWhere($column, 'like', "%{$searchValue}%");
                }
            }

            foreach ($this->searchableRelations as $relationPath) {
                if (! str_contains($relationPath, '.')) {
                    continue;
                }

                [$relation, $field] = explode('.', $relationPath, 2);

                if (! method_exists($searchQuery->getModel(), $relation)) {
                    continue;
                }

                $searchQuery->orWhereHas($relation, function (Builder $relationQuery) use ($field, $searchValue) {
                    if (in_array($field, $this->exactMatchFields, true)) {
                        $relationQuery->where($field, '=', $searchValue);
                    } else {
                        $relationQuery->where($field, 'like', "%{$searchValue}%");
                    }
                });
            }
        });
    }
}
