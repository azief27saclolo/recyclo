<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4">Checkout</h2>
                    
                    <div class="mb-4">
                        <h3 class="font-bold">Item Details:</h3>
                        <p>Title: {{ $post->title }}</p>
                        <p>Price: ${{ $post->price }}</p>
                    </div>

                    <form action="{{ route('payment.process', $post) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Payment Method
                            </label>
                            <select name="payment_method" class="rounded-md border-gray-300 w-full">
                                <option value="e-wallet">E-Wallet</option>
                                <option value="bank-transfer">Bank Transfer</option>
                                <option value="credit-card">Credit Card</option>
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Process Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>