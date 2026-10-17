<x-layouts::app :title="__('Find a service')">
    <div class="mx-auto flex w-full max-w-7xl flex-col gap-10 px-4 py-8 sm:px-6 lg:px-8">
        <section class="overflow-hidden rounded-3xl bg-[#173f35] px-6 py-12 text-white shadow-xl sm:px-12 lg:flex lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-[#f4b942]">Independent work, made simple</p>
                <h1 class="text-4xl font-semibold tracking-tight sm:text-6xl">Find the right person for the work.</h1>
                <p class="mt-5 max-w-xl text-lg leading-8 text-emerald-50/80">Browse thoughtful services from people who care about the details.</p>
            </div>
            @auth
                <a href="{{ route('gigs.create') }}" class="mt-8 inline-flex shrink-0 items-center justify-center rounded-full bg-[#f4b942] px-6 py-3 text-sm font-semibold text-[#173f35] transition hover:bg-white lg:mt-0">Offer a service</a>
            @endauth
        </section>

        <form method="GET" class="grid gap-3 rounded-2xl border border-stone-200 bg-white p-3 shadow-sm sm:grid-cols-[1fr_220px_auto]">
            <input name="search" value="{{ $search }}" placeholder="What do you need help with?" class="rounded-xl border-0 bg-stone-50 px-4 py-3 text-sm outline-none ring-0 placeholder:text-stone-400 focus:ring-2 focus:ring-emerald-700">
            <select name="category" class="rounded-xl border-0 bg-stone-50 px-4 py-3 text-sm text-stone-700 outline-none focus:ring-2 focus:ring-emerald-700">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="rounded-xl bg-[#173f35] px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-900">Search</button>
        </form>

        <section>
            <div class="mb-5 flex items-end justify-between"><div><p class="text-sm font-medium text-amber-700">Curated services</p><h2 class="mt-1 text-2xl font-semibold text-stone-900">Popular right now</h2></div><span class="text-sm text-stone-500">{{ $gigs->total() }} services</span></div>
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($gigs as $gig)
                    <a href="{{ route('gigs.show', $gig) }}" class="group overflow-hidden rounded-2xl border border-stone-200 bg-white transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex h-40 items-end bg-gradient-to-br from-[#dceee5] via-[#b8d7c8] to-[#f4b942] p-5"><span class="rounded-full bg-white/80 px-3 py-1 text-xs font-semibold text-[#173f35]">{{ $gig->category->name }}</span></div>
                        <div class="p-5"><p class="text-xs font-medium text-stone-500">{{ $gig->seller->name }} · {{ $gig->delivery_days }} day delivery</p><h3 class="mt-2 line-clamp-2 text-lg font-semibold text-stone-900 group-hover:text-emerald-800">{{ $gig->title }}</h3><div class="mt-5 flex items-center justify-between"><span class="text-sm text-amber-700">★★★★★ <span class="text-stone-400">New seller</span></span><span class="font-semibold text-stone-900">From ${{ number_format($gig->packages[0]['price'] ?? 0, 0) }}</span></div></div>
                    </a>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-stone-300 px-6 py-16 text-center text-stone-500">No approved services match that search yet.</div>
                @endforelse
            </div>
            <div class="mt-8">{{ $gigs->links() }}</div>
        </section>
    </div>
</x-layouts::app>