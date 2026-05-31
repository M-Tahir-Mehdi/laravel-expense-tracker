<x-app-layout>
    <!-- Top Portion: Dashboard Title with Icon -->
    <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
        <h2 class="font-bold text-3xl text-amber-100 flex items-center gap-2">
            💰 Expense Tracker Dashboard
        </h2>
    </div>

    <!-- Main Content Area -->
    <div class="py-6 min-h-screen" style="background-color: #1a0f00;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 3 TOP STATS CARDS (Exact like image_a5a466.png) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Spent Card -->
                <div style="background-color: #572a08;" class="p-5 rounded-xl border border-amber-900/20 shadow-lg">
                    <p class="text-sm font-semibold text-amber-300/70 uppercase tracking-wider">Total Spent</p>
                    <p class="text-3xl font-extrabold text-white mt-1">PKR {{ number_format($expenses->sum('amount'), 2) }}</p>
                </div>

                <!-- This Month Card -->
               <div style="background-color: #572a08;" class="p-5 rounded-xl border border-amber-900/20 shadow-lg">
                    <p class="text-sm font-semibold text-amber-300/70 uppercase tracking-wider">This Month</p>
                    <p class="text-3xl font-extrabold text-white mt-1">{{ $expenses->count() }} items</p>
                </div>

                <!-- Top Category Card -->
                <div style="background-color: #572a08;" class="p-5 rounded-xl border border-amber-900/20 shadow-lg">
                    <p class="text-sm font-semibold text-amber-300/70 uppercase tracking-wider">Top Category</p>
                    <p class="text-3xl font-extrabold text-white mt-1">
                        {{ $expenses->groupBy('category')->map->sum('amount')->sortDesc()->keys()->first() ?? 'None' }}
                    </p>
                </div>
            </div>

            <!-- Main Layout Grid: Form & History -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-4">
                
                <!-- Left Side: Add Expense Card -->
                <div style="background-color: #572a08;" class="rounded-xl shadow-xl border border-amber-900/20 overflow-hidden h-fit">
                   <div style="background-color: #a14d0f;" class="px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            + Add New Expense
                        </h3>
                    </div>
                    
                    <form action="{{ route('expenses.store') }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-amber-300/80 uppercase tracking-wider mb-1.5">Item / Title</label>
                            <input type="text" name="title" required placeholder="e.g. Starbucks, Grocery" style="background-color: #3d1f07;" class="w-full rounded-xl border-amber-800/30 text-white placeholder-amber-700/60 shadow-inner focus:border-amber-400 focus:ring-amber-400 font-medium text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-amber-300/80 uppercase tracking-wider mb-1.5">Amount (PKR)</label>
                            <input type="number" step="0.01" name="amount" required placeholder="0.00" style="background-color: #3d1f07;" class="w-full rounded-xl border-amber-800/30 text-white placeholder-amber-700/60 shadow-inner focus:border-amber-400 focus:ring-amber-400 font-medium text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-amber-300/80 uppercase tracking-wider mb-1.5">Category</label>
                            <select name="category" required style="background-color: #3d1f07;" class="w-full rounded-xl border-amber-800/30 text-white shadow-inner focus:border-amber-400 focus:ring-amber-400 font-medium text-sm">
                                <option value="" disabled selected class="text-amber-700">Select Category</option>
                                <option value="Food">Food</option>
                                <option value="Transport">Transport</option>
                                <option value="Bills">Bills</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Shopping">Shopping</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-amber-300/80 uppercase tracking-wider mb-1.5">Date</label>
                            <input type="date" name="expense_date" required value="{{ date('Y-m-d') }}" style="background-color: #3d1f07;" class="w-full rounded-xl border-amber-800/30 text-white shadow-inner focus:border-amber-400 focus:ring-amber-400 font-medium text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-amber-300/80 uppercase tracking-wider mb-1.5">Description (Optional)</label>
                            <textarea name="description" rows="2" placeholder="Enter Short Description..." style="background-color: #3d1f07;" class="w-full rounded-xl border-amber-800/30 text-white placeholder-amber-700/60 shadow-inner focus:border-amber-400 focus:ring-amber-400 font-medium text-sm"></textarea>
                        </div>

                       <button type="submit" style="background-color: #a14d0f;" class="w-full hover:bg-amber-800 text-white font-bold py-2.5 px-4 rounded-lg transition duration-150 shadow-md uppercase tracking-wider text-xs">
                         Save Expense
                       </button>
                    </form>
                </div>

                <!-- Right Side: Expenses History Table Box -->
                <div style="background-color: #572a08;" class="lg:col-span-2 rounded-xl shadow-xl border border-amber-900/20 overflow-hidden">
                    <div style="background-color: #a14d0f;" class="px-6 py-4">
                        <h3 class="text-lg font-bold text-white">
                            📋 History of Expenses
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-amber-600/80 font-bold text-xs uppercase tracking-wider border-b border-amber-900/30">
                                    <th class="p-4">Item / Title</th>
                                    <th class="p-4">Category</th>
                                    <th class="p-4">Amount</th>
                                    <th class="p-4">Date</th>
                                    <th class="p-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-900/20 text-sm">
                                @forelse($expenses as $expense)
                                    <tr class="hover:bg-amber-950/20 transition duration-100">
                                        <td class="p-4">
                                            <div class="font-bold text-white text-base">{{ $expense->title }}</div>
                                            @if($expense->description)
                                                <div class="text-xs text-amber-300/50 mt-0.5 font-medium">{{ $expense->description }}</div>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <span style="background-color: #3d1f07;" class="px-3 py-1 rounded-full text-xs font-bold text-amber-300 border border-amber-700/40">
                                                {{ $expense->category }}
                                            </span>
                                        </td>
                                        <td class="p-4 font-extrabold text-white text-base">
                                            PKR {{ number_format($expense->amount, 2) }}
                                        </td>
                                        <td class="p-4 text-amber-200/80 font-medium">
                                            {{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}
                                        </td>
                                        <td class="p-4 text-center">
                                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs bg-rose-950/40 hover:bg-rose-900/60 text-rose-300 font-bold px-3 py-1.5 rounded-xl transition duration-150 border border-rose-900/40">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-12 text-center text-amber-300/40 font-medium">
                                            No expenses recorded yet. Start adding above!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>