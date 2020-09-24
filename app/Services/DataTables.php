<?php


namespace App\Services;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use View;

class DataTables
{
    /**
     * @var array $values
     */
    protected $values = [];

    protected $actions = true;

    /**
     * @var string
     */
    protected $default;
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var array
     */
    private $searchable;

    /**
     * DataTables constructor.
     *
     * @param Builder $builder
     * @param array $searchable
     * @param string $default
     */
    public function __construct(Builder $builder, array $searchable = ['title'], string $default = 'id')
    {
        $this->default = $default;
        $this->builder = $builder;
        $this->searchable = $searchable;
    }

    /**
     * @param $field
     * @return string
     */
    public static function sortableColumn($field): string
    {
        return request()->fullUrlWithQuery(array_merge(
            request()->except('sort'),
            [
                'sort' => $field,
                'order' => request('order', 'desc') === 'desc' ? 'asc' : 'desc'
            ]
        ));
    }

    /**
     * @param string $field
     * @param string $name
     * @param bool $sortable
     * @return $this
     */
    public function add(string $field, string $name, $sortable = true)
    {
        array_push($this->values, (object)[
            'key' => $field,
            'name' => $name,
            'sortable' => $sortable,
            'default' => $field === $this->default
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function noActions()
    {
        $this->actions = false;

        return $this;
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->prepare()->get();
    }

    /**
     * @param int $pagination
     * @return LengthAwarePaginator
     */
    public function paginate($pagination = 25): LengthAwarePaginator
    {
        return $this->prepare()->paginate($pagination);
    }

    /**
     * @return void
     */
    protected function compile(): void
    {
        $values = collect($this->values);

        if (!$values->contains('key', $this->default)) {
            $values->prepend((object)[
                'key' => $this->default,
                'name' => $this->default,
                'sortable' => true,
                'default' => true
            ]);
        }

        if ($this->actions) {
            $values->push((object)[
                'key' => null,
                'name' => null,
                'sortable' => false,
                'default' => false
            ]);
        }

        View::share('fields', collect($values));
    }

    /**
     * @return Builder
     */
    protected function collect(): Builder
    {
        $collection = $this->builder->orderBy(
            request('sort', 'id'),
            request('order', 'desc')
        );

        if (request('search') && count($this->searchable)) {
            foreach ($this->searchable as $key => $field) {
                $condition = $key === 0 ? 'whereRaw' : 'orWhereRaw';

                $collection = $collection->$condition('LOWER(' . $field . ') LIKE "%' . mb_strtolower(request('search')) . '%"');
            }
        }

        return $collection;
    }

    /**
     * @return Builder
     */
    protected function prepare(): Builder
    {
        $this->compile();

        return $this->collect();
    }
}
