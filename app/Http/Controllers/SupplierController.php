<?php

namespace App\Http\Controllers;

use App\Models\Supplier;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use \App\Traits\HasNavs;

    public function index()
    {
        $navs = $this->getNavs();
        $suppliers = Supplier::latest()->get();
        return view('suppliers.index', compact('suppliers', 'navs'));
    }

    public function create()
    {
        $navs = $this->getNavs();
        return view('suppliers.create', compact('navs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
        ]);

        Supplier::create($request->only('name', 'phone', 'email', 'address'));

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier added successfully');
    }
    public function edit(Supplier $supplier)
    {
        $navs = $this->getNavs();
        return view('suppliers.edit', compact('supplier', 'navs'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
        ]);

        $supplier->update($request->only('name', 'phone', 'email', 'address'));

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier updated successfully');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully');
    }
}
