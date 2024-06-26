<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersList extends Component
{
    use WithPagination;

    public array $selected = [];

    public string $sortColumn = 'orders.order_date';

    public string $sortDirection = 'asc';

    public array $searchColumns = [
        'username' => '',
        'order_date' => ['', ''],
        'subtotal' => ['', ''],
        'total' => ['', ''],
        'taxes' => ['', ''],
    ];

    public function render(): View
    {
        $orders = Order::query()
            ->select(['orders.*', 'users.name as username'])
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->with('products');

        foreach ($this->searchColumns as $column => $value) {
            if (!empty($value)) {
                $orders->when($column == 'order_date', function ($orders) use ($value) {
                    if (!empty($value[0])) {
                        $orders->whereDate('orders.order_date', '>=', Carbon::parse($value[0])->format('Y-m-d'));
                    }
                    if (!empty($value[1])) {
                        $orders->whereDate('orders.order_date', '<=', Carbon::parse($value[1])->format('Y-m-d'));
                    }
                })
                    ->when($column == 'username', fn ($orders) => $orders->where('users.name', 'LIKE', '%' . $value . '%'))
                    ->when($column == 'subtotal', function ($orders) use ($value) {
                        if (is_numeric($value[0])) {
                            $orders->where('orders.subtotal', '>=', $value[0] * 100);
                        }
                        if (is_numeric($value[1])) {
                            $orders->where('orders.subtotal', '<=', $value[1] * 100);
                        }
                    })
                    ->when($column == 'taxes', function ($orders) use ($value) {
                        if (is_numeric($value[0])) {
                            $orders->where('orders.taxes', '>=', $value[0] * 100);
                        }
                        if (is_numeric($value[1])) {
                            $orders->where('orders.taxes', '<=', $value[1] * 100);
                        }
                    })
                    ->when($column == 'total', function ($orders) use ($value) {
                        if (is_numeric($value[0])) {
                            $orders->where('orders.total', '>=', $value[0] * 100);
                        }
                        if (is_numeric($value[1])) {
                            $orders->where('orders.total', '<=', $value[1] * 100);
                        }
                    });
            }
        }

        $orders->orderBy($this->sortColumn, $this->sortDirection);

        return view('livewire.orders-list', [
            'orders' => $orders->paginate(10)
        ]);
    }


    public function deleteConfirm(string $method, $id = null)
    {
        $this->dispatch('swal:confirm', [
            'type'  => 'warning',
            'title' => 'Are you sure?',
            'text'  => '',
            'id'    => $id,
            'method' => $method,
        ]);
    }

    #[On('delete')]
    public function delete(int $id): void
    {
        $product = Product::findOrFail($id);

        if ($product->orders()->exists()) {
            $this->addError('orderexist', 'This product cannot be deleted, it already has orders');
            return;
        }

        $product->delete();
    }

    #[On('deleteSelected')]
    public function deleteSelected(): void
    {

        $products = Product::with('orders')->whereIn('id', $this->selected)->get();

        foreach ($products as $product) {
            if ($product->orders()->exists()) {
                $this->addError("orderexist", "Product <span class='font-bold'>{$product->name}</span> cannot be deleted, it already has orders");
                return;
            }
        }

        $this->orders->each->delete();

        $this->reset('selected');
    }

    public function getSelectedCountProperty(): int
    {
        return count($this->selected);
    }

    public function sortByColumn($column): void
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }
}
