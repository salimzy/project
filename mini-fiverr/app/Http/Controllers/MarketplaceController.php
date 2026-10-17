<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(Request $request): View
    {
        $gigs = Gig::query()
            ->with(['seller', 'category'])
            ->where('status', 'approved')
            ->when($request->string('search')->trim()->value(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->integer('category'), fn ($query, int $category) => $query->where('category_id', $category))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('marketplace.index', [
            'gigs' => $gigs,
            'categories' => Category::query()->orderBy('name')->get(),
            'search' => $request->string('search')->value(),
        ]);
    }

    public function show(Gig $gig): View
    {
        abort_unless($gig->status === 'approved' || auth()->id() === $gig->user_id, 404);

        return view('marketplace.show', ['gig' => $gig->load(['seller', 'category'])]);
    }

    public function create(): View
    {
        return view('gigs.form', [
            'gig' => new Gig(['packages' => [
                ['name' => 'Basic', 'description' => '', 'price' => 25],
                ['name' => 'Standard', 'description' => '', 'price' => 75],
                ['name' => 'Premium', 'description' => '', 'price' => 150],
            ]]),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $gig = $request->user()->gigs()->create($this->validated($request));

        return to_route('gigs.show', $gig)->with('status', 'Your gig is submitted for review.');
    }

    public function edit(Gig $gig): View
    {
        $this->authorize('update', $gig);

        return view('gigs.form', [
            'gig' => $gig,
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Gig $gig): RedirectResponse
    {
        $this->authorize('update', $gig);
        $gig->update($this->validated($request) + ['status' => 'pending']);

        return to_route('gigs.show', $gig)->with('status', 'Gig updated and resubmitted for review.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:5000'],
            'delivery_days' => ['required', 'integer', 'min:1', 'max:90'],
            'basic_price' => ['required', 'numeric', 'min:5'],
            'standard_price' => ['required', 'numeric', 'min:5'],
            'premium_price' => ['required', 'numeric', 'min:5'],
        ]);

        $data['packages'] = collect(['basic', 'standard', 'premium'])->map(fn (string $name) => [
            'name' => ucfirst($name),
            'description' => $name === 'basic' ? 'A focused starting point.' : ($name === 'standard' ? 'A complete solution for most needs.' : 'The full premium experience.'),
            'price' => (float) $data["{$name}_price"],
        ])->all();
        unset($data['basic_price'], $data['standard_price'], $data['premium_price']);

        return $data;
    }
}
