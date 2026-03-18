<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    use \App\Traits\HasNavs;
    use \App\Traits\HasCategory;

    public function index()
    {
        $navs = $this->getNavs();
        $categories = $this->getCategory();

        $orders = Sale::with(['customer', 'items.product'])->latest()->get();

        return view('sales.index', compact('navs', 'categories', 'orders'));
    }

    public function create()
    {
        return view('sales.create', [
            'navs'      => $this->getNavs(),
            'customers' => Customer::all(),
            'products'  => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id', // nullable for walk-in
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            // Auto-generate PO number
            $lastSale = Sale::latest()->first();
            if ($lastSale && preg_match('/SO-(\d+)/', $lastSale->po_number, $matches)) {
                $number = intval($matches[1]) + 1;
            } else {
                $number = 1;
            }
            $poNumber = 'SO-' . str_pad($number, 4, '0', STR_PAD_LEFT);

            $sale = Sale::create([
                'po_number' => $poNumber,
                'customer_id' => $request->customer_id,
                'sale_date' => $request->sale_date,
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $product->price;
                $subtotal = $price * $item['qty'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'unit_price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $item['qty']);
                $total += $subtotal;
            }

            $sale->update(['total_amount' => $total]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale Order created successfully.');
    }

    public function show($id)
    {
        $navs = $this->getNavs();

        // Load sale with items and customer
        $sale = Sale::with(['customer', 'items.product'])->findOrFail($id);

        // Get customers and products if your Blade references them
        $customers = Customer::all();
        $products  = Product::all();

        return view('sales.show', compact('sale', 'navs', 'customers', 'products'));
    }




    public function edit($id)
    {
        $sale = Sale::with(['items'])->findOrFail($id);

        return view('sales.edit', [
            'sale' => $sale,
            'navs' => $this->getNavs(),
            'customers' => Customer::all(),
            'products' => Product::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::with(['items'])->findOrFail($id);

        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $sale) {

            // Restore stock from old items
            foreach ($sale->items as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->increment('stock', $oldItem->quantity);
                }
            }

            $sale->update([
                'customer_id' => $request->customer_id,
                'sale_date' => $request->sale_date,
                'total_amount' => 0,
            ]);

            // Delete old items
            $sale->items()->delete();

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $product->price;
                $subtotal = $price * $item['qty'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'unit_price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $item['qty']);
                $total += $subtotal;
            }

            $sale->update(['total_amount' => $total]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale Order updated successfully.');
    }

    public function destroy($id)
    {
        $sale = Sale::with('items')->findOrFail($id);

        // Restore stock before deleting
        foreach ($sale->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale Order deleted successfully.');
    }
}
